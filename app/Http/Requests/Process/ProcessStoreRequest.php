<?php

namespace App\Http\Requests\Process;

use App\Http\Requests\ApiBaseRequest;

class ProcessStoreRequest extends ApiBaseRequest
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
            'work_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
            'process_color_id' => 'numeric|min:1|regex:^[1-9][0-9]*$^',
            'name' => 'required|string|max:255',
            'memo' => 'string',
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
            'work_id'               => '現場ID',
            'process_color_id'      => '工程カラーID',
            'name'                  => '工程名',
            'memo'                  => '社内メモ',
        ];
    }
}
