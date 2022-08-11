<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
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
            'codigo' => 'required',
            'descricao' => 'required',
            'id_assets_type' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'codigo' => 'código',
            'descricao' => 'descrição',
            'id_assets_type' => 'tipo de ativo',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'codigo.required' => 'O campo código é obrigatório',
    //         'descricao.required' => 'O campo descrição é obrigatório',
    //         'id_assets_type.required' => 'O campo tipo de ativo é obrigatório',
    //     ];
    // }
}
