<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\WorkReportMasterRequest;
use App\Http\Resources\User\WorkReportMaster as WorkReportMasterResource;
use App\Http\Resources\User\WorkReportMasterCollection;
use App\Models\WorkReportMaster;

class WorkReportMasterController extends Controller
{
    /**
     * Instantiate a new controller instance
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * 撮影項目名マスターリストを取得する。
     * @get ("/api/user/workreportmasters")
     * @return WorkReportMasterCollection
     */
    public function index()
    {
        // 入力
        $sortBy = request()->query('sort_by', 'created_at');
        $order =  request()->query('order', 'desc');

        $perPage     = request('per_page', 10);
        $currentPage = request('current_page', 1);

        // 撮影項目名マスターリストを取得する
        $workReportMasters = new WorkReportMaster();
        $query = $workReportMasters->myWorkReportMasters();

        return new WorkReportMasterCollection($query->orderBy($sortBy, $order)->paginate((int) $perPage, ['*'], 'current_page'));
    }

    /**
     * 新規撮影項目名マスターを登録する。
     * @post ("/api/user/workreportmasters/store")
     *     @Parameter("name", type="string", required="true", description="撮影項目名"),
     * @param WorkReportMasterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkReportMasterRequest $request)
    {
        $workReportMasterInfo = [
            'user_id'     => \Auth::user()->id,
            'name'        => request('name'),
        ];

        $workReportMaster = WorkReportMaster::create($workReportMasterInfo);
        $workReportMaster->save();

        return response()->noContent();
    }

    /**
     * 撮影項目名マスターの詳細情報を取得する。
     * @get ("/api/user/workreportmasters/{id}")
     * @param WorkReportMaster $workReportMaster
     * @return WorkReportMasterResource
     */
    public function show(WorkReportMaster $workReportMaster)
    {
        return new WorkReportMasterResource($workReportMaster);
    }

    /**
     * 撮影項目名マスター情報を更新する。
     * @patch ("/api/user/workreportmasters/{id}")
     *     @Parameter("name", type="string", required="true", description="撮影項目名"),
     * @param WorkReportMasterRequest $request
     * @param WorkReportMaster $workReportMaster
     * @return \Illuminate\Http\Response
     */
    public function update(WorkReportMasterRequest $request, WorkReportMaster $workReportMaster)
    {
        $workReportMasterInfo = [
            'name'    => request('name'),
        ];
        $workReportMaster->forceFill($workReportMasterInfo)->save();
        return response()->noContent();
    }

    /**
     * 撮影項目名マスター情報を削除する。
     * @delete ("/api/user/workreportmasters/{id}")
     * @param WorkReportMaster $workReportMaster
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(WorkReportMaster $workReportMaster)
    {
        $workReportMaster->delete();
        return response()->noContent();
    }
}
