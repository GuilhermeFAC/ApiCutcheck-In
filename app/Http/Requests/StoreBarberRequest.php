<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreBarberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'min:6'],
            'email' => ['required', 'unique:barbers', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'endereco' => ['required', 'max:255', 'string'],
            'cidade' => ['required', 'max:255', 'string'],
            'estado' => ['required', 'max:2', 'min:2', 'string'],
            'telefone' => ['required', 'max:11', 'string'],
            'type_user' => ['required', 'max:255', 'string'],
            'avatar' => ['nullable', 'max:255', 'string'],
            'stars' => ['numeric']
        ];
    }
}
