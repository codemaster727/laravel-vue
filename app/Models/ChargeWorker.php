<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChargeWorker extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'charge_workers';
    protected $with = ['worker'];
    protected $fillable = ['work_id', 'worker_id'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = [];

    public function worker() {
        return $this->belongsTo('App\Models\Worker', 'worker_id');
    }

	/**
	 * 案件に紐づく職人一覧を取得
	 *
	 * @var array
	 */
    public function chargeWorkerList($id)
    {
        $chargeWorkers = self::select(
                'charge_workers.*',
                'workers.name as worker_name'
            )
            ->where('work_id', $id)
            ->leftJoin('workers', 'charge_workers.worker_id', '=', 'workers.id')
            ->get();
        return $chargeWorkers;
    }
}
