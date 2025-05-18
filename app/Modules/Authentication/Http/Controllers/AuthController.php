<?php

namespace App\Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Actions\LoginUserAction;
use App\Modules\Authentication\Actions\RefreshTokenAction;
use App\Modules\Authentication\Http\Requests\LoginUserRequest;
use App\Modules\Authentication\Http\Requests\RefreshTokenRequest;
use App\Modules\Exceptions\Http\HttpForbiddenException;
use App\Modules\Exceptions\Http\HttpUnauthorizedException;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;

class AuthController extends Controller
{
    /**
     * @throws HttpUnauthorizedException
     * @throws HttpForbiddenException
     */
    #[
        Post(path: '/api/auth/login', tags: ['Authentication']),
        Response(response: 200, description: 'login', content: new JsonContent(ref: '#/components/schemas/TokenCoupleDTO')),
        Response(response: 401, description: 'invalid email or password'),
        Response(response: 403, description: 'email not verified'),
        Response(response: 422, description: 'invalid input'),
        RequestBody(required: true, content: [new JsonContent(ref: '#/components/schemas/LoginUserRequestDTO')])
    ]
    function login(LoginUserRequest $request, LoginUserAction $action): JsonResponse
    {
        $cookieCouple = $action->execute($request->toDTO());
        return response()->json(['access_token' => $cookieCouple->accessToken, 'refresh_token' => $cookieCouple->refreshToken]);
    }

    #[
        Post(path: '/api/auth/refresh', security: ['bearerAuth'], tags: ['Authentication']),
        Response(response: 200, description: 'refreshed', content: new JsonContent(ref: '#/components/schemas/TokenCoupleDTO')),
        Response(response: 422, description: 'invalid input'),
        Response(response: 403, description: 'expired or invalid ability'),
        RequestBody(required: true, content: [new JsonContent(ref: '#/components/schemas/RefreshTokenRequestDTO')])
    ]
    function refresh(RefreshTokenRequest $request, RefreshTokenAction $action): JsonResponse
    {
        $cookieCouple = $action->execute($request->toDTO());
        return response()->json(['access_token' => $cookieCouple->accessToken, 'refresh_token' => $cookieCouple->refreshToken]);
    }

    #[
        Post(path: '/api/auth/logout', security: ['bearerAuth'], tags: ['Authentication']),
        Response(response: 200, description: 'logged out'),
        Response(response: 422, description: 'invalid input'),
        Response(response: 403, description: 'expired or invalid ability')
    ]
    function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    #[
        Get(path: '/api/auth/user', security: ['bearerAuth'], tags: ['Authentication']),
        Response(response: 200, description: 'user', content: new JsonContent(ref: '#/components/schemas/User')),
        Response(response: 422, description: 'invalid input'),
        Response(response: 403, description: 'expired or invalid ability')
    ]
    function user(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}
