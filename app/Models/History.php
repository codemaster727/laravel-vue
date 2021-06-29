<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use SoftDeletes;
    protected $table = 'histories';

    protected $with = ['chargeWorker'];

    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = [];

    public function chargeWorker()
    {
        return $this->belongsTo('App\Models\ChargeWorker', 'charge_id');
    }

	public function worker() 
    {
        return $this->belongsTo('Worker');
    }
}
