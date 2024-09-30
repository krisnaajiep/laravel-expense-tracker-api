<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => session('user'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $response = Http::withToken(session('jwt_token'))->put('http://expense-tracker-api.test/api/profile', $request->all());

        if ($response->status() === 422)
            return back()->withErrors($response->json('errors'))->withInput();

        $user = Http::withToken(session('jwt_token'))->get('http://expense-tracker-api.test/api/auth/me');

        session(['user' => $user->object()]);

        return back()->with(['status' => $response->json('status'), 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $response = Http::withToken(session('jwt_token'))->delete('http://expense-tracker-api.test/api/profile', $request->all());

        if ($response->status() === 422)
            return back()->with(['status' => $response->json('errors')['password'][0], 'type' => 'warning']);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login')->with(['status' => $response->json('status'), 'type' => 'success']);
    }
}
