<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\Client;
use App\Models\ShortMessage;
use App\Jobs\SendShortMessage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\ShortMessageRequest;
use App\Http\Resources\User\ShortMessageCollection;
use App\Http\Resources\User\ShortMessage as ShortMessageResource;

class ShortMessageController extends ApiBaseController
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
     * @get ("/api/manager/short_messages")
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
}
