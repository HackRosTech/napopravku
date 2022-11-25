<?php

namespace App\Http\Controllers\Directory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Directory\CreateRequest;
use App\Http\Resources\Directory\CreateResource;
use App\Models\Directory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Создание директории
     *
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $directory = Directory::create([
            'title' => $request->input('title'),
            'user_id' => Auth::id(),
        ]);

        return response()
            ->json(new CreateResource($directory));
    }
}
