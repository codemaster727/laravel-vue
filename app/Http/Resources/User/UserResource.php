<?php

namespace App\Http\Resources\User;


use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'                => $this->id,
            'manager_id'           => $this->manager_id,
            'manager'           => $this->manager,
            'company'           => $this->company,
            'tel'               => $this->tel,
            'postal'            => $this->postal,
            'address'           => $this->address,
            'status'            => $this->status,
            'bank_type'         => $this->bank_type,
            'bank_id'           => $this->bank_id,
            'email'             => $this->email,
            'manager_remark'    => $this->manager_remark,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->deleted_at,
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}
