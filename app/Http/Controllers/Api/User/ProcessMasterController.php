<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProcessMasterRequest;
use App\Http\Resources\User\ProcessMaster as ProcessMasterResource;
use App\Http\Resources\User\ProcessMasterCollection;
use App\Models\ProcessMaster;

class ProcessMasterController extends Controller
{
    /**
     * Instantiate a new controller instance
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * 工程名マスターリストを取得する。
     * @get ("/api/user/processmasters")
     * @return ProcessMasterCollection
     */
    public function index()
    {
        // 入力
        $sortBy = request()->query('sort_by', 'created_at');
        $order =  request()->query('order', 'desc');

        $perPage     = request('per_page', 10);
        $currentPage = request('current_page', 1);

        // 工程名マスターリストを取得する
        $processMasters = new ProcessMaster();
        $query = $processMasters->myProcessMasters();

        return new ProcessMasterCollection($query->orderBy($sortBy, $order)->paginate((int) $perPage, ['*'], 'current_page'));
    }

    /**
     * 新規工程名マスターを登録する。
     * @post ("/api/user/processmasters/store")
     *     @Parameter("name", type="string", required="true", description="工程名"),
     * @param ProcessMasterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcessMasterRequest $request)
    {
        $processMasterInfo = [
            'user_id'     => \Auth::user()->id,
            'name'        => request('name'),
        ];

        $processMaster = ProcessMaster::create($processMasterInfo);
        $processMaster->save();

        return response()->noContent();
    }

    /**
     * 工程名マスターの詳細情報を取得する。
     * @get ("/api/user/processmasters/{id}")
     * @param ProcessMaster $processMaster
     * @return ProcessMasterResource
     */
    public function show(ProcessMaster $processMaster)
    {
        return new ProcessMasterResource($processMaster);
    }

    /**
     * 工程名マスター情報を更新する。
     * @patch ("/api/user/processmasters/{id}")
     *     @Parameter("name", type="string", required="true", description="工程名"),
     * @param ProcessMasterRequest $request
     * @param ProcessMaster $processMaster
     * @return \Illuminate\Http\Response
     */
    public function update(ProcessMasterRequest $request, ProcessMaster $processMaster)
    {
        $processMasterInfo = [
            'name'    => request('name'),
        ];
        $processMaster->forceFill($processMasterInfo)->save();
        return response()->noContent();
    }

    /**
     * 工程名マスター情報を削除する。
     * @delete ("/api/user/processmasters/{id}")
     * @param ProcessMaster $processMaster
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ProcessMaster $processMaster)
    {
        $processMaster->delete();
        return response()->noContent();
    }
}
