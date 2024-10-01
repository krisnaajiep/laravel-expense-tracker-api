<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\VerificationUrl;
use Illuminate\Auth\Notifications\VerifyEmail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, VerificationUrl $verification_url)
    {
        $request->validate(['verification_url' => 'required|url:http,https']);

        VerifyEmail::createUrlUsing(function (object $notifiable) use ($request, $verification_url) {
            return $verification_url($notifiable, $request->verification_url);
        });

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent!']);
    }
}
