<?php

namespace App\Modules\Authentication\Services;

use App\Modules\Authentication\Models\DTO\TokenCoupleDTO;
use App\Modules\Authentication\Models\Entities\User;

class TokenGenerationService
{
    function generateCouple(User $user): TokenCoupleDTO
    {
        return new TokenCoupleDTO(
            $this->generateAccessToken($user),
            $this->generateRefreshToken($user)
        );
    }

    private function generateAccessToken(User $user): string
    {
        return $user->createToken('authToken', ['auth'], now()->addMinutes(60))->plainTextToken;
    }

    private function generateRefreshToken(User $user): string
    {
        return $user->createToken('refreshToken', ['refresh'], now()->addDays(7))->plainTextToken;
    }
}
