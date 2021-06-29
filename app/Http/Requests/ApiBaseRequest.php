<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * APIのバリデーションの基底クラス
 */
class ApiBaseRequest extends FormRequest
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
     * バリデーションエラー時の共通処理
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            $validator->errors()->toArray()
        );
    }
}
