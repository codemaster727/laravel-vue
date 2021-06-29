<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessMaster extends Model
{
    use SoftDeletes;

    /**
     * @var string テーブル名
     */
    protected $table = 'process_masters';

    /**
     * @var string[] 詰め込み可能なフィールド
     */
    protected $fillable = [
        'user_id', 'name'
    ];

    // Relations

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Filters

    public function scopeMyProcessMasters(Builder $query) : void
    {
        $query->where(function($q) {
            $q->whereUserId(Auth::user()->id);
        });
    }
}
