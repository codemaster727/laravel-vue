<?php

namespace App\Http\Controllers\Api\User;

use Auth;
use App\Models\Work;
use App\Models\WorkReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\User\WorkReportCollection;
use App\Http\Resources\User\WorkReportResource;
use App\Http\Requests\User\WorkReportStoreRequest;
use App\Http\Requests\User\WorkReportUpdateRequest;

class WorkReportController extends ApiBaseController
{
    public function index() {
        $key = request('key');
        $sortBy = request('sort_by', 'created_at');
        $order =  request('order', 'desc');
        $perPage = request('per_page', 10);
        $currentPage = request('current_page', 1);
        $status = request()->query('status');

        $user = new WorkReport();
        $query = $user->filterByKey($key);

        return new WorkReportCollection($query->orderBy($sortBy, $order)
            ->paginate($perPage, ['*'], 'current_page'));
    }

    // 作業報告書詳細取得
    public function show(WorkReport $workReport) {
        return new WorkReportResource($workReport);
    }

    // 作業報告書登録
    public function store(WorkReportStoreRequest $request) {
        $workReport = new WorkReport();
        $workReport->work_id = $request->work_id;
        $workReport->title = $request->title;
        if ($request->hasFile('logo')) {
            $fileName = md5(date('YmdHis') . $request->logo->getFilename()) . '.' . $request->logo->extension();
            $filePath = $request->logo->storeAs('uploads/workreports', $fileName);
            $workReport->logo = '/'.$filePath;
        }
        $workReport->save();
        return response()->json([
            'id' => $workReport->id
        ]);
    }

    // 作業報告書更新
    public function update(WorkReportUpdateRequest $request, $id) {
        $workReport = WorkReport::findOrFail($id);
        $requestInfo = [
            'title' => $request->title
        ];
        if ($request->hasFile('logo')) {
            $fileName = md5(date('YmdHis') . $request->logo->getFilename()) . '.' . $request->logo->extension();
            $filePath = $request->logo->storeAs('uploads/workreports', $fileName);
            $requestInfo['logo'] = '/'.$filePath;
        }
        // DBへ保存する。
        $workReport->forceFill($requestInfo)->save();

        return response()->noContent();
    }

    // 作業報告書削除
    public function destroy(WorkReport $workReport) {
        $workReport->delete();

        return response()->noContent();
    }
}
