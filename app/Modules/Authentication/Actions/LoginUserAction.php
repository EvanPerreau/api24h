<?php

namespace App\Modules\Authentication\Actions;

use App\Modules\Authentication\Models\DTO\TokenCoupleDTO;
use App\Modules\Authentication\Models\DTO\LoginUserRequestDTO;
use App\Modules\Authentication\Models\Entities\User;
use App\Modules\Authentication\Services\TokenGenerationService;
use App\Modules\Exceptions\Http\HttpForbiddenException;
use App\Modules\Exceptions\Http\HttpUnauthorizedException;

class LoginUserAction
{
    public function __construct(private readonly TokenGenerationService $tokenGenerationService) {}

    /**
     * @throws HttpUnauthorizedException
     * @throws HttpForbiddenException
     */
    public function execute(LoginUserRequestDTO $dto): TokenCoupleDTO
    {
        if (filter_var($dto->identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::query()->where('email', $dto->identifier)->first();
        } else {
            $user = User::query()->where('name', $dto->identifier)->first();
        }
        if (!$user || !password_verify($dto->password, $user->password)) {
            throw new HttpUnauthorizedException('Invalid email or password');
        }
        if (!$user->email_verified_at) {
            throw new HttpForbiddenException('Email not verified', extraData: ['email' => $user->email]);
        }

        return $this->tokenGenerationService->generateCouple($user);
    }
}
