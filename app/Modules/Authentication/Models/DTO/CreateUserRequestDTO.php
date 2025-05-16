<?php

namespace App\Modules\Authentication\Models\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    title: "CreateUserRequestDTO",
    description: "Data to create a new user",
    properties: [
        new Property(
            property: "name",
            description: "User's name",
            type: "string",
            example: "John Doe",
        ),
        new Property(
            property: "email",
            description: "User's email",
            type: "string",
            example: "john.doe@gmail.com",
        ),
        new Property(
            property: "password",
            description: "User's password",
            type: "string",
            minimum: 8,
            example: "password",
        ),
    ]
)]
readonly class CreateUserRequestDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
