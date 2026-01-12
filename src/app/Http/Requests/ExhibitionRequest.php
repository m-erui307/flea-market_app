<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'product_name' => 'required',
            'explanation' => 'required|max:255',
            'product_image' => 'required|mimes:jpeg,png',
            'category_ids' => 'required|array|min:1',
            'condition' => 'required',
            'price'=> 'required|integer|min:0'
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名を入力してください',
            'explanation.required' => '商品の説明を入力してください',
            'explanation.max' => '商品の説明は255文字以内で入力してください',
            'product_image.required' => '商品画像をアップロードしてください',
            'product_image.mimes' => '画像は「.jpeg」または「.png」形式のみアップロードできます',
            'category_ids.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態をしてください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は整数で入力してください',
            'price.min' => '販売価格は0円以上で入力してください'
        ];
    }
}
