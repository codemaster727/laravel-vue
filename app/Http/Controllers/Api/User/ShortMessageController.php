<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ShortMessageRequest;
use App\Http\Resources\User\ShortMessage as ShortMessageResource;
use App\Http\Resources\User\ShortMessageCollection;
use App\Models\ShortMessage;
use App\Models\Client;
use App\Jobs\SendShortMessage;

class ShortMessageController extends Controller
{
    /**
     * Instantiate a new controller instance
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * ショートメッセージリストを取得する。
     * @get ("/api/user/shortmessages")
     * @return ShortMessageCollection
     */
    public function index()
    {
        // 入力
        $sortBy = request()->query('sort_by', 'created_at');
        $order =  request()->query('order', 'desc');

        $perPage     = request('per_page', 10);
        $currentPage = request('current_page', 1);

        // ショートメッセージリストを取得する
        $shortMessages = new ShortMessage();
        $query = $shortMessages->myShortMessages();

        return new ShortMessageCollection($query->orderBy($sortBy, $order)->paginate((int) $perPage, ['*'], 'current_page'));
    }

    /**
     * 新規ショートメッセージを登録する。
     * @post ("/api/user/shortmessages/store")
     *     @Parameter("name", type="string", required="true", description="撮影項目名"),
     * @param ShortMessageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShortMessageRequest $request)
    {
        $clientID = $request->get('client_id');
        $msgType = $request->get('type');

        $shortMessageInfo = [
            'user_id'     => \Auth::user()->id,
            'work_id'     => $request->get('work_id'),
            'client_id'   => $clientID,
            'type'        => $msgType,
        ];

        $shortMessage = ShortMessage::create($shortMessageInfo);
        $shortMessage->save();

        // ショートメッセージ送信
        $client = Client::findOrFail($clientID);
        $message = $msgType;
        if ($msgType == 1) {
            $workDetailUrl = url('/user/work/detail/' . $request->get('work_id'));
            $message = <<<MSG
{$client->name}様へ
この度はご契約いただきありがとうございます。
今後の進捗や施工写真などはURLをクリックして頂ければ閲覧でできますのでよろしくお願いします。
URL: {$workDetailUrl}
MSG;
        }
        SendShortMessage::dispatch($client->tel, $message);

        return response()->noContent();
    }

    /**
     * ショートメッセージの詳細情報を取得する。
     * @get ("/api/user/shortmessages/{id}")
     * @param ShortMessage $shortMessage
     * @return ShortMessageResource
     */
    public function show(ShortMessage $shortMessage)
    {
        return new ShortMessageResource($shortMessage);
    }

    /**
     * ショートメッセージ情報を更新する。
     * @patch ("/api/user/shortmessages/{id}")
     *     @Parameter("name", type="string", required="true", description="撮影項目名"),
     * @param ShortMessageRequest $request
     * @param ShortMessage $shortMessage
     * @return \Illuminate\Http\Response
     */
    public function update(ShortMessageRequest $request, ShortMessage $shortMessage)
    {
        $clientID = $request->get('client_id');
        $msgType = $request->get('type');

        $shortMessageInfo = [
            'work_id'     => $request->get('work_id'),
            'client_id'   => $clientID,
            'type'        => $msgType,
        ];
        $shortMessage->forceFill($shortMessageInfo)->save();

        // ショートメッセージ送信
        $client = Client::findOrFail($clientID);
        SendShortMessage::dispatch($client->tel, $msgType);

        return response()->noContent();
    }

    /**
     * ショートメッセージ情報を削除する。
     * @delete ("/api/user/shortmessages/{id}")
     * @param ShortMessage $shortMessage
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ShortMessage $shortMessage)
    {
        $shortMessage->delete();
        return response()->noContent();
    }
}
