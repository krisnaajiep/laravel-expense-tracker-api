<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an login attempt.
     */
    public function store(Request $request): RedirectResponse
    {
        $response = Http::post('http://expense-tracker-api.test/api/auth/login', $request->all());

        if ($response->status() === 422)
            return back()->withErrors($response->json('errors'))->onlyInput('email');

        if ($response->status() === 401)
            return back()->with(['status' => 'Invalid email or password.', 'type' => 'danger'])->onlyInput('email');

        session([
            'jwt_token' => $response->json('access_token'),
            'jwt_exp' => now()->timestamp + $response->json('expires_in')
        ]);

        $user = Http::withToken(session('jwt_token'))->get('http://expense-tracker-api.test/api/auth/me');

        session(['user' => $user->object()]);

        return redirect()->intended('dashboard');
    }

    /**
     * Refresh a token.
     */

    public function refresh()
    {
        $response = Http::withToken(session('jwt_token'))->post('http://expense-tracker-api.test/api/auth/refresh');

        session([
            'jwt_token' => $response->json('access_token'),
            'jwt_exp' => now()->timestamp + $response->json('expires_in')
        ]);

        return back();
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Http::withToken(session('jwt_token'))->post('http://expense-tracker-api.test/api/auth/logout');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }
}
