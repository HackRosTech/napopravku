<?php

namespace App\Services\File;

use App\Services\File\Contracts\UploadServiceContract;
use Illuminate\Support\Facades\Storage;

class UploadService implements UploadServiceContract
{
    /**
     * Сохранение файла в хранилище, и возвращение FileCollection
     *
     * @param $file
     * @param $user_id
     * @param $directory_id
     * @return FileCollection
     */
    public function file($file, $user_id, $directory_id, $file_retention_period_at): FileCollection
    {
        $name = $file->hashName();

        $upload = Storage::disk('local')->put('files', $file);

        $hash = hash_file(
            'sha256',
            storage_path(
                path: 'app\files\\' . "{$name}",
            ),
        );

        return new FileCollection(
            name: "{$name}",
            originalName: $file->getClientOriginalName(),
            mime: $file->getClientMimeType(),
            path: $upload,
            disk: 'test',
            hash: $hash,
            size: $file->getSize(),
            directory_id: $directory_id,
            collection: 'avatars',
            file_retention_period_at: $file_retention_period_at,
            user_id: $user_id,
        );
    }
}
