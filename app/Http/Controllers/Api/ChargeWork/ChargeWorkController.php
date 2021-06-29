<?php

namespace App\Http\Controllers\Api\ChargeWork;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\ChargeWork\ChargeWorkResource;
use App\Http\Resources\ChargeWork\ChargeWorkResourceCollection;
use App\Http\Requests\ChargeWork\ChargeWorkStoreRequest;
use App\Http\Requests\ChargeWork\ChargeWorkUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ChargeWork;
use App\Models\Worker;
use App\Models\WorkReportPhoto;

class ChargeWorkController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ChargeWorkList = ChargeWork::paginate();
        return (new ChargeWorkResourceCollection($ChargeWorkList))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChargeWorkStoreRequest $request)
    {
        $ChargeWork = new ChargeWork();

        $ChargeWork->charge_id = $request->input('charge_id');
        $ChargeWork->worker_id = $request->input('worker_id');
        $ChargeWork->save();

        return (new ChargeWorkResource($ChargeWork))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ChargeWork $ChargeWork)
    {
        return (new ChargeWorkResource($ChargeWork))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChargeWorkUpdateRequest $request, ChargeWork $ChargeWork)
    {
        $ChargeWork->charge_id = $request->input('charge_id');
        $ChargeWork->worker_id = $request->input('worker_id');
        $ChargeWork->save();

        return (new ChargeWorkResource($ChargeWork))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChargeWork $ChargeWork)
    {
        $ChargeWork->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function chargers(Request $request) {
        $work_id = request('work_id');

        $worker_ids = ChargeWork::where('work_id', $work_id)->select('worker_id')->get()->toArray();
        $ids = array();
        foreach($worker_ids as $key => $item) {
            array_push($ids, $item['worker_id']);
        }
        if(!isset($ids) || count($ids) == 0)
            return reponse()->json(array());

        $worker_ids = $ids;
        $workers = Worker::whereIn('id', $worker_ids)->pluck('name', 'id');

        return response()->json($workers);
    }

    public function upload(Request $request) {
        $file = $request->file('files');

        $now = time();
        $fileName = 'blackboard';
        $ret = $file->move('uploads/blackboard/', $now . '_' . $fileName . '.png');
        $url = url('/') . '/uploads/blackboard/' . $now . '_' . $fileName . '.png';

        $items = new WorkReportPhoto();
        $items->work_id = request('work_id');
        $items->photo = $url;
        $items->save();

        return response()->json($file);
    }
}
