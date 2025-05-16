<?php

namespace App\Modules\Authentication\Models\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(title: 'LoginUserRequestDTO', description: 'Login user request data transfer object', properties: [
    new Property(property: 'identifier', description: 'User email or name', type: 'string'),
    new Property(property: 'password', description: 'User password', type: 'string')
])]
readonly class LoginUserRequestDTO
{
    function __construct(
        public string $identifier,
        public string $password
    ) {}
}
