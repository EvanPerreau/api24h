<?php

namespace App\Modules\Authentication\Models\DTO;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(title: 'RefreshTokenRequest', description: 'Refresh token request data transfer object', properties: [
    new Property(property: 'refreshToken', description: 'Refresh token', type: 'string')
])]
readonly class RefreshTokenRequestDTO
{
    public function __construct(
        public string $refreshToken
    ) {}
}
