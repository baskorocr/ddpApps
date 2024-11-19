<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('identifier', 'password');

        // Determine if the identifier is email or NPK
        $loginType = filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'npk';

        // Attempt login using either email or NPK
        if (!Auth::attempt([$loginType => $credentials['identifier'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            return back()->withErrors([
                'identifier' => __('auth.failed'),
            ]);
        }

        // Regenerate session
        $request->session()->regenerate();

        // Get authenticated user
        $user = auth()->user();

        // Redirect based on user role
        if ($user->role == 'supervisor') {
            return redirect()->route('supervisor.dashboard');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'users') {
            return redirect()->route('users.dashboard');
        } elseif ($user->role == 'client') {
            return redirect()->route('client.dashboard');
        }

        // Fallback if no specific role found
        return redirect()->route('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}