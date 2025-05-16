<?php

namespace App\Modules\Authentication\Models\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(title: 'TokenCoupleDTO', description: 'Token couple data transfer object', properties: [
    new Property(property: 'access_token', description: 'Access token', type: 'string'),
    new Property(property: 'refresh_token', description: 'Refresh token', type: 'string')
])]
readonly class TokenCoupleDTO
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken
    ) {}
}
