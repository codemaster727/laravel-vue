<?php

namespace App\Http\Requests\User;

use DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WorkerLoginRequest extends FormRequest
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
            'email'           => 'required|email',
            'password'        => 'required',
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
