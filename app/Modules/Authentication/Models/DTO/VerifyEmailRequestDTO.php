<?php

namespace App\Modules\Authentication\Models\DTO;

use App\Modules\Authentication\Models\Entities\User;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    title: "VerifyEmailRequestDTO",
    description: "Data to verify user's email",
    properties: [
        new Property(
            property: "email",
            description: "User's email",
            type: "string",
        ),
        new Property(
            property: "code",
            description: "Verification code",
            type: "string",
        ),
    ],
)]
readonly class VerifyEmailRequestDTO
{
    public function __construct(
        public User $user,
        public string $code,
    ) {}
}
