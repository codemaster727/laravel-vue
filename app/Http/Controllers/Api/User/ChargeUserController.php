<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChargeUser;

class ChargeUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $targets = ChargeUser::where('user_id', $userId)->get();
        $chargeUsers = [];
        foreach($targets as $index => $target) {
            $chargeUsers[$index] = ChargeUser::find($target->id);
            $chargeUsers[$index]['name'] = ChargeUser::find($target->id)->worker->name;
            $chargeUsers[$index]['email'] = ChargeUser::find($target->id)->worker->email;
        }
        return $chargeUsers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $workerId = $request->input('id');

        // 担当者追加処理
        $chargeUserNew = new ChargeUser();
        $chargeUserNew->user_id   = $userId;
        $chargeUserNew->worker_id = $workerId;
        $chargeUserNew->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chargeUser = ChargeUser::find($id)->worker;
        $chargeUser['memo'] = ChargeUser::find($id)->memo;
        return $chargeUser;
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
        $chargeUser = ChargeUser::find($id);
        $chargeUser->memo = $request->get('memo');
        $chargeUser->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chargeUser = ChargeUser::find($id);
        $chargeUser->delete();
    }
}
