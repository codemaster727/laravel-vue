<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\BadRequestErrorResponseException;

class DiagnoseReportItemRequest extends FormRequest
{
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
        $id = $this->route('diagnosereportitem');
        if(empty($id)) {
            return [
                'diagnose_report_id' => 'required|exists:diagnose_reports,id|numeric',
                'name' => 'required|max:191',
                'photo'  => 'mimes:png,jpg,jpeg,gif',
                'sort_order' => 'numeric|min:0'
            ];
        }
        // update
        return [
            'photo'  => 'mimes:png,jpg,jpeg,gif',
            'sort_order' => 'numeric|min:0'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            response()->json($validator->errors(), 400)
        );
    }
}
