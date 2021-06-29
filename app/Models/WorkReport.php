<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkReport extends Model
{
    use SoftDeletes;
    protected $table = 'work_reports';

    protected $fillable = [
        'work_id', 'title', 'logo',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    // ƒL[ŒŸõ
    public function scopeFilterByKey(Builder $query, $key = null)
    {
        return $query->when($key, function ($q, $key) {
            $q->where(function ($sq) use ($key) {
                $sq->where('title', 'like', '%' . $key . '%');
                ;
            });
        })->select('*')->with('work:id,name');
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function workReportItems()
    {
        return $this->hasMany('App\Models\WorkReportItem', 'work_report_id');
    }
}
