<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// TEMPORARY — remove this file and revert routes/web.php + bootstrap/app.php to restore auth
class DevBypassAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            $user = User::whereNotNull('branch_id')->first() ?? User::first();
            if ($user) {
                Auth::login($user);
            }
        }
        return $next($request);
    }
}
