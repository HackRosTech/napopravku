<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class FilePolicy
{
    use HandlesAuthorization;

    public function rename(User $user, File $file): Response
    {
        return $file->user_id === $user->id
            ? Response::allow()
            : Response::denyWithStatus(403);
    }

    public function download(User $user, File $file): Response
    {
        return $file->user_id === $user->id
            ? Response::allow()
            : Response::denyWithStatus(403);
    }


    public function destroy(User $user, File $file): Response
    {
        return $file->user_id === $user->id
            ? Response::allow()
            : Response::denyWithStatus(403);
    }

    public function createLink(User $user, File $file): Response
    {
        return $file->user_id === $user->id
            ? Response::allow()
            : Response::denyWithStatus(403);
    }
}
