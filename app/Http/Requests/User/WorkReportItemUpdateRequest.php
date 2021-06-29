<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkReportItemUpdateRequest extends FormRequest
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
            'work_report'		=> 'string|max:255',
            'work'              => 'string|max:255',
            'photo'             => 'string|max:255',
            'name'              => 'string|max:255',
            'photographer'      => 'string|max:255',
        ];
    }
}
