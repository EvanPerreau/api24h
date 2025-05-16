<?php

namespace App\Modules\Authentication\Actions;

use App\Modules\Authentication\Models\DTO\ResendVerificationEmailRequestDTO;
use App\Modules\Authentication\Models\Entities\EmailVerificationCode;
use App\Modules\Authentication\Models\Entities\User;
use App\Modules\Authentication\Services\EmailVerificationService;
use App\Modules\Exceptions\Http\HttpForbiddenException;

class ResendVerificationEmailAction
{
    public function __construct(private readonly EmailVerificationService $emailVerificationService) {}

    /**
     * @throws HttpForbiddenException
     */
    public function execute(ResendVerificationEmailRequestDTO $dto): void
    {
        $user = User::query()->where('email', $dto->email)->first();
        if ($user->email_verified_at) throw new HttpForbiddenException("User email is already verified");
        if (EmailVerificationCode::query()->where('user_id', $user->id)->first()
                ->created_at->diffInMinutes() < config('auth.verification.resend_email_timeout')) throw new HttpForbiddenException("Please wait " . config('auth.verification.resend_email_timeout') ." minute before resending email verification");
        EmailVerificationCode::query()->where('user_id', $user->id)->delete();
        if ($user) $this->emailVerificationService->sendEmailVerification($user);
    }
}
