<?php

namespace App\Modules\Authentication\Http\Requests;

use App\Modules\Authentication\Models\DTO\ResendVerificationEmailRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

class ResendVerificationEmailRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email'
        ];
    }

    public function toDTO(): ResendVerificationEmailRequestDTO
    {
        $validated = $this->validated();

        return new ResendVerificationEmailRequestDTO(
            $validated['email']
        );
    }
}
