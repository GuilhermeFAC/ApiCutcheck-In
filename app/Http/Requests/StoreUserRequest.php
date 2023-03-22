<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


class StoreUserRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'max:255', 'min:6'],
            'email' => ['required', 'unique:users', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'endereco' => ['required', 'max:255', 'string'],
            'cidade' => ['required', 'max:255', 'string'],
            'estado' => ['required', 'max:2', 'min:2', 'string'],
            'telefone' => ['required', 'max:11', 'string'],
            'type_user' => ['required', 'max:255', 'string'],
            'avatar' => ['nullable', 'max:255', 'string'],
        ];

        if ($this->method() === 'PATCH') {
            $rules['name'] = ['nullable', 'max:255', 'min:6'];
            $rules['email'] = ["unique:barbers,email,{$this->id}", 'email', 'max:255'];
            $rules['password'] = ['nullable', Password::defaults()];
            $rules['endereco'] = ['nullable', 'max:255', 'string'];
            $rules['cidade'] = ['nullable', 'max:255', 'string'];
            $rules['estado'] = ['nullable', 'max:2', 'min:2', 'string'];
            $rules['telefone'] = ['nullable', 'max:11', 'string'];
            $rules['type_user'] = ['nullable', 'max:255', 'string'];
            $rules['avatar'] = ['nullable', 'max:255', 'string'];
        }

        return $rules;
    }
}
