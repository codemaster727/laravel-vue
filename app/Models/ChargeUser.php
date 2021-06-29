<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChargeUser extends Model
{
    // use SoftDeletes;
    /**
     * @var string テーブル名
     */
    // protected $table = 'charge_users';

    /**
     * @var string[] 詰め込み可能なフィールド
     */
    protected $fillable = [
        'user_id', 'worker_id', 'memo',
    ];

    /* リレーション */
    public function worker()
    {
        return $this->belongsTo('App\Models\Worker');
    }
}
