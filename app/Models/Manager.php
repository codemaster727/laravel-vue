<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'managers';

    protected $fillable = ['status'];

    /**
     * 検索
     *
     * @param array $params
     * @return Builder
     */
    static public function search(array $params)
    {
        return self::ofStatus(isset($params['status']) ? $params['status'] : [])
            ->ofIsDeleted(isset($params['is_deleted']) ? (int)($params['is_deleted']) : null)
            ->ofFreeWord(isset($params['free_word']) ? $params['free_word'] : '');
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
        if ($key === 1) return $builder->whereNotNull('deleted_at');
        return $builder;
    }

    /**
     * Scopeによる絞り込み：フリーワード
     * 検索対象：契約管理者, メールアドレス, 会社名, 電話番号, 郵便番号, 住所
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
        return $builder->Where('email', 'like', "%$key%")
            ->orWhere('name', 'like', "%$key%")
            ->orWhere('memo', 'like', "%$key%");
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
