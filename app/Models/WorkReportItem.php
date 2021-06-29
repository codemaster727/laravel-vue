<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkReportItem extends Model
{
    use SoftDeletes;
    protected $table = 'work_report_items';

    protected $fillable = [
        'work_report_id', 'work_id', 'photo', 'name', 'work_date', 'photographer', 'content', 'remark', 'memo', 'order', 'pdf',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    // キー検索
    public function scopeFilterByKey(Builder $query, $key = null)
    {
        return $query->when($key, function ($q, $key) {
            $q->where(function ($sq) use ($key) {
                $sq->where('name', 'like', '%' . $key . '%')
                    ->orWhere('photographer', 'like', '%' . $key . '%')
                    ->orWhere('content', 'like', '%' . $key . '%')
                    ->orWhere('remark', 'like', '%' . $key . '%')
                    ->orWhere('memo', 'like', '%' . $key . '%')
                ;
            });
        })->select('*')
            ->with('workReport:id,title')
            ->with('work:id,name')
            ;
    }

    public function workReport()
    {
        return $this->belongsTo(WorkReport::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
