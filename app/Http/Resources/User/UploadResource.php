<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'original_name' => $this->file_name,
            'name' => $this->name,
            'mime_type' => $this->mime_type,
            'path' => $this->path,
            'disk' => $this->disk,
            'size' => $this->size,
            'user_id' => $this->user_id,
            'directory_id' => $this->directory_id,
            'file_retention_period_at' => $this->file_retention_period_at,
        ];
    }
}
