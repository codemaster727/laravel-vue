<?php

namespace App\Http\Requests\User;

use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'company'       => 'string|max:255',
            'tel'           => 'string|max:20',
            'status'        => 'int|max:100',
            'email'         => 'string|max:255',
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
