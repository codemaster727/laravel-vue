<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use SoftDeletes;
    protected $table = 'works';

    protected $with = [
        'user',
        'client',
        'member',
        'process',
        'chargeWorker',
        'history',
        'workReportItem'
    ];

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id');
    }

    // 案件職人と紐づく
    public function chargeWorker()
    {
        return $this->hasMany('App\Models\ChargeWorker');
        // return $this->hasMany(ChargeWorker::class);
    }

    public function process()
    {
        return $this->hasMany('App\Models\Process');
        // return $this->hasMany(Process::class);
    }

    public function history()
    {
        return $this->hasMany('App\Models\History');
        // return $this->hasMany(History::class);

    }

    public function workReportItem()
    {
        return $this->hasMany('App\Models\WorkReportItem');
    }

    /**
     * パラメータによる絞り込み
     *
     * @param array $params
     * @return App\Models\Work
     */
    static public function search(array $params)
    {
        if (!$params['keyword']) {
            $params['keyword'] = '';
        }
        return self::status($params['status'])
            ->memberId($params['member_id'])
            ->keyword($params['keyword']);
    }

    /**
     * Scopeによる絞り込み：ステータス
     *
     * @param Builder $builder
     * @param string $status
     * @return Builder
     */
    public function scopeStatus(Builder $builder, $status)
    {
        if (empty($status) && $status != '0') {
            return $builder;
        }
        return $builder->where('works.status', $status);
    }

    /**
     * Scopeによる絞り込み：キーワード
     *
     * @param Builder $builder
     * @param string|null $keyword
     * @return Builder
     */
    public function scopeKeyword(Builder $builder, $keyword)
    {
        if (empty($keyword)) {
            return $builder;
        }
        return $builder->where('works.name', 'like', "%$keyword%")
            ->orWhere('works.remark', 'like', "%$keyword%")
            ->orWhere('works.memo', 'like', "%$keyword%");
    }

    /**
     * Scopeによる絞り込み：メンバー
     *
     * @param Builder $builder
     * @param string|null $member_id
     * @return Builder
     */
    public function scopeMemberId(Builder $builder, $member_id)
    {
        if (empty($member_id)) {
            return $builder;
        }
        return $builder->where('works.member_id', $member_id);
    }

    public function startDate() {
        return $this->period_start_date ? str_replace('-', '/', substr($this->period_start_date, 5, 5)) : '00/00';
    }

    public function finishDate() {
        return $this->period_finish_date ? str_replace('-', '/', substr($this->period_finish_date, 5, 5)) : '00/00';
    }

}
