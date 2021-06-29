<?php

namespace App\Http\Controllers\Api\History;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\History\HistoryResource;
use App\Http\Resources\History\HistoryResourceCollection;
use App\Http\Requests\History\HistoryStoreRequest;
use App\Http\Requests\History\HistoryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\History; 

class HistoryController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historyList = History::paginate();
        return (new HistoryResourceCollection($historyList))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HistoryStoreRequest $request)
    {
        $history = new History();
        $history->work_id = $request->input('work_id');
        $history->charge_id = $request->input('charge_id');
        $history->charge_work_status = $request->input('charge_work_status');
        $history->work_date = $request->input('work_date');
        $history->work_start_on = $request->input('work_start_on');
        $history->work_finish_on = $request->input('work_finish_on');
        $history->save();

        return (new HistoryResource($history))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        return (new HistoryResource($history))->response();
    }

    public function getDailyReport($id = 0){
        if($id == 0) return false;

        $historyList = History::join('works', 'histories.work_id', '=', 'works.id')
                                ->join('workers', 'works.user_id', '=', 'workers.worker_id')
                                ->where('works.user_id', '=', $id)
                                ->get(['histories.*', 'works.name as work_name', 'workers.name as worker_name']);
        return (new HistoryResource($historyList))->response();
    }

    /**
    * Update the specified resource in storage.
    *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HistoryUpdateRequest $request, History $history)
    {
        $history->work_id = $request->input('work_id');
        $history->charge_id = $request->input('charge_id');
        $history->charge_work_status = $request->input('charge_work_status');
        $history->work_date = $request->input('work_date');
        $history->work_start_on = $request->input('work_start_on');
        $history->work_finish_on = $request->input('work_finish_on');
        $history->save();

        return (new HistoryResource($history))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        $history->delete();
        return response()->noContent();
    }
}
