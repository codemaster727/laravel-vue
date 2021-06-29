<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'number',
        'name'
    ];

    /**
     *
     *
     * リレーション
     *
     *
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bank_others()
    {
        return $this->hasOne(BankOther::class);
    }

    public function bank_japans()
    {
        return $this->hasOne(BankJapan::class);
    }

    /**
     *
     * 銀行情報 一覧取得
     *
    */
    public function bankList()
    {
        $banks = Bank::all();
        return $banks;
    }

    /**
     *
     * ユーザーの銀行情報 一覧取得
     *
    */
    public function bankListOfUser($id)
    {
        $banks = self::select(
                'banks.*',
                'bank_others.financial_name as other_name',
            )
            ->where('banks.user_id', $id)
            ->leftJoin('bank_others', 'banks.id', '=', 'bank_others.bank_id')
            ->leftJoin('bank_japans', 'banks.id', '=', 'bank_japans.bank_id')
            ->get();
        return $banks;
    }

    /**
     *
     * 銀行情報 詳細取得
     *
    */
    public function bankShow($id)
    {
        $bank = self::select(
                'banks.*',
                'bank_japans.mark',
                'bank_others.financial_name',
                'bank_others.branch_name',
                'bank_others.branch_number',
                'bank_others.type as other_type'
            )
            ->leftJoin('bank_others', 'banks.id', '=', 'bank_others.bank_id')
            ->leftJoin('bank_japans', 'banks.id', '=', 'bank_japans.bank_id')
            ->find($id);
            // ->find($id)
            // ->leftJoin('bank_japans', 'banks.id', '=', 'bank_japans.bank_id');
            // ->leftJoin('bank_others', 'banks.id', '=', 'bank_others.bank_id');
        return $bank;
    }

    /**
     *
     * ゆうちょ銀行情報 更新処理
     *
    */
    public function bankJapanStore($params, $id)
    {
        // 基本情報セット
        $bank = Bank::find($id);
        $userId = Auth::id();
        $user = User::find($userId);

        // ユーザーのメインバンクID
        if($params['main'] == 'true') {
            // メインバンクの場合、ユーザーのバンクIDを更新する
            User::where('id', $userId)
                ->update([
                    'bank_id' => $bank['id']
                    // 'bank_id' => 200
                ]);
        } elseif($user->bank_id == $id) {
            User::where('id', $userId)
                ->update([
                    'bank_id' => null
                ]);
        }

        // 銀行情報更新
        Bank::where('id', $id)
            ->update([
                'number' => $params['number'],
                'name'   => $params['name'],
            ]);

        // ゆうちょ銀行情報登録
        BankJapan::where('bank_id', $bank['id'])
            ->update([
                'mark' => $params['mark'],
            ]);
    }

    /**
     *
     * その他銀行情報 更新処理
     *
    */
    public function bankOtherStore($params, $id)
    {
        // 基本情報セット
        $bank = Bank::find($id);
        $userId = Auth::id();
        $user = User::find($userId);

        // ユーザーのメインバンクID
        if($params['main'] === 'true') {
            // メインバンクの場合、ユーザーのバンクIDを更新する
            User::where('id', $userId)
                ->update([
                    'bank_id' => $bank['id']
                ]);
        } elseif($params['main'] === 'false' && $user['bank_id'] == $id) {
            User::where('id', $userId)
                ->update([
                    'bank_id' => null
                ]);
        }

        // 銀行情報更新
        Bank::where('id', $id)
            ->update([
                'number' => $params['number'],
                'name'   => $params['name']
            ]);

        // その他銀行情報登録
        BankOther::where('bank_id', $bank['id'])
            ->update([
                'financial_name' => $params['financial_name'],
                'branch_name'    => $params['branch_name'],
                'branch_number'  => $params['branch_number'],
                'type'           => $params['other_type']
            ]);
    }

    /**
     *
     * メインバンク変更処理
     *
    */
    public function mainBankStore($id)
    {
        // パラーメーターセット
        $userId = Auth::id();
        $updates = [
            'bank_id' => $id,
        ];
        User::where('id', $userId)->update($updates);
    }

    /**
     *
     * 銀行削除
     *
    */
    public function bankDelete($id)
    {
        // １．関連バンクの削除
        if($bank['type'] === 'japan') {
            // ゆうちょ銀行の処理
            BankJapan::where('bank_id',$id)->delete();
        } else {
            // その他銀行の処理
            BankOther::where('bank_id',$id)->delete();
        }
        // ２．バンクの削除
        $bank = Bank::where('id', $id)->delete();
    }
}
