<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes;

    protected $guarded = ['status'];

    protected $with = ['work', 'client', 'member', 'quotationItems'];

    public function work()
    {
        return $this->belongsTo(Work::class, 'work_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }

    static public function search(array $params)
    {
        return self::filterByMember($params['member'])
            ->filterByKeyword($params['keyword']);
    }

    public function scopeFilterByMember(Builder $builder, $member_id = 0)
    {
        if (blank($member_id) || $member_id == 0) {
            return $builder;
        }

        return $builder->when($member_id, function ($q, $member_id) {
            $q->where('member_id', $member_id);
        })->with('client:id,name');
    }

    public function scopeFilterByKeyword(Builder $builder, $keyword = '')
    {
        if (blank($keyword)) {
            $keyword = '';
        }
        return $builder->when($keyword, function ($q, $keyword) {
            $q->where(function ($sq) use ($keyword) {
                $sq->where('name', 'like', '%' . $keyword . '%')
                ;
            });
        })->select('*')
            ->with('member:id,name')
            ->with('client:id,name');
    }
}
