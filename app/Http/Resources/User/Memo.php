<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class Memo extends JsonResource
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
            'id'     => $this->id,
            'member_id'     => $this->member_id,
            'member_name'   => ($this->member ? $this->member->name : ''),
            'title'         => $this->title,
            'text'          => $this->text,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'deleted_at'    => $this->deleted_at,
        ];
    }
}
