<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertisingTerm extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'advertising_id',
        'token',
        'period',
        'schedule_ended_at',
        'price',
        'started_at',
        'ended_at',
        'approve_at'
    ];

    protected $dates = [
        'schedule_ended_at',
        'started_at',
        'ended_at',
        'approve_at',
        'created_at',
        'updated_at'
    ];

    /**
     * コードに対応する金額を取得
     *
     * @return int
     */
    public function priceAmount()
    {
        return $this->price;

        $data = -1;
        switch ($this->price) {
            case 1:
                $data = config('const.price.1');
                break;
            case 2:
                $data = config('const.price.2');
                break;
            case 3:
                $data = config('const.price.3');
                break;
            case 4:
                $data = config('const.price.4');
                break;
            case 5:
                $data = config('const.price.5');
                break;
            case 6:
                $data = config('const.price.6');
                break;
            case 7:
                $data = config('const.price.7');
                break;
            case 8:
                $data = config('const.price.8');
                break;
            case 9:
                $data = config('const.price.9');
                break;
            case 10:
                $data = config('const.price.10');
                break;
        }
        return $data;
    }
}
