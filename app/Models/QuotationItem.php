<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationItem extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function quotation(){

        return $this->belongsTo('App\Models\Quotation', 'quotation_id');
    }
}
