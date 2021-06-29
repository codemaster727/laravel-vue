<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\BadRequestErrorResponseException;

class ClientUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //'user_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
            'name' => 'required|string|max:255',
            'tel' => 'nullable|regex:/^[0-9]{10,12}$/|max:16',
            'memo' => 'nullable|string'
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'user_id'           => 'ユーザーID',
            'name'              => '名前',
            'tel'               => '電話番号',
            'memo'              => 'メモ'
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
            $validator->errors()
        );
    }
}
