<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankOther extends Model
{
    protected $fillable = [
        'bank_id',
        'mark'
    ];

    /**
     * リレーション
    */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
