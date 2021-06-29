<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkReportPhoto extends Model
{
    use SoftDeletes;

    /**
     * @var string テーブル名
     */
    protected $table = 'work_report_photos';

    /**
     * @var string[] 詰め込み可能なフィールド
     */
    protected $fillable = [
        'work_id', 'name'
    ];

    protected $casts = [
    ];

    // キー検索
    public function scopeFilterByKey(Builder $query, $key = null)
    {
        return $query->when($key, function ($q, $key) {
            $q->where(function ($sq) use ($key) {
                $sq->where('photo', 'like', '%' . $key . '%')
                ;
            });
        })->select('*')
            ->with('work:id,name')
            ;
    }

    // Relations
    public function work() : BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    // Filters
    public function scopeWorkReportPhotos(Builder $query, $workID = null) : void
    {
        $query->when($workID, function ($q, $workID) {
            $q->where('work_id', $workID);
        });
    }
}
