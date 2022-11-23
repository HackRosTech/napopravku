<?php

namespace App\Http\Middleware;

use App\Models\File;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSize
{

    /**
     * Проверка объёма всех файлов на диске
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sumSize = File::query()
            ->select('size')
            ->where('user_id', Auth::id())
            ->sum('size');

        $sumSize = $request->file('file')->getSize() + $sumSize;

        if (($sumSize / 1e+6) > 100) {
            abort(403,'Лимит вашего диска исчерпан');
        }

        return $next($request);
    }
}
