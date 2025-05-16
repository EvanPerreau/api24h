<?php

namespace App\Modules\Authentication\Models\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(title: 'ResendVerificationEmailRequestDTO', description: 'Resend verification email request data transfer object', properties: [
    new Property(property: 'email', description: 'User email', type: 'string')
])]
readonly class ResendVerificationEmailRequestDTO
{
    function __construct(
        public string $email
    ) {}
}
