<?php

namespace App\Http\Requests\History;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\BadRequestErrorResponseException;

class HistoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'work_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
            'charge_id' => 'required|numeric',
            'charge_work_status' => 'numeric',
            'work_date' => 'required',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'work_id' => '現場ID',
            'charge_id' => '職人ID',
            'charge_work_status' => '職人ステータス',
            'work_date' => '作業日',
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
