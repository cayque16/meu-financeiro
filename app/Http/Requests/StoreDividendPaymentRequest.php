<?php

namespace App\Http\Requests;

use Core\Domain\Enum\DividendType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreDividendPaymentRequest extends FormRequest
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
            'id_asset' => 'required',
            'id_currency' => 'required',
            'fiscal_year' => 'required|int|between:1901,2155',
            'payment_date' => 'required',
            'type' => ['required', new Enum(DividendType::class)],
            'amount' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'id_asset' => 'ativo',
            'id_currency' => 'moeda',
            'fiscal_year' => 'ano fiscal',
            'payment_date' => 'data do pagamento',
            'type' => 'tipo',
            'amount' => 'valor',
        ];
    }
}
