<?php

namespace App\Http\Controllers\Api\Manager;

use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\WorkerResource;
use App\Http\Requests\User\WorkerRequest;
use App\Http\Resources\User\WorkerCollection;
use App\Http\Controllers\Api\ApiBaseController;

class WorkerController extends ApiBaseController
{
    /**
     * 職人の一覧情報を取得する。
     * @get ("/api/manager/workers")
     * @param Worker $worker
     * @return WorkerCollection
     */
    public function index(Request $request)
    {
        $users = Worker::searchOnManager($request->all())->get();
        return new WorkerCollection($users);
    }

    /**
     * 職人の詳細情報を取得する。
     * @get ("/api/manager/workers/{id}")
     * @param Worker $worker
     * @return WorkerResource
     */
    public function show(Worker $worker)
    {
        return new WorkerResource($worker);
    }

    /**
     * 職人情報を更新する。
     * @patch ("/api/manager/workers/{id}")
     *     @Parameter("name", type="string", required="true", description="名前"),
     *     @Parameter("email", type="email", required="true", description="メールアドレス"),
     *     @Parameter("manager_remark", type="text", required="false", description="管理者備考"),
     * @param WorkerRequest $request
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worker $worker)
    {
        $workerInfo = [
            'name'            => request('name'),
            'email'           => request('email'),
            'manager_remark'  => request('manager_remark'),
        ];
        if (request('worker_id_code')) {
            $workerInfo = array_merge($workerInfo, request('worker_id_code'));
        }
        if (request('password')) {
            $workerInfo = array_merge($workerInfo, array('password' => Hash::make(request('password'))));
        }
        $worker->forceFill($workerInfo)->save();
        return response()->noContent();
    }

    /**
     * 職人情報を削除する。
     * @delete ("/api/manager/workers/{id}")
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();
        return response()->noContent();
    }

    // 職人の停止
    public function halt($id) {
        $worker = Worker::findOrFail($id);
        $params = array (
            'status' => config('const.user.status.halting')
        );
        $worker->fill($params)->save();
        return response()->noContent();
    }

    // 職人の再開
    public function restore($id) {
        $worker = Worker::findOrFail($id);
        $params = array (
            'status' => config('const.user.status.active')
        );
        $worker->fill($params)->save();
        return response()->noContent();
    }
}
