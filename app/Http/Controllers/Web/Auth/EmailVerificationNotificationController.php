<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $verification_url = 'http://expense-tracker-api.test/auth/email/verify';

        $response = Http::withToken(session('jwt_token'))->post('http://expense-tracker-api.test/api/auth/email/verification-notification', ['verification_url' => $verification_url]);

        $type = $response->status() === 429 ? 'danger' : 'success';

        return back()->with(['status' => $response->json('message'), 'type' => $type]);
    }
}
