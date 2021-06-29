<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Memo extends Model
{
    //use SoftDeletes;

    /**
     * @var string テーブル名
     */
    protected $table = 'memos';

    /**
     * @var string[] 詰め込み可能なフィールド
     */
    protected $fillable = [
        'user_id', 'member_id', 'title', 'text',
    ];

    // Relations

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    // Filters

    public function scopeMyMemos(Builder $query) : void
    {
        $query->where(function($q) {
            $q->whereUserId(1/*\Auth::user()->id*/);
        });
    }

    static public function search(array $params)
    {
        return self::filterByMember($params['member']);
    }

    public function scopeFilterByMember(Builder $builder, $memberId = 0)
    {
        if (blank($memberId) || $memberId == 0) {
            return $builder;
        }
        return $builder->when($memberId, function ($q, $memberId) {
            $q->where('member_id', $memberId);
        });
    }
}
