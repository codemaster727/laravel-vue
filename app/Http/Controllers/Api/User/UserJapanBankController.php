<?php

namespace App\Http\Controllers\Api\User;

use Auth;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\UserJapanBankRequest;
use App\Http\Resources\User\UserJapanBankResource;
use App\Models\JapanBank;
use App\Models\User;

class UserJapanBankController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserJapanBankResource::collection(JapanBank::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserJapanBankRequest $request)
    {
        $user = Auth::user();
        $params = array(
            'user_id'   => $user->id,
            'mark'      => request('mark'),
            'number'    => request('number'),
            'name'      => request('name'),
        );
        $bankId = JapanBank::create($params)->id;
        $bankType = 0; // Japan Bank

        /** Update user's bank info */
        $isMain = request('main');
        if ($isMain) {
            $user->bank_id = $bankId;
            $user->bank_type = $bankType;
            $user->save();
        }

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserJapanBankResource(JapanBank::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserJapanBankRequest $request, $id)
    {
        $user = Auth::user();
        $params = array(
            'user_id'   => $user->id,
            'mark'      => request('mark'),
            'number'    => request('number'),
            'name'      => request('name'),
        );
        JapanBank::where('id', $id)->update($params);

        $isMain = request('main');
        if ($isMain) {
            $user->bank_id = $id;
            $user->bank_type = 0; // japan-bank
            $user->save();
        }

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JapanBank::where('id', $id)->delete();
        return response()->noContent();
    }
}
