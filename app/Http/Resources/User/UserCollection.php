<?php

namespace App\Http\Resources\User;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $now    = Carbon::now();
        $year   = now()->year;
        $month  = now()->month;
        $months = [];
        for ($i = 0; $i < 4; $i++) {
            $months[] = $month - $i;
        }
        return $this->collection->map(function($item) use ($year, $months) {
            $temps = [];
            foreach ($months as $thisMonth) {
                $temp = [
                    'year'  => $year,
                    'month' => $thisMonth,
                    'price' => $item->shortMessagesPrice($year, $thisMonth, 0),
                    'count' => $item->shortMessagesCount($year, $thisMonth, 0)
                ];
                $temps[] = $temp;
            }
            return [
                'id'                => $item->id,
                'manager'           =>
                    [
                        'id'        => $item->manager->id,
                        'name'      => $item->manager->name,
                        'authority' => $item->manager->authority,
                    ],
                'short_messages'    => $temps,
                'company'           => $item->company,
                'tel'               => $item->tel,
                'postal'            => $item->postal,
                'address'           => $item->address,
                'status'            => $item->status,
                'bank_type'         => $item->bank_type,
                'bank_id'           => $item->bank_id,
                'email'             => $item->email,
                'manager_remark'    => $item->manager_remark,
                'price'             => $item->price,
                'price_amount'      => $item->priceAmount(),
                'created_at'        => $item->created_at,
                'updated_at'        => $item->updated_at,
                'deleted_at'        => $item->deleted_at,
                'email_verified_at' => $item->email_verified_at,
            ];
        });
    }
}
