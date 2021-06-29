<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemResource extends JsonResource
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
            'invoice' => $this->invoice->name,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'price' => $this->price,
            'total' => $this->total,
            'sort_order' => $this->sort_order
        ];
    }
}
