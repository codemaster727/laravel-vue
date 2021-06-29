<?php

namespace App\Http\Requests\ProcessPeriod;

use App\Http\Requests\ApiBaseRequest;

class ProcessPeriodStoreRequest extends ApiBaseRequest
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
            'process_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
            'start_date' => 'date',
            'finish_date' => 'date'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'process_id'               => '工程ID',
            'start_date'               => '開始日',
            'finish_date'              => '終了日',
        ];
    }
}
