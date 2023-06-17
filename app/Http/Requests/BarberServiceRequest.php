<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarberServiceRequest extends FormRequest
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
            'barber_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255', 'min:6'],
            'price' => ['required', 'numeric'],
        ];

        if ($this->method() === 'PATCH') {
            $rules['barber_id'] = ['nullable'];
            $rules['name'] = ['string', 'max:255', 'min:6'];
            $rules['price'] = ['numeric'];
        }
        return $rules;
    }
}
