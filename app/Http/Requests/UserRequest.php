<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user = Auth()->user();
        return [
            'screen_name'   => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'name'          => ['required', 'string', 'max:255'],
            'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages()
    {
        return [
            'screen_name.required' => '入力してね',
            'screen_mame.max' => '50字以内にしてね',
            'screen_name.unique' => 'もう使われてるよ',
            'name.required' => '入力してね',
            'mame.max' => '255字以内にしてね',
            'name.unique' => 'もう使われてるよ',
            'email.required' => '入力してね',
            'email.unique' => 'もう使われてるよ'
        ];
    }
}
