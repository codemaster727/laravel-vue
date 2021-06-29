<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\UserOtherBankRequest;
use App\Http\Resources\User\UserOtherBankResource;
use App\Models\OtherBank;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserOtherBankController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserOtherBankResource::collection(OtherBank::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserOtherBankRequest $request)
    {
        $user = Auth::user();
        $params = array(
            'user_id'           => $user->id,
            'financial_name'    => request('financial_name'),
            'branch_name'       => request('branch_name'),
            'branch_number'     => request('branch_number'),
            'type'              => request('type'),
            'number'            => request('number'),
            'name'              => request('name'),
        );
        $bankId = OtherBank::create($params)->id;
        $bankType = 1; // Other Bank

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
        return new UserOtherBankResource(OtherBank::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserOtherBankRequest $request, $id)
    {
        $user = Auth::user();
        $params = array(
            'user_id'           => $user->id,
            'financial_name'    => request('financial_name'),
            'branch_name'       => request('branch_name'),
            'branch_number'     => request('branch_number'),
            'type'              => request('type'),
            'number'            => request('number'),
            'name'              => request('name'),
        );

        OtherBank::where('id', $id)->update($params);

        /** Update user's bank info */
        $isMain = request('main');
        if ($isMain) {
            $user->bank_id = $id;
            $user->bank_type = 1; // other-bank
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
        OtherBank::where('id', $id)->delete();
        return response()->noContent();
    }
}
