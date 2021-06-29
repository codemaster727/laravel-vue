<?php

namespace App\Models;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertising extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'manager_id',
        'status',
        'company',
        'url',
        'img_url',
        'charge',
        'email',
        'phone',
        'mobile',
        'zip',
        'address',
        'manager_remark',
    ];

    /**
     * リレーション：広告期間
     *
     * @return HasMany
     */
    public function advertisingTerms()
    {
        return $this->hasMany(AdvertisingTerm::class, 'advertising_id');
    }

    /**
     * リレーション：管理者
     *
     * @return HasMany
     */
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    /**
     * パラメータによる絞り込み
     *
     * @param array $params
     * @return App\Models\Advertising
     */
    static public function search(array $params)
    {
        return self::ofManagerId(isset($params['manager_id']) ? $params['manager_id'] : null)
            ->ofStatus(isset($params['status']) ? $params['status'] : [])
            ->ofFreeWord(isset($params['free_word']) ? $params['free_word'] : '')
            ->ofCharge(isset($params['charge']) ? $params['charge']: '')
            ->ofEndedAt(isset($params['ended_at']) ? $params['ended_at'] : '');
    }

    /**
     * Scopeによる絞り込み：管理者ID
     *
     * @param Builder $builder
     * @param integer $key
     * @return Builder
     */
    public function scopeOfManagerId(Builder $builder, ?int $key)
    {
        if (blank($key)) {
            return $builder;
        }
        return $this->where('manager_id', $key);
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
        return $this->whereIn('status', $keys);
    }

    /**
     * Scopeによる絞り込み：担当者
     *
     * @param Builder $builder
     * @param string $key
     * @return Builder
     */
    public function scopeOfCharge(Builder $builder, ?string $key)
    {
        if (blank($key)) {
            return $builder;
        }
        return $this->where('charge', 'like', "%$key%");
    }

    /**
     * Scopeによる絞り込み：フリーワード
     * 検索対象：会社名、URL、担当者、メールアドレス、電話番号、郵便番号、住所、管理者備考
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
        return $builder->whereHas('manager', function($query) use ($key) {
                return $query->where('name', 'like', "%$key%");
            })
            ->orWhere('company', 'like', "%$key%")
            ->orWhere('url', 'like', "%$key%")
            ->orWhere('charge', 'like', "%$key%")
            ->orWhere('email', 'like', "%$key%")
            ->orWhere('phone', 'like', "%$key%")
            ->orWhere('zip', 'like', "%$key%")
            ->orWhere('address', 'like', "%$key%")
            ->orWhere('manager_remark', 'like', "%$key%");
    }

    public function scopeOfEndedAt(Builder $builder, ?string $key)
    {
        if (blank($key)) {
            return $builder;
        }
        return $this->where('ended_at', '<=', $key);
    }
}
