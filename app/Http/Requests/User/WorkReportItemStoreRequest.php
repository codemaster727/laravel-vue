<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkReportItemStoreRequest extends FormRequest
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
            'work_report'		=> 'required|string|max:255',
            'work'              => 'required|string|max:255',
            'photo'             => 'required|string|max:255',
            'name'              => 'required|string|max:255',
            'work_date'         => 'required',
            'photographer'      => 'required|string|max:255',
            'content'           => 'required',
            'remark'            => 'required',
            'memo'              => 'required',
            'order'             => 'required',
            'pdf'               => 'required',
        ];
    }
}
