<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisingRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'manager_id'                            => 'required|integer',
            'status'                                => 'nullable|integer',
            'company'                               => 'nullable|max:255',
            'url'                                   => 'nullable|max:255',
            'img'                                   => 'nullable|mimes:jpeg,bmp,png|max:10240',
            'charge'                                => 'nullable|max:255',
            'email'                                 => 'nullable|email|max:255',
            'phone'                                 => 'nullable|regex:/^[0-9]{10,12}$/|max:16',
            'zip'                                   => 'nullable|digits:7',
            'address'                               => 'required|max:255',
            'manager_remark'                        => 'max:1000',
            'advertising_terms.*.advertisement_id'  => 'integer',
            'advertising_terms.*.period'            => 'date_format:Y-m-d',
            'advertising_terms.*.schedule_ended_at' => 'date_format:Y-m-d',
            'advertising_terms.*.price'             => 'integer',
            'advertising_terms.*.started_at'        => 'date_format:Y-m-d',
            'advertising_terms.*.ended_at'          => 'date_format:Y-m-d',
            'advertising_terms.*.approve_at'        => 'date_format:Y-m-d',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'manager_id'               => '管理者ID',
            'status'                   => 'ステータス',
            'company'                  => '会社名',
            'url'                      => 'URL',
            'img'                      => '画像',
            'charge'                   => '担当者',
            'email'                    => 'メールアドレス',
            'phone'                    => '電話番号',
            'zip'                      => '郵便番号',
            'address'                  => '住所',
            'manager_remark'           => '管理者備考',
        ];
    }

    public function messages()
    {
        return [
            '*.required'        => ':attributeは必須です。',
            '*.max'             => ':attributeは:max文字以下で入力してください。',
            '*.min'             => ':attributeは:min文字以上で入力してください。',
            '*.integer'         => ':attributeは数値で入力してください。',
            '*.digits'          => ':attributeは:digits桁で入力してください。',
            '*.digits_between'  => ':attributeは:min～:max桁で入力してください。',
            '*.regex'           => ':attributeは電話番号の形式(ハイフンなし)で入力してください。',
        ];
    }
}
