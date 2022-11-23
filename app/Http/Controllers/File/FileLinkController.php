<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class FileLinkController extends Controller
{

    /**
     * Отображение файла по ссылке которая была
     * сформирована в методе store()
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $file = File::find($id)
            ->whereHas('links', function ($query) use ($request) {
                $query->where('token', $request->token);
            })
            ->firstOrFail();

        return response()
            ->json($file);
    }


    /**
     * Генерация уникальной публичной ссылки на файл
     *
     * @param Request $request
     * @param int $id
     * @return \string[][]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, int $id): array
    {
        $file = File::findOrFail($id);

        $this->authorize('create-link', $file);

        $link = $file->links()->firstOrCreate([], [
            'token' => hash_hmac('sha256', Str::random(40), $file->id)
        ]);

        return [
            'data' => [ // сформируем такую ссылку т.к. нет фронт. части
                'url' => env('APP_URL') . '/api/file/links/' . $id . '?token=' . $link->token
            ]
        ];
    }
}
