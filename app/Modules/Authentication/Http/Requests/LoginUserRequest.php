<?php

namespace App\Modules\Authentication\Http\Requests;

use App\Modules\Authentication\Models\DTO\CreateUserRequestDTO;
use App\Modules\Authentication\Models\DTO\LoginUserRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'identifier' => 'required|string',
            'password' => 'required|string|min:8',
        ];
    }

    public function toDTO(): LoginUserRequestDTO
    {
        $validated = $this->validated();

        return new LoginUserRequestDTO(
            $validated['identifier'],
            $validated['password']
        );
    }
}
