<?php

namespace App\Http\Controllers\Api\Process;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Process\ProcessResource;
use App\Http\Resources\Process\ProcessResourceCollection;
use App\Http\Requests\Process\ProcessStoreRequest;
use App\Http\Requests\Process\ProcessUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Process;

class ProcessController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ProcessList = Process::paginate();
        return (new ProcessResourceCollection($ProcessList))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(ProcessStoreRequest $request)
    public function store(Request $request)
    {
        $Process = new Process();

        $Process->work_id = $request->input('work_id');
        $Process->process_color_id = $request->input('process_color_id', 0);
        $Process->name = $request->input('name');
        $Process->memo = $request->input('memo');
        $Process->save();

        return (new ProcessResource($Process))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Process $Process)
    {
        return (new ProcessResource($Process))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProcessUpdateRequest $request, Process $Process)
    {
        $Process->work_id = $request->input('work_id');
        $Process->process_color_id = $request->input('process_color_id');
        $Process->name = $request->input('name');
        $Process->memo = $request->input('memo');
        $Process->save();

        return (new ProcessResource($Process))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $Process)
    {
        $Process->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function search(Request $request)
    {
        return Process::search($request->all());
    }
}
