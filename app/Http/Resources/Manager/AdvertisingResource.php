<?php

namespace App\Http\Resources\Manager;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisingResource extends JsonResource
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
            'advertising_terms' => $this->advertisingTerms,
            'manager'           => $this->manager,
            'status'            => $this->status,
            'company'           => $this->company,
            'url'               => $this->url,
            'img_url'           => $this->img_url,
            'charge'            => $this->charge,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'mobile'            => $this->mobile,
            'zip'               => $this->zip,
            'address'           => $this->address,
            'manager_remark'    => $this->manager_remark,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
