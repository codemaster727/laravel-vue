<?php

namespace App\Http\Requests\User;

use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'password'      => 'required|string|max:128',
            'repassword'    => 'required|same:password',
            'tel'           => 'required|string|regex:/^[\+]?[(]?[0-9]{2,3}[)]?[-\s\.]?[0-9]{2,4}[-\s\.]?[0-9]{4,6}$/',
            'company'       => 'required|string|max:255',
            'postal'        => 'required|string|regex:/^\d{7}$/',
            'address'       => 'required|string|max:255',
        ];
    }



    /**
     * Validation error handling
     *
     * @param Validator $validator
     * @throws BadRequestErrorResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            response()->json($validator->errors(), 400)
        );
    }

    public function messages()
    {
        return [
            'password.required' => 'パスワードを入力してください。',
            'password.max'      => '128文字未満のパスワードを入力してください。',
            'repassword.required' => '確認用パスワードを入力してください。',
            'repassword.same'   => 'パスワードを正しく入力してください。',
            'tel.required'      => '電話番号を入力してください。',
            'tel.regex'         => '電話番号を正しく入力してください。',
            'company.required'  => '会社名を入力してください。',
            'company.max'       => '255文字未満の会社名を入力してください。',
            'postal.required'   => '郵便番号を入力してください。',
            'postal.regex'      => '郵便番号を正しく入力してください。',
            'address.required'  => '住所を入力してください。',
            'address.max'       => '255文字未満の住所を入力してください。',
        ];
    }
}
