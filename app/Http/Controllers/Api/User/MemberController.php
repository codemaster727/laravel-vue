<?php

namespace App\Http\Controllers\Api\User;

use Auth;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\MemberRequest;
use App\Http\Resources\User\MemberResource;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends ApiBaseController
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = Auth::user();
        return MemberResource::collection(Member::where('user_id', $user->id)->get());
    }


    public function store(MemberRequest $request)
    {
        $params = array(
            'user_id'   => Auth::user()->id,
            'name'      => request('name'),
            'memo'      => request('memo'),
        );
        Member::create($params);

        return response()->noContent();
    }


    public function show($id)
    {
        $item = Member::where('id', $id)->get();

        return MemberResource::collection($item);
    }



    public function update(MemberRequest $request, $id)
    {
        $params = array(
            'name'      => request('name'),
            'memo'      => request('memo'),
        );
        Member::where('id', $id)->update($params);

        return response()->noContent();
    }


    // public function destroy($id)
    public function destroy(Member $member)
    {
        // Member::where('id', $id)->delete();
        // return response()->noContent();
        $member->delete();
        return response()->noContent();
    }

    public function updateMemo(Request $request,$id){

        Member::where('id',$id)->update($request->only('memo'));
        return response()->noContent();
    }
}
