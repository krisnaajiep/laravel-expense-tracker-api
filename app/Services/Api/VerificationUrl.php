<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\URL;

class VerificationUrl
{
  public function __invoke(object $notifiable, string $verification_url): string
  {
    $signedUrl = URL::temporarySignedRoute(
      'verification.verify',
      now()->addMinutes(60),
      [
        'id' => $notifiable->id,
        'hash' => sha1($notifiable->getEmailForVerification()),
      ]
    );

    return $verification_url . explode('verify', $signedUrl)[1];
  }
}
