<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankJapan extends Model
{
    protected $fillable = [
        'bank_id',
        'financial_name',
        'branch_name',
        'branch_number',
        'type'
    ];

    /**
     *
     * リレーション
     *
    */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
