<?php

namespace App\Http\Requests;
use Illuminate\Validation\Validator;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'postal_code' => 'required',
            'address' => 'required',
            'building'    => 'nullable',
            'payment' => [
                'required',
                'in:1,2',
            ],
        ];
    }

    public function messages()
    {
        return [
            'postal_code.required' => '配送先を指定してください',
            'address.required' => '配送先を指定してください',

            'payment.required' => '支払い方法を選択してください',
            'payment.in' => '支払い方法を選択してください',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (
                $validator->errors()->has('postal_code') ||
                $validator->errors()->has('address')
            ) {
                $validator->errors()->add(
                    'delivery-address',
                    '配送先を指定してください'
                );
            }
        });
    }
}
