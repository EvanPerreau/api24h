<?php

namespace App\Modules\Authentication\Actions;

use App\Modules\Authentication\Models\DTO\TokenCoupleDTO;
use App\Modules\Authentication\Models\DTO\LoginUserRequestDTO;
use App\Modules\Authentication\Models\Entities\User;
use App\Modules\Authentication\Services\TokenGenerationService;
use App\Modules\Exceptions\Http\HttpForbiddenException;
use App\Modules\Exceptions\Http\HttpUnauthorizedException;
use Illuminate\Support\Facades\Http;

class LoginUserAction
{
    public function __construct(private readonly TokenGenerationService $tokenGenerationService) {}

    /**
     * @throws HttpUnauthorizedException
     * @throws HttpForbiddenException
     */
    public function execute(LoginUserRequestDTO $dto): TokenCoupleDTO
    {
        $response = Http::post('https://api24h.82.29.175.123.nip.io/api/intra/info/authentification/BIC-aca76df0-9469', [
            'login' => $dto->identifier,
            'password' => $dto->password,
        ]);

        if ($response->failed()) {
            throw new HttpUnauthorizedException('Invalid email or password');
        } else {
            $data = $response->json();
            if (User::query()->where('name', $data["nom"])->exists()) {
                $user = User::query()->where('name', $data["nom"])->first();
                return $this->tokenGenerationService->generateCouple($user);
            } else {
                $user = new User();
                $user->name = $data["nom"];
                $user->prenom = $data["prenom"];
                $user->role = $data["droit"];
                $user->save();
                return $this->tokenGenerationService->generateCouple($user);
            }
        }
    }
}
