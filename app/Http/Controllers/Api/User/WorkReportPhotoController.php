<?php

namespace App\Http\Controllers\Api\User;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Work;
use App\Models\WorkReportPhoto;
use App\Http\Resources\User\WorkReportPhotoResource;
use App\Http\Resources\User\WorkReportPhotoCollection;
use App\Http\Requests\User\WorkReportPhotoStoreRequest;
use App\Http\Requests\User\WorkReportPhotoUpdateRequest;

class WorkReportPhotoController extends ApiBaseController
{
    // 作業報告書画像一覧取得
    public function index() {
        $key = request('key');
        $sortBy = request('sort_by', 'created_at');
        $order =  request('order', 'desc');
        $perPage = request('per_page', 10);
        $currentPage = request('current_page', 1);
        $status = request()->query('status');

        $workReportPhoto = new WorkReportPhoto();
        $query = $workReportPhoto->filterByKey($key);

        return new WorkReportPhotoCollection($query->orderBy($sortBy, $order)
            ->paginate($perPage, ['*'], 'current_page'));
    }

    // 作業報告書画像詳細取得
    public function show(WorkReportPhoto $workReportPhoto) {
        return new WorkReportPhotoResource($workReportPhoto);
    }

    // 作業報告書画像登録
    public function store(WorkReportPhotoStoreRequest $request) {
        $work = Work::where('name', request('work'))->first();

        $params = array(
            'work_id'       => $work->id,
            'photo'         => request('photo', ''),
        );

        $user = WorkReportPhoto::create($params);
        $user->save();

        return response()->noContent();
    }

    // 作業報告書画像更新
    public function update(WorkReportPhotoUpdateRequest $request, WorkReportPhoto $workReportPhoto) {
        $params = array(
            'work_id'       => $workReportPhoto->work_id,
            'photo'         => request('photo', $workReportPhoto->photo),
        );

        $work = Work::where('name', request('work'))->first();
        if (isset($work)) {
            $params['work_id'] = $work->id;
        }

        $workReportPhoto->fill($params)->save();

        return response()->noContent();
    }

    // 作業報告書画像削除
    public function destroy(WorkReportPhoto $workReportPhoto) {
        $workReportPhoto->delete();

        return response()->noContent();
    }
}
