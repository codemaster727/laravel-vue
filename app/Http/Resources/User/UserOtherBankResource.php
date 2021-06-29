<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserOtherBankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user->company,
            'financial_name' => $this->financial_name,
            'branch_name' => $this->branch_name,
            'branch_number' => $this->branch_number,
            'type' => $this->type,
            'number' => $this->number,
            'name' => $this->name,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
