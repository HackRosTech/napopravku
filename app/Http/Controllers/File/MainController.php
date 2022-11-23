<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\UploadRequest;
use App\Http\Requests\FileRequest;
use App\Http\Resources\File\IndexResource;
use App\Http\Resources\File\SizeFileInDirectoryResource;
use App\Http\Resources\File\SizeFileOnDiscResource;
use App\Http\Resources\User\UploadResource;
use App\Models\File;
use App\Services\File\Contracts\UploadServiceContract;
use App\Services\File\UploadService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function __construct(private readonly UploadService $service) {}

    /**
     * Список всех файлов текущего пользователя
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $files = File::query()
            ->with('directory')
            ->where('user_id', Auth::id())
            ->get();

        return response()
            ->json(IndexResource::collection($files));
    }

    /**
     * Загрузка файла с проверкой типа и размера,
     * с возможностью указывать срок хранения файла
     *
     * @param FileRequest $request
     * @return JsonResponse
     */
    public function upload(FileRequest $request)
    {
        $file = $this->service->file(
            file: $request->file('file'),
            user_id: Auth::id(),
            directory_id: $request->post('directory_id'),
            file_retention_period_at: $request->post('file_retention_period_at'),
        );

        $response = File::query()->create(
            attributes: $file->toArray(),
        );

        return response()
            ->json(new UploadResource($response));
    }

    /**
     * Переименование файла
     *
     * @param UploadRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function rename(UploadRequest $request, int $id): JsonResponse
    {
        $file = File::findOrFail($id);

        Gate::authorize('rename', $file);

        $file->update($request->only('file_name'));
        return response()
            ->json($file);
    }


    /**
     * Удаление файла
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $file = File::findOrFail($id);

        Gate::authorize('destroy', $file);

        unlink($file->path);

        $file->delete();

        return response()
            ->json(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * Скачивание файла
     *
     * @param int $id
     * @return BinaryFileResponse
     */
    public function download(int $id): BinaryFileResponse
    {
        $file = File::findOrFail($id);

        Gate::authorize('download', $file);

        $path = Storage::disk('local')->path($file->path);

        return response()
            ->download($path, basename($path));
    }


    /**
     * Общий размер файлов в одной директории
     *
     * @param int $id
     * @return JsonResponse
     */
    public function sizeFilesInDirectory(int $id): JsonResponse
    {
        $size = File::query()
            ->select( DB::raw('SUM(size) as size'))
            ->where('directory_id', $id)
            ->where('user_id', Auth::id())
            ->groupBy('size')
            ->firstOrFail();

        return response()
            ->json(new SizeFileInDirectoryResource($size));
    }

    /**
     * Общий размер файлов на диске пользователя
     *
     * @return JsonResponse
     */
    public function sizeFilesOnDisk(): JsonResponse
    {
        $size = File::query()
            ->select( DB::raw('SUM(size) as size'))
            ->where('user_id', Auth::id())
            ->groupBy('size')
            ->firstOrFail();

        return response()
            ->json(new SizeFileOnDiscResource($size));
    }
}

