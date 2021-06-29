<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'processes';

    protected $with = [
        // 双方向のリレーションでエラーになってしまうから非表示
        // 'work',
        'processColor',
        'processPeriod'
    ];

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    // 双方向のリレーションでエラーになってしまうから非表示
    // public function work() {
    //     return $this->belongsTo('App\Models\Work', 'work_id');
    // }

    public function processColor() {
        return $this->belongsTo(ProcessColor::class, 'process_color_id');
        // return $this->hasOne('App\Models\ProcessColor', 'id', 'process_color_id');
    }

    public function processPeriod() {
        return $this->hasMany(ProcessPeriod::class);
    }

    public function processShow($id)
    {
        $processes = self::select(
                'processes.*',
            )
            ->find($id);
            // ->where('id', $id)
            // ->get();
        return $processes;
    }

    static public function search(array $params)
    {
        $result = self::whereHas('work', function($query) use ($params) {
            $query->whereStatus($params['work_status'])
                ->where('period_start_date', '<=', $params['date'])
                ->where('period_finish_date', '>=', $params['date']);
            if (isset($params['member']) && $params['member'] != 0) {
                $query->whereHas('member', function($sq) use ($params) {
                    $sq->whereMemberId($params['member']);
                });
            }
        })->get();

        return $result;
    }
}
