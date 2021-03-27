<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //인증된 상태라고 임의로 설정
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
            //
            'name' => 'required',
            'email' => 'required',
            //confirmed 필드가 들어있기 때문에
            //password_confirmation 필드가 들어가야한다.
            'password' => 'required|confirmed',
        ];
    }
}
