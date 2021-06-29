<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{

    protected $fillable = ['user_id','name','memo'];

    protected $with = ['user'];

    /**
     * @var string テーブル名
     */
    protected $table = 'members';

    // Relations
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function memos() : HasMany
    {
        return $this->hasMany(Memo::class);
    }
}
