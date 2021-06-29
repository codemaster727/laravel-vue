<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Worker extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'workers';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function worker()
    {
        return $this->belongsTo('App\Models\Work', 'worker_id');
    }

    /* リレーション */
    public function chargeUser()
    {
        return $this->hasOne('App\Models\ChargeUser');
    }

    /**
     * パラメータによる絞り込み
     *
     * @param array $params
     * @return App\Models\Worker
     */
    static public function search(array $params)
    {
        if (!$params['keyword']) {
            $params['keyword'] = '';
        }
        return self::filterByKeyword($params['keyword']);
    }

    /**
     * 検索（管理者画面にて）
     *
     * @param array $params
     * @return Builder
     */
    static public function searchOnManager(array $params)
    {
        return self::ofStatus(isset($params['status']) ? $params['status'] : [])
            ->ofIsDeleted(isset($params['is_deleted']) ? (int)($params['is_deleted']) : null)
            ->ofFreeWord(isset($params['free_word']) ? $params['free_word'] : '');
    }

    /**
     * Scopeによる絞り込み：キーワード
     *
     * @param Builder $builder
     * @param string|null $keyword
     * @return Builder
     */
    public function scopeFilterByKeyword(Builder $builder, $keyword = '')
    {
        if (blank($keyword)) {
            return $builder;
        }
        return $builder->when($keyword, function ($q, $keyword) {
            $q->where(function ($sq) use ($keyword) {
                $sq->where('email', 'like', "%$keyword%")
                    ->orWhere('name', 'like', "%$keyword%");
            });
        });
    }

    /**
     * Scopeによる絞り込み：論理削除済か
     *
     * @param Builder $builder
     * @param integer $key
     * @return Builder
     */
    public function scopeOfIsDeleted(Builder $builder, ?int $key)
    {
        if (blank($key)) {
            return $builder;
        }
        if ($key === '1') return $builder->withTrashed()->whereNotNull('deleted_at');
        return $builder;
    }

    /**
     * Scopeによる絞り込み：フリーワード
     * 検索対象：名前, メールアドレス, 職人ID
     *
     * @param Builder $builder
     * @param string $key
     * @return Builder
     */
    public function scopeOfFreeWord(Builder $builder, ?string $key)
    {
        if (blank($key)) {
            return $builder;
        }
        return $builder->where('name', 'like', "%$key%")
            ->orWhere('email', 'like', "%$key%")
            ->orWhere('worker_id_code', 'like', "%$key%");
    }

    /**
     * Scopeによる絞り込み：ステータス（※配列で指定）
     *
     * @param Builder $builder
     * @param array $keys
     * @return Builder
     */
    public function scopeOfStatus(Builder $builder, ?array $keys)
    {
        if (empty($keys)) {
            return $builder;
        }
        return $builder->whereIn('status', $keys);
    }
}
