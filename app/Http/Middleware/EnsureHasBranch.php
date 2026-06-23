<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Guards the student dashboard: the whole section is scoped to the
 * logged-in user's chapter, so a user with no (or a soft-deleted) branch
 * is sent back to the chapter picker instead of hitting a null dereference.
 */
class EnsureHasBranch
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || ! Auth::user()->branch) {
            return redirect()->route('login.student')
                ->withErrors(['branch_id' => 'Please pick your student chapter to continue.']);
        }

        return $next($request);
    }
}
