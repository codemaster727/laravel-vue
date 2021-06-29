<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserJapanBankRequest extends FormRequest
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
        $id = $this->route('japan-bank');
        if(empty($id)) {
            return [
                //'user_id' => 'required|exists:users,id|numeric',
                'mark' => 'required|numeric',
                'number' => 'required|numeric',
                'name' => 'required|max:191'
            ];
        }
        return [
            //'user_id' => 'exists:users,id|numeric',
            'name' => 'max:191'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            response()->json($validator->errors(), 400)
        );
    }
}
