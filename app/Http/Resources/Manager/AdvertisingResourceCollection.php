<?php

namespace App\Http\Resources\Manager;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdvertisingResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id'                => $item->id,
                'advertising_terms' => $item->advertisingTerms->map(function ($subItem) {
                    return [
                        'period'            => $subItem->period,
                        'schedule_ended_at' => $subItem->schedule_ended_at ? $subItem->schedule_ended_at->format('Y-m-d') : null,
                        'price'             => $subItem->price,
                        'price_amount'      => $subItem->priceAmount(),
                        'started_at'        => $subItem->started_at ? $subItem->started_at->format('Y-m-d') : null,
                        'ended_at'          => $subItem->ended_at ? $subItem->ended_at->format('Y-m-d') : null,
                        'approve_at'        => $subItem->approve_at ? $subItem->approve_at->format('Y-m-d') : null,
                    ];
                }),
                'manager_id'        => $item->manager_id,
                'status'            => $item->status,
                'company'           => $item->company,
                'url'               => $item->url,
                'img_url'           => $item->img_url,
                'charge'            => $item->charge,
                'email'             => $item->email,
                'phone'             => $item->phone,
                'mobile'            => $item->mobile,
                'zip'               => $item->zip,
                'address'           => $item->address,
                'manager_remark'    => $item->manager_remark,
            ];
        });
    }
}
