<?php

namespace App\Http\Controllers;


use OpenApi\Attributes\Components;
use OpenApi\Attributes\Info;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\SecurityScheme;

use OpenApi\Attributes as OA;

#[Info(version: '0.1.0', title: 'P24H API')]
#[Components(
    schemas: [
        new Schema(
            schema: 'PaginationMeta',
            properties: [
                new Property(property: 'page', type: 'integer'),
                new Property(property: 'per_page', type: 'integer'),
                new Property(property: 'total', type: 'integer'),
            ],
        ),
    ],
    securitySchemes: [
        new OA\SecurityScheme(
            securityScheme: 'bearerAuth',
            type: 'http',
            description: 'Token with auth ability',
            scheme: 'bearer'
        )
    ]
)]
abstract class Controller
{
    //
}
