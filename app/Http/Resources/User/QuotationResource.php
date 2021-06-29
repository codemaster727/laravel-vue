<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
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
            'work' => $this->work->name,
            'status' => $this->status,
            'name' => $this->name,
            'number' => $this->number,
            'client' => $this->client,
            'member' => $this->member,
            'publish_date' => $this->publish_date,
            'expiration_date' => $this->expiration_date,
            'total' => $this->total,
            'remark' => $this->remark,
            'memo' => $this->memo,
            'bill_company_name' => $this->bill_company_name,
            'bill_postal' => $this->bill_postal,
            'bill_address' => $this->bill_address,
            'bill_tel' => $this->bill_tel,
            'bill_email' => $this->bill_email,
            'quotation_items' => $this->quotationItems,
        ];
    }
}
