<?php

namespace App\Http\Controllers\Api\User;

use Log;
use Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Worker;
use App\Models\Work;
use App\Http\Resources\User\Worker as WorkerResource;
use App\Http\Resources\User\WorkerCollection;
use App\Http\Requests\User\WorkerLoginRequest;
use App\Http\Requests\User\WorkerRequest;
use App\Http\Requests\User\WorkerChangePasswordRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Passwords\PasswordBroker;

class WorkerController extends ApiBaseController
{
    /**
     * Instantiate a new controller instance
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * 職人リストを取得する。
     * @get ("/api/user/workers")
     * @return WorkerCollection
     */
    public function index()
    {
        // 入力
        $workList = Work::paginate();
        return (new WorkerCollection($workList))->response();
    }

    // ログイン
    public function login(Request $request)
    {
        $result = array(
            'session_id'    => '',
        );
        $params = array(
            'email'             => request('email', ''),
            'password'          => request('password', ''),
            'remember_token'    => request('remember_token', false),
        );

        $user = Worker::where('email', $params['email'])->first();
        if (isset($user) && password_verify($params['password'], $user->password)) {
            $user = Auth::guard('worker')->loginUsingId($user->id, $params['remember_token']);
            Session::push('worker_id', $user->id);
            $result['session_id'] = Session::getId();
        }
        return response()->json($result);
    }

    /**
     * 新規職人を登録する。
     * @post ("/api/user/workers/store")
     *     @Parameter("name", type="string", required="true", description="名前"),
     *     @Parameter("email", type="email", required="true", description="メールアドレス"),
     *     @Parameter("password", type="string", required="true", description="パスワード"),
     *     @Parameter("manager_remark", type="text", required="false", description="管理者備考"),
     * @param WorkerRequest $request
     * @return \Illuminate\Http\Response
     */
    // public function store(WorkerRequest $request)
    public function store(Request $request)
    {
        $workerInfo = [
            'name'            => $request['name'],
            'email'           => $request['email'],
            'password'        => bcrypt($request['password']),
            'status'          => 0,
            'worker_code'     => $request['code'],
        ];
        // $workerInfo = [
        //     'name'            => request('name'),
        //     'email'           => request('email'),
        //     'password'        => bcrypt(request('password')),
        //     'status'          => request('status', config('const.worker.status.active')),
        //     'worker_code'     => request('code'),
        // ];

        $worker = Worker::create($workerInfo);
        $worker->save();

        return response()->noContent();
    }

    /**
     * 職人の詳細情報を取得する。
     * @get ("/api/user/workers/{id}")
     * @param Worker $worker
     * @return WorkerResource
     */
    public function show(Worker $worker)
    {
        return new WorkerResource($worker);
    }

    /**
     * 職人情報を更新する。
     * @patch ("/api/user/workers/{id}")
     *     @Parameter("name", type="string", required="true", description="名前"),
     *     @Parameter("email", type="email", required="true", description="メールアドレス"),
     *     @Parameter("manager_remark", type="text", required="false", description="管理者備考"),
     * @param WorkerRequest $request
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     */
    public function update(WorkerRequest $request, Worker $worker)
    {
        $workerInfo = [
            'name'            => request('name'),
            'manager_remark'  => request('manager_remark'),
        ];
        $worker->forceFill($workerInfo)->save();
        return response()->noContent();
    }

    /**
     * 職人情報を削除する。
     * @delete ("/api/user/workers/{id}")
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();
        return response()->noContent();
    }

    /**
     *
     * 職人を検索する
     * @post ("/api/user/workers/{id}/search")
     *
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     * @throws \Exception
     *
     */
    public function search($id)
    {
        $worker = Worker::where('worker_code', $id)->first();
        // return $id;
        return $worker;
    }

    /**
     *
     * 職人を検索するnew
     * @post ("/api/user/workers/searchNew")
     *
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     * @throws \Exception
     *
     */
    public function searchNew(Request $request)
    {
        // $worker = Worker::where('worker_code', $id)->first();
        return (new WorkerCollection(Worker::where('name', 'like', "%$request->keyword%")
            ->orWhere('email', 'like', "%$request->keyword%")
            ->orWhere('manager_remark', 'like', "%$request->keyword%")
            ->orderBy('created_at', 'ASC')
            ->paginate()))->response();
        // return $id;
        // return $worker;
    }
    /**
     *
     * パスワード変更
     * @post ("/api/user/workers/{id}/changePassword")
     *     @Parameter("password", type="string", required="true", description="新規パスワード"),
     *     @Parameter("password_confirmation", type="string", required="true", description="確認用新規パスワード"),
     *
     * @param WorkerChangePasswordRequest $request
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     */
    public function changePassword(WorkerChangePasswordRequest $request, Worker $worker)
    {
        $worker->password = bcrypt(request('password'));
        $worker->save();

        return response()->noContent();
    }

}
