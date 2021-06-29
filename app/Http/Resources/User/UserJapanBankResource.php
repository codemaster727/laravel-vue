<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserJapanBankResource extends JsonResource
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
            'mark' => $this->mark,
            'number' => $this->number,
            'name' => $this->name,
            'created_at'    => $this->created_at,
            'updatd_at'     => $this->updated_at,
        ];
    }
}
