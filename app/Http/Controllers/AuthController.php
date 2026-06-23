<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    // ── Student branch picker ──────────────────────────────────────────────────
    public function showStudentPicker()
    {
        $branches = Branch::chapters()->orderBy('name')->get(['id', 'name', 'academic_year']);
        return view('login-student', compact('branches'));
    }

    public function loginAsStudent(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Prefer the branch_admin; fall back to any member of that branch
        $user = User::where('branch_id', $request->branch_id)
            ->where('role', 'branch_admin')
            ->first()
            ?? User::where('branch_id', $request->branch_id)->firstOrFail();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('student.overview');
    }

    // ── Standard credential login (admin or student with password) ────────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('student.overview'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}