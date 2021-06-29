<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\BadRequestErrorResponseException;

class MemoRequest extends FormRequest
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
        $id = $this->route('memo');

        if (!empty($id)) {
            return [
                'member_id'     => 'required|integer',
                'title'         => 'required|max:255',
                'text'          => 'required',
            ];
        }

        return [
            'member_id'     => 'required|integer',
            'title'         => 'required|max:255',
            'text'          => 'required',
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
