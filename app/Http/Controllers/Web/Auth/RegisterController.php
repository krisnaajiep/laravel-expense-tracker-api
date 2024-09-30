<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['verification_url' => 'http://expense-tracker-api.test/auth/email/verify']);

        $response = Http::post('http://expense-tracker-api.test/api/auth/register', $request->all());

        if ($response->status() === 422)
            return back()->withErrors($response->json('errors'))->withInput();

        if ($response->status() === 201) {
            session([
                'jwt_token' => $response->json('access_token'),
                'jwt_exp' => now()->timestamp + $response->json('expires_in')
            ]);

            $user = Http::withToken(session('jwt_token'))->get('http://expense-tracker-api.test/api/auth/me');

            session(['user' => $user->object()]);

            return redirect('/dashboard');
        }

        return $response->json();
    }
}
