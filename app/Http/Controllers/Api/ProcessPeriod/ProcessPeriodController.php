<?php

namespace App\Http\Controllers\Api\ProcessPeriod;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\ProcessPeriod\ProcessPeriodResource;
use App\Http\Resources\ProcessPeriod\ProcessPeriodResourceCollection;
use App\Http\Requests\ProcessPeriod\ProcessPeriodStoreRequest;
use App\Http\Requests\ProcessPeriod\ProcessPeriodUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ProcessPeriod; 

class ProcessPeriodController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ProcessPeriodList = ProcessPeriod::paginate();
        return (new ProcessPeriodResourceCollection($ProcessPeriodList))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcessPeriodStoreRequest $request)
    {
        $ProcessPeriod = new ProcessPeriod();

        $ProcessPeriod->process_id = $request->input('process_id');
        $ProcessPeriod->start_date = $request->input('start_date');
        $ProcessPeriod->finish_date = $request->input('finish_date');
        $ProcessPeriod->save();

        return (new ProcessPeriodResource($ProcessPeriod))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProcessPeriod $ProcessPeriod)
    {
        return (new ProcessPeriodResource($ProcessPeriod))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProcessPeriodUpdateRequest $request, ProcessPeriod $ProcessPeriod)
    {
        $ProcessPeriod->process_id = $request->input('process_id');
        $ProcessPeriod->start_date = $request->input('start_date');
        $ProcessPeriod->finish_date = $request->input('finish_date');
        $ProcessPeriod->save();

        return (new ProcessPeriodResource($ProcessPeriod))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcessPeriod $ProcessPeriod)
    {
        $ProcessPeriod->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
