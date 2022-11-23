<?php

namespace App\Services\File;

use JetBrains\PhpStorm\ArrayShape;

class FileCollection
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $originalName,
        public readonly string  $mime,
        public readonly string  $path,
        public readonly string  $disk,
        public readonly string  $hash,
        public readonly int     $size,
        public readonly ?int    $directory_id = null,
        public readonly ?string $collection = null,
        public readonly ?string $file_retention_period_at = null,
        public readonly int     $user_id
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'file_name' => $this->originalName,
            'mime_type' => $this->mime,
            'path' => $this->path,
            'disk' => $this->disk,
            'file_hash' => $this->hash,
            'size' => $this->size,
            'collection' => $this->collection,
            'directory_id' => $this->directory_id,
            'file_retention_period_at' => $this->file_retention_period_at,
            'user_id' => $this->user_id,
        ];
    }
}
