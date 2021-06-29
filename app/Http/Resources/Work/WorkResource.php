<?php

namespace App\Http\Resources\Work;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
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
            'id'					=> $this->id,
            'user'                  => $this->user,
            'status'                => $this->status,
            'name'                  => $this->name,
            'temporary_start_date'  => $this->temporary_start_date,
            'temporary_finish_date' => $this->temporary_finish_date,
            'period_start_date'     => $this->period_start_date,
            'period_finish_date'    => $this->period_finish_date,
            'startDate'             => $this->startDate(),
            'finishDate'            => $this->finishDate(),
            'postal'                => $this->postal,
            'address'               => $this->address,
            'client'                => $this->client,
            'member'                => $this->member,
            'process'               => $this->process,
            'charge_worker'         => $this->chargeWorker,
            'memo'                  => $this->memo,
            'created_at'			=> $this->created_at,
            'updated_at'			=> $this->updated_at,
            'deleted_at'			=> $this->deleted_at,
        ];
    }
}
