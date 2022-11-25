<?php

namespace App\Http\Middleware;

use App\Models\Directory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDirectory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $directory_id = $request->input('directory_id');

        if (empty($directory_id)) {
            return $next($request);
        }

        $directory = Directory::find($directory_id);

        if ($directory->user_id !== Auth::id()) {
            abort(403, 'Такой директории не существует');
        }

        return $next($request);
    }
}
