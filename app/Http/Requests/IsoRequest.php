<?php

namespace App\Http\Requests;

use App\Rules\IsoRule;
use Illuminate\Foundation\Http\FormRequest;

class IsoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'min:3', new IsoRule],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'O campo code é obrigatório.',
            'code.min' => 'O campo code deve ter pelo menos 3 caracteres.',
        ];
    }
}
