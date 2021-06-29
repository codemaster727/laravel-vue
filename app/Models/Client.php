<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    // use SoftDeletes;

    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    static public function search(array $params)
    {
        return self::filterByKeyword($params['keyword']);
    }

    public function scopeFilterByKeyword(Builder $builder, $keyword = '')
    {
        return $builder->when($keyword, function ($q, $keyword) {
            $q->where(function ($sq) use ($keyword) {
                $sq->where('name', 'like', '%' . $keyword . '%')
                ;
            });
        })->select('*');
    }
}
