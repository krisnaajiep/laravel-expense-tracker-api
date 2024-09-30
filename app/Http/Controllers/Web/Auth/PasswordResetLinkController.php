<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request)
    {
        $request->merge(['reset_url' => 'http://expense-tracker-api.test/auth/reset-password']);

        $response = Http::post('http://expense-tracker-api.test/api/auth/forgot-password', $request->all());

        if ($response->status() === 422)
            return back()->withErrors($response->json('errors'))->withInput();

        if ($response->status() === 404)
            return back()->with(['status' => $response->json('email'), 'type' => 'danger'])->onlyInput('email');

        return back()->with(['status' => $response->json('status'), 'type' => 'success']);
    }
}
