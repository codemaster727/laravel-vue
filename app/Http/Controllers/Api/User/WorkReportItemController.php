<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\WorkReportItemUpdateRequest;
use Auth;
use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\WorkReport;
use App\Models\WorkReportItem;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\User\WorkReportItemsResource;
use App\Http\Resources\User\WorkReportItemsCollection;
use App\Http\Requests\User\WorkReportItemStoreRequest;

class WorkReportItemController extends ApiBaseController
{
    // 撮影項目一覧取得
    public function index() {
        $key = request('key');
        $sortBy = request('sort_by', 'created_at');
        $order =  request('order', 'desc');
        $perPage = request('per_page', 10);
        $currentPage = request('current_page', 1);
        $status = request()->query('status');

        $user = new WorkReportItem();
        $query = $user->filterByKey($key);

        return new WorkReportItemsCollection($query->orderBy($sortBy, $order)
            ->paginate($perPage, ['*'], 'current_page'));
    }

    // 撮影項目詳細取得
    public function show(WorkReportItem $workReportItem) {
        return new WorkReportItemsResource($workReportItem);
    }

    // 撮影項目登録
    public function store(WorkReportItemStoreRequest $request) {
        $workReport = WorkReport::where('title', request('work_report'))->first();
        $work = Work::where('name', request('work'))->first();

        $params = array(
            'work_report_id'    => $workReport->id,
            'work_id'           => $work->id,
            'photo'             => request('photo', ''),
            'name'              => request('name', ''),
            'work_date'         => request('work_date', ''),
            'photographer'      => request('photographer', ''),
            'content'           => request('content', ''),
            'remark'            => request('remark', ''),
            'memo'              => request('memo', ''),
            'order'             => request('order', 0),
            'pdf'               => request('pdf', 0),
        );

        $workReportItem = WorkReportItem::create($params);
        $workReportItem->save();

        return response()->noContent();
    }

    // 撮影項目更新
    public function update(WorkReportItemUpdateRequest $request, WorkReportItem $workReportItem) {
        $params = array(
            'work_report_id'    => $workReportItem->work_report_id,
            'work_id'           => $workReportItem->work_id,
            'photo'             => request('photo', $workReportItem->photo),
            'name'              => request('name', $workReportItem->name),
            'work_date'         => request('work_date', $workReportItem->work_date),
            'photographer'      => request('photographer', $workReportItem->photographer),
            'content'           => request('content', $workReportItem->content),
            'remark'            => request('remark', $workReportItem->remark),
            'memo'              => request('memo', $workReportItem->memo),
            'order'             => request('order', $workReportItem->order),
            'pdf'               => request('pdf', $workReportItem->pdf),
        );

        $workReport = WorkReport::where('title', request('work_report'))->first();
        $work = Work::where('name', request('work'))->first();
        if (isset($workReport)) {
            $params['work_report_id'] = $workReport->id;
        }
        if (isset($work)) {
            $params['work_id'] = $work->id;
        }

        $workReportItem->fill($params)->save();

        return response()->noContent();
    }

    // 撮影項目削除
    public function destroy(WorkReportItem $workReportItem) {
        $workReportItem->delete();

        return response()->noContent();
    }

    // 撮影項目ダウンロード
    public function download(Request $request) {
        $url = request('photo');

        return response()->download($url);
    }
}
