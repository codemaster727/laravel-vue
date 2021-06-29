<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkReportPhotoStoreRequest extends FormRequest
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
            'work'		=> 'required|string|max:255',
            'photo'     => 'required|string|max:255',
        ];
    }
}
