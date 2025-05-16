<?php

namespace App\Modules\Authentication\Actions;

use App\Modules\Authentication\Http\Requests\RefreshTokenRequest;
use App\Modules\Authentication\Models\DTO\TokenCoupleDTO;
use App\Modules\Authentication\Models\DTO\RefreshTokenRequestDTO;
use App\Modules\Authentication\Models\Entities\User;
use App\Modules\Authentication\Services\TokenGenerationService;

class RefreshTokenAction
{
    public function __construct(private readonly TokenGenerationService $tokenGenerationService){}

    public function execute(RefreshTokenRequestDTO $request): TokenCoupleDTO
    {
        /** @var  $user User */
        $user = auth()->user();
        $user->tokens()->delete();
        return $this->tokenGenerationService->generateCouple($user);
    }
}
