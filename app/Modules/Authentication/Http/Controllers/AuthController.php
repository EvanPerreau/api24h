<?php

namespace App\Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Actions\CreateUserAction;
use App\Modules\Authentication\Actions\LoginUserAction;
use App\Modules\Authentication\Actions\RefreshTokenAction;
use App\Modules\Authentication\Actions\ResendVerificationEmailAction;
use App\Modules\Authentication\Actions\VerifyUserEmailAction;
use App\Modules\Authentication\Http\Requests\CreateUserRequest;
use App\Modules\Authentication\Http\Requests\LoginUserRequest;
use App\Modules\Authentication\Http\Requests\RefreshTokenRequest;
use App\Modules\Authentication\Http\Requests\ResendVerificationEmailRequest;
use App\Modules\Authentication\Http\Requests\VerifyEmailRequest;
use App\Modules\Exceptions\Http\HttpForbiddenException;
use App\Modules\Exceptions\Http\HttpInternalServerException;
use App\Modules\Exceptions\Http\HttpUnauthorizedException;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Patch;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;

class AuthController extends Controller
{
    /**
     * @throws HttpInternalServerException
     */
    #[
        Post(path: '/api/auth/create', tags: ['Authentication']),
        Response(response: 201, description: 'user created'),
        Response(response: 422, description: 'invalid input'),
        Response(response: 500, description: 'internal server error'),
        RequestBody(required: true, content: [new JsonContent(ref: '#/components/schemas/CreateUserRequestDTO')])
    ]
    function create(CreateUserRequest $request, CreateUserAction $action): JsonResponse
    {
        $action->execute($request->toDTO());
        return response()->json(['message' => 'User created'], 201);
    }

    /**
     * @throws HttpUnauthorizedException
     * @throws HttpForbiddenException
     */
    #[
        Patch(path: '/api/auth/verify-email', tags: ['Authentication']),
        Response(response: 200, description: 'email verified'),
        Response(response: 422, description: 'invalid input'),
        Response(response: 401, description: 'invalid verification code'),
        Response(response: 403, description: 'verification code expired'),
        RequestBody(required: true, content: [new JsonContent(ref: '#/components/schemas/VerifyEmailRequestDTO')])
    ]
    function verifyEmail(VerifyEmailRequest $request, VerifyUserEmailAction $action): JsonResponse
    {
        $action->execute($request->toDTO());
        return response()->json(['message' => 'Email verified']);
    }

    /**
     * @throws HttpForbiddenException
     */
    #[
        Post(path: '/api/auth/resend-verification-email', tags: ['Authentication']),
        Response(response: 200, description: 'verification email sent'),
        Response(response: 422, description: 'invalid input'),
        Response(response: 403, description: 'email already verified or too many attempts'),
        RequestBody(required: true, content: [new JsonContent(ref: '#/components/schemas/ResendVerificationEmailRequestDTO')])
    ]
    function resendVerificationEmail(ResendVerificationEmailRequest $request, ResendVerificationEmailAction $action): JsonResponse
    {
        $action->execute($request->toDTO());
        return response()->json(['message' => 'Verification email sent']);
    }

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
}
