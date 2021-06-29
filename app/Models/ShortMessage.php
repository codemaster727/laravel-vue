<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShortMessage extends Model
{
    use SoftDeletes;

    // SMS送信1回分の単価
    const UNIT_PRICE = 11;

    /**
     * @var string テーブル名
     */
    protected $table = 'short_messages';

    /**
     * @var string[] 詰め込み可能なフィールド
     */
    protected $fillable = [
        'user_id', 'work_id', 'client_id', 'type'
    ];

    // Relations

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function work() : BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // Filters

    public function scopeMyShortMessages(Builder $query) : void
    {
        $query->where(function($q) {
            $q->whereUserId(1/*\Auth::user()->id*/);
        });
    }

    public function scopeFilterByWork(Builder $query, $workID = null) : void
    {
        $query->when($workID, function ($q, $workID) {
            $q->where('work_id', $workID);
        });
    }

    public function scopeFilterByClient(Builder $query, $clientID = null) : void
    {
        $query->when($clientID, function ($q, $clientID) {
            $q->where('client_id', $clientID);
        });
    }

    public function scopeDateBetween(Builder $query, $startDate, $endDate) : void
    {
        $endDate = empty($endDate) ? : $startDate;

        if (!empty($startDate) && !empty($endDate) && $startDate <= $endDate) {
            $query->where('created_at', '>=', $startDate . ' 00:00:00')
                ->where('start_date_time', '<=', $startDate . ' 23:59:59');
        }
    }

    /**
     * Scopeによる絞り込み：登録日(年月指定)
     *
     * @param Builder $query
     * @param int $year
     * @param int $month
     * @return Builder
     */
    public function scopeOfCreatedAtByYearMonth(Builder $query, $year, $month)
    {
        if (blank($year) || blank($month)) return;
        $from = Carbon::create($year, $month, 1)->firstOfMonth();
        $to   = Carbon::create($year, $month, 1)->lastOfMonth();
        return $query->whereBetween('created_at', [$from, $to]);
    }
}
