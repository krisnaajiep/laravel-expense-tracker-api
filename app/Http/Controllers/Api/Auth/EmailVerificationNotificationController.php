<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\VerificationUrl;
use Illuminate\Auth\Notifications\VerifyEmail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected VerificationUrl $verificationUrl,
    ) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['verification_url' => 'required|url:http,https']);

        VerifyEmail::createUrlUsing(function (object $notifiable) use ($request) {
            return $this->verificationUrl->generate($notifiable, $request->verification_url);
        });

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent!']);
    }
}
