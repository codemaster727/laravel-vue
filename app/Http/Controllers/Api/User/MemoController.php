<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\MemoRequest;
use App\Http\Resources\User\Memo as MemoResource;
use App\Http\Resources\User\MemoCollection;
use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * Instantiate a new controller instance
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * ユーザーのメモリストを取得する。
     * @get ("/api/user/memos")
     * @return MemoCollection
     */
    public function index()
    {
        // 入力
        $sortBy = request()->query('sort_by', 'created_at');
        $order =  request()->query('order', 'desc');

        $perPage     = request('per_page', 10);
        $currentPage = request('current_page', 1);

        // メモリストを取得する
        $memos = new Memo();
        $query = $memos->myMemos();

        return new MemoCollection($query->orderBy($sortBy, $order)->paginate((int) $perPage, ['*'], 'current_page'));
    }

    /**
     * 新規メモを登録する。
     * @post ("/api/user/memos/store")
     *     @Parameter("member_id", type="integer", required="true", description="営業担当者ID（作成者）"),
     *     @Parameter("title", type="string", required="true", description="タイトル"),
     *     @Parameter("text", type="text", required="true", description="本文"),
     * @param MemoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemoRequest $request)
    {
        $memoInfo = [
            'user_id'     => \Auth::user()->id,
            'member_id'   => request('member_id'),
            'title'       => request('title'),
            'text'        => request('text'),
        ];

        $memo = Memo::create($memoInfo);
        $memo->save();

        return response()->noContent();
    }

    /**
     * メモの詳細情報を取得する。
     * @get ("/api/user/memos/{id}")
     * @param Memo $memo
     * @return MemoResource
     */
    public function show(Memo $memo)
    {
        return new MemoResource($memo);
    }

    /**
     * メモ情報を更新する。
     * @patch ("/api/user/memos/{id}")
     *     @Parameter("member_id", type="integer", required="true", description="営業担当者ID（作成者）"),
     *     @Parameter("title", type="string", required="true", description="タイトル"),
     *     @Parameter("text", type="text", required="true", description="本文"),
     * @param MemoRequest $request
     * @param Memo $memo
     * @return \Illuminate\Http\Response
     */
    public function update(MemoRequest $request, Memo $memo)
    {
        $memoInfo = [
            'member_id'   => request('member_id'),
            'title'   => request('title'),
            'text'    => request('text'),
        ];
        $memo->forceFill($memoInfo)->save();
        return response()->noContent();
    }

    /**
     * メモ情報を削除する。
     * @delete ("/api/user/memos/{id}")
     * @param Memo $memo
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Memo $memo)
    {
        $memo->delete();
        return response()->noContent();
    }

    public function search(Request $request)
    {
        return (new MemoCollection(Memo::search($request->all())->paginate()))->response();
    }
}
