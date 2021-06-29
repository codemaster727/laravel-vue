<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'users';

    protected $fillable = [
        'manager_id',
        'company',
        'tel',
        'postal',
        'address',
        'status',
        'bank_id',
        'email',
        'password',
        'email_verified_at',
        'manager_remark',
        'email_verified_flag'
    ];

    protected $hidden = [
        'password', 'email_token', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // キー検索
    public function scopeFilterByKey(Builder $query, $key = null)
    {
        return $query->when($key, function ($q, $key) {
            $q->where(function ($sq) use ($key) {
                $sq->where('company', 'like', '%' . $key . '%')
                    ->orWhere('tel', 'like', '%' . $key . '%')
                    ->orWhere('postal', 'like', '%' . $key . '%')
                    ->orWhere('address', 'like', '%' . $key . '%')
                    ->orWhere('email', 'like', '%' . $key . '%')
                ;
            });
        })->select('*')->with('manager:id,name');
    }

    /**
     * 検索
     *
     * @param array $params
     * @return Builder
     */
    static public function search(array $params)
    {
        return self::ofManagerId(isset($params['manager_id']) ? (int)($params['manager_id']) : null)
            ->ofStatus(isset($params['status']) ? $params['status'] : [])
            ->ofIsDeleted(isset($params['is_deleted']) ? (int)($params['is_deleted']) : null)
            ->ofFreeWord(isset($params['free_word']) ? $params['free_word'] : '');
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
        return $builder->where('manager_id', $key);
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
        if ($key === 1) return $builder->withTrashed()->whereNotNull('deleted_at');
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
        return $builder->whereHas('manager', function($query) use ($key) {
                return $query->where('name', 'like', "%$key%");
            })
            ->orWhere('email', 'like', "%$key%")
            ->orWhere('company', 'like', "%$key%")
            ->orWhere('tel', 'like', "%$key%")
            ->orWhere('postal', 'like', "%$key%")
            ->orWhere('address', 'like', "%$key%");
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

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    /**
     * SMSの年月ごとの金額
     *
     * @return int
     */
    public function shortMessagesPrice($year, $month, $plus = 0)
    {
        $date = new Carbon($year.'-'.$month.'-01');
        if (!blank($plus)) {
            if ($plus >= 0) {
                $date->addMonths($plus);
            } else {
                $plus = -1 * $plus;
                $date->subMonths($plus);
            }
        }
        // 担当者分＋ユーザー分で集計
        return (
            $this->shortMessages()->ofCreatedAtByYearMonth($date->year, $date->month)->get()->count()
        ) * ShortMessage::UNIT_PRICE;
    }
    /**
     * SMSの年月ごとの回数
     *
     * @return int
     */
    public function shortMessagesCount($year, $month, $plus = 0)
    {
        $date = new Carbon($year.'-'.$month.'-01');
        if (!blank($plus)) {
            if ($plus >= 0) {
                $date->addMonths($plus);
            } else {
                $plus = -1 * $plus;
                $date->subMonths($plus);
            }
        }
        // 担当者分＋ユーザー分で集計
        return $this->shortMessages()->ofCreatedAtByYearMonth($date->year, $date->month)->get()->count();
    }

    /**
     * リレーション：SMS
     *
     * @return HasMany
     */
    public function shortMessages()
    {
        return $this->hasMany('App\Models\ShortMessage');
    }

    /**
     * コードに対応する金額を取得
     *
     * @return int
     */
    public function priceAmount()
    {
        $data = -1;
        switch ($this->price) {
            case 1:
                $data = config('const.price.1');
                break;
            case 2:
                $data = config('const.price.2');
                break;
            case 3:
                $data = config('const.price.3');
                break;
            case 4:
                $data = config('const.price.4');
                break;
            case 5:
                $data = config('const.price.5');
                break;
            case 6:
                $data = config('const.price.6');
                break;
            case 7:
                $data = config('const.price.7');
                break;
            case 8:
                $data = config('const.price.8');
                break;
            case 9:
                $data = config('const.price.9');
                break;
            case 10:
                $data = config('const.price.10');
                break;
        }
        return $data;
    }
}
