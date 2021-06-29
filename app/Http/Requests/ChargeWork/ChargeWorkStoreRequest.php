<?php

namespace App\Http\Requests\ChargeWork;

use App\Http\Requests\ApiBaseRequest;

class ChargeWorkStoreRequest extends ApiBaseRequest
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
            'charge_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
            'worker_id' => 'required|numeric|min:1|regex:^[1-9][0-9]*$^',
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
            'charge_id'               => '現場ID',
            'worker_id'               => '職人ID',
        ];
    }
}
