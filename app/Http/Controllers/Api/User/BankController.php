<?php

namespace App\Http\Controllers\Api\User;


use App\Models\Bank;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newBank = new Bank();
        $userId = Auth::id();
        $banks = $newBank->bankListOfUser($userId);
        return $banks;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOfUser()
    {
        $newBank = new Bank();
        $banks = $newBank->bankList();
        return $banks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newBank = new Bank();
        $bank = $newBank->bankShow($id);
        return $bank;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newBank = new Bank();
        // 銀行タイプによる条件分岐
        if($request->status === 'japan') {
            // 郵貯銀行の場合
            $newBank->bankJapanStore($request->all(), $id);
        } elseif($request->status === 'other') {
            // その他銀行の場合
            $newBank->bankOtherStore($request->all(), $id);
        } elseif($request->status === 'main') {
            // 銀行の情報のみ変更
            $newBank->mainBankStore($id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newBank = new Bank();
        $newBank->bankDelete($id);
    }
}
