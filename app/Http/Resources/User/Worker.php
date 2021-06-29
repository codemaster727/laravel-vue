<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class Worker extends JsonResource
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
            'name'              => $this->name,
            'email'             => $this->email,
            'worker'            => $this->worker,
            'worker_id'         => $this->worker_id,
            'status'            => $this->status,
            'manager_remark'    => $this->manager_remark,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->updated_at
        ];
    }
}
