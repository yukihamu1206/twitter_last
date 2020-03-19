<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TweetRequest extends FormRequest
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
            'text' => ['required', 'max:140'],
        ];
    }

    /**
     * 勝手にリダイレクトさせない(デフォルトでリダイレクトしてしまうので)
     *
     * @Override
     *
     * @param  Validator  $validator
     */
    protected function failedValidation(Validator $validator)
    {
    }

    /**
     * エラーメッセージ
     */
    public function messages()
    {
        return [
            'text.required' => '本文を入力してね',
            'text.max' => '140字以内にしてね',
        ];
    }

    /**
     * validatorを取得するメソッド
     */
    public function getValidator()
    {
        return $this->validator;
    }

}
