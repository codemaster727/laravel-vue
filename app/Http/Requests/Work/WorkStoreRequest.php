<?php

namespace App\Http\Requests\Work;

use App\Http\Requests\ApiBaseRequest;

class WorkStoreRequest extends ApiBaseRequest
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
            'user_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
            'status' => 'required|numeric',
            'name' => 'required|string|max:255',
            'client_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
            'member_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
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
            'user_id'           => 'ユーザーID',
            'status'            => '現場ステータス',
            'name'              => '名前',
            'client_id'         => 'お客様ID',
            'member_id'         => '営業担当ID',
        ];
    }
}
