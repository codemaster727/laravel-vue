<?php

namespace App\Http\Resources\Manager;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => '',
            'authority' => $this->authority,
            'status' => $this->status,
            'memo' => $this->memo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
