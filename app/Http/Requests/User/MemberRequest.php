<?php

namespace App\Http\Requests\User;


use App\Exceptions\BadRequestErrorResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //todo it need to add authentication checking
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //check if request is update or store
        $id = $this->route('member');
        if(!empty($id))
            return [
                'name' => ['required', 'string', 'max:255'],
            ];

        return [
            'name' => ['required', 'string', 'max:255', 'unique:members'],
            //'user_id' => ['required','exists:users,id','unique:members'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
       throw new BadRequestErrorResponseException($validator->errors());
    }

}
