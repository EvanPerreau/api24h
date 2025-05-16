<?php

namespace App\Modules\Authentication\Http\Requests;

use App\Modules\Authentication\Models\DTO\CreateUserRequestDTO;
use App\Modules\Authentication\Models\DTO\VerifyEmailRequestDTO;
use App\Modules\Authentication\Models\Entities\User;
use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
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
            'email' => 'required|string|exists:users,email',
            'code' => 'required|string|max:6',
        ];
    }

    public function toDTO(): VerifyEmailRequestDTO
    {
        $validated = $this->validated();

        return new VerifyEmailRequestDTO(
            User::query()->where('email', $validated['email'])->firstOrFail(),
            $validated['code']
        );
    }
}
