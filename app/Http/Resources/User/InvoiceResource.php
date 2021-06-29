<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'quotation' => $this->quotation,
            'quotation_id' => $this->quotation_id,
            'name' => $this->name,
            'invoice_number' => $this->invoice_number,
            'client' => $this->client,
            'member' => $this->member,
            'publish_date' => $this->publish_date,
            'limit_date' => $this->limit_date,
            'total' => $this->total,
            'remark' => $this->remark,
            'memo' => $this->memo,
            'bill_company_name' => $this->bill_company_name,
            'bill_postal' => $this->bill_postal,
            'bill_address' => $this->bill_address,
            'bill_tel' => $this->bill_tel,
            'bill_email' => $this->bill_email,
            'invoice_items' => $this->invoiceItems,
        ];
    }
}
