<?php

namespace App\Modules\Authentication\Http\Requests;

use App\Modules\Authentication\Models\DTO\CreateUserRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
    }

    public function toDTO(): CreateUserRequestDTO
    {
        $validated = $this->validated();

        return new CreateUserRequestDTO(
            $validated['name'],
            $validated['email'],
            $validated['password'],
        );
    }
}
