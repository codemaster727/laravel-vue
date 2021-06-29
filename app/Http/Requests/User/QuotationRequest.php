<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Contracts\Validation\Validator;

class QuotationRequest extends FormRequest
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
        //check if request is update or store
        $id = $this->route('quotation');
        // store
        if(empty($id)) {
            return [
                'work_id' => 'required|exists:works,id|unique:quotations|numeric',
                'status' => 'required|numeric|min:0|max:1',
                'name' => 'required|max:70',
                'number' => 'required|max:40',
                'client_id' => 'required|exists:clients,id|numeric',
                'member_id' => 'required|exists:members,id|numeric',
                'publish_date' => 'date',
                'expiration_date' => 'date',
                'total' => 'numeric',
            ];
        }
        // update
        return [
            'status' => 'numeric|min:0|max:1',
            'name' => 'max:70',
            'number' => 'max:40',
            'publish_date' => 'date',
            'expiration_date' => 'date',
            'total' => 'numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            response()->json($validator->errors(), 400)
        );
    }
}
