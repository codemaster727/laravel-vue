<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\BadRequestErrorResponseException;

class DiagnoseReportRequest extends FormRequest
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
        $id = $this->route('diagnosereport');
        if(empty($id)) {
            return [
                'work_id' => 'required|exists:works,id|numeric',
                'title' => 'required|max:191',
                'logo'  => 'mimes:png,jpg,jpeg,gif',
            ];
        }
        // update
        return [
            'logo'  => 'mimes:png,jpg,jpeg,gif',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            response()->json($validator->errors(), 400)
        );
    }
}
