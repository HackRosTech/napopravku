<?php

namespace App\Http\Resources\File;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|Arrayable
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'path' => $this->path,
            'disk' => $this->disk,
            'collection' => $this->collection,
            'directory' => new \App\Http\Resources\Directory\IndexResource($this->directory),
            'file_retention_period_at' => $this->file_retention_period_at,
        ];
    }
}
