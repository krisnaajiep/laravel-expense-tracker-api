<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(Request $request)
    {
        $response = Http::post('http://expense-tracker-api.test/api/auth/reset-password', $request->all());

        if ($response->status() === 422)
            return back()->withErrors($response->json('errors'))->onlyInput('email');

        if ($response->status() === 404)
            return back()->with(['status' => $response->json('email')[0], 'type' => 'danger'])->onlyInput('email');

        return redirect('/auth/login')->with(['status' => $response->json('status'), 'type' => 'success']);
    }
}
