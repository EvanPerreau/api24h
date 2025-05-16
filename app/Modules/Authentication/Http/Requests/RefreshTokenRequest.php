<?php

namespace App\Modules\Authentication\Http\Requests;

use App\Modules\Authentication\Models\DTO\RefreshTokenRequestDTO;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

class RefreshTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'refresh_token' => 'required|string'
        ];
    }

    public function toDTO(): RefreshTokenRequestDTO
    {
        $validated = $this->validated();

        return new RefreshTokenRequestDTO(
            $validated['refresh_token']
        );
    }
}
