<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ShortMessage extends JsonResource
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
            'user_id'      => $this->user_id,
            'work_id'      => $this->work_id,
            'client_id'    => $this->client_id,
            'type'         => $this->type,
        ];
    }
}
