<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\BadRequestErrorResponseException;

class WorkReportPhotoRequest extends FormRequest
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
        $photoFileTypes   = config('const.work.report.photo.file_types', 'jpeg,png,jpg,gif,svg');
        $photoFileMaxSize = config('const.work.report.photo.max_size', 2048); // 2 MB

        return [
            'work_id'      => 'required|integer',
            'photo'        => "required|image|mimes:{$photoFileTypes}|max:{$photoFileMaxSize}",
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
