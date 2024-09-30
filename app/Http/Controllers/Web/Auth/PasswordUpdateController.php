<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasswordUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $response = Http::withToken(session('jwt_token'))->put('http://expense-tracker-api.test/api/auth/update-password', $request->all());

        if ($response->status() === 422)
            return back()->withErrors($response->json('errors'))->withInput();

        return back()->with(['status' => $response->json('status'), 'type' => 'success']);
    }
}
