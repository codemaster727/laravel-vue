<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserOtherBankRequest extends FormRequest
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
        $id = $this->route('other-bank');
        if(empty($id)) {
            return [
                //'user_id' => 'required|exists:users,id|numeric',
                'financial_name' => 'required|max:191',
                'branch_name' => 'required|max:191',
                'branch_number' => 'required|max:191',
                'type' => 'numeric|min:0|max:2',
                'number' => 'required|numeric',
                'name' => 'required|max:191'
            ];
        }
        return [
            'financial_name' => 'max:191',
            'branch_name' => 'max:191',
            'branch_number' => 'max:191',
            'type' => 'numeric|min:0|max:1',
            'number' => 'numeric',
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
