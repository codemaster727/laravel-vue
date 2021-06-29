<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
