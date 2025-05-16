<?php

namespace App\Modules\Authentication\Actions;

use App\Modules\Authentication\Models\DTO\VerifyEmailRequestDTO;
use App\Modules\Authentication\Models\Entities\EmailVerificationCode;
use App\Modules\Exceptions\Http\HttpForbiddenException;
use App\Modules\Exceptions\Http\HttpUnauthorizedException;

class VerifyUserEmailAction
{
    public function __construct(
    ) {}

    /**
     * @throws HttpUnauthorizedException
     * @throws HttpForbiddenException
     */
    public function execute(VerifyEmailRequestDTO $request): void
    {
        $emailVerificationCode = EmailVerificationCode::query()
            ->where('user_id', $request->user->id)
            ->where('code', $request->code)
            ->first();
        if ($emailVerificationCode === null) {
            throw new HttpUnauthorizedException('Invalid verification code');
        } else if ($emailVerificationCode->created_at->diffInMinutes(now()) > 15) {
            throw new HttpForbiddenException('Verification code expired');
        } else {
            $emailVerificationCode->delete();
            $request->user->email_verified_at = now();
            $request->user->save();
        }
    }
}
