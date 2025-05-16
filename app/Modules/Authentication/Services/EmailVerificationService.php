<?php

namespace App\Modules\Authentication\Services;

use App\Modules\Authentication\Mails\EmailVerification;
use App\Modules\Authentication\Models\Entities\EmailVerificationCode;
use App\Modules\Authentication\Models\Entities\User;
use Illuminate\Support\Facades\Mail;

class EmailVerificationService
{
    public function __construct(private readonly CodeGenerationService $codeGenerationService) {}

    function sendEmailVerification(User $user): void
    {
        $code = $this->codeGenerationService->generateDigits(6);
        $token = new EmailVerificationCode();
        $token->user_id = $user->id;
        $token->code = $code;
        $token->save();

        Mail::queue(new EmailVerification(
            recipient: $user,
            code: $code,
        ));
    }
}
