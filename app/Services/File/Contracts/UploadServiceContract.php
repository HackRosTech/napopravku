<?php

namespace App\Services\File\Contracts;

use App\Models\File;

interface UploadServiceContract
{
    public function file($file, $user_id, $directory_id, $file_retention_period_at);
}
