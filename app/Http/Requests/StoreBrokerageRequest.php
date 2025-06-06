<?php

namespace App\Http\Requests;

use App\Rules\Cnpj;
use Illuminate\Foundation\Http\FormRequest;

class StoreBrokerageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'site' => 'url|required',
            'cnpj' => ['required', new Cnpj]
        ];
    }
}
