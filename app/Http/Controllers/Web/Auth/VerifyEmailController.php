<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request)
    {
        $response = Http::withToken(session('jwt_token'))->get('http://expense-tracker-api.test/api/auth/email/verify' . explode('verify', $request->fullUrl())[1]);

        if ($response->status() === 403) abort(403, 'Invalid Signature');

        $user = Http::withToken(session('jwt_token'))->get('http://expense-tracker-api.test/api/auth/me');

        session(['user' => $user->object()]);

        return redirect('/dashboard')->with(['status' => $response->json('message'), 'type' => 'success']);
    }
}
