<?php

namespace App\Http\Requests\User;

use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class InvoiceRequest extends FormRequest
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
        $id = $this->route('invoice');
        if(empty($id)) {
            return [
                'work_id' => 'required|exists:works,id|numeric',
                'quotation_id' => 'exists:quotations,id|numeric',
                'name' => 'required|max:70',
                'invoice_number' => 'required|max:40',
                'client_id' => 'required|exists:clients,id|numeric',
                'member_id' => 'required|exists:members,id|numeric',
                'publish_date' => 'date',
                'limit_date' => 'date',
                'total' => 'numeric',
            ];
        }
        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            response()->json($validator->errors(), 400)
        );
    }
}
