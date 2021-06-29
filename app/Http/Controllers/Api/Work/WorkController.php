<?php

namespace App\Http\Controllers\Api\Work;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Work\WorkResource;
use App\Http\Resources\Work\WorkResourceCollection;
use App\Http\Requests\Work\WorkStoreRequest;
use App\Http\Requests\Work\WorkUpdateRequest;
use App\Http\Requests\Work\WorkMemoUpdateRequest;
use App\Models\ChargeWorker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Work;
use App\Models\WorkReport;
use PDF;

class WorkController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workList = Work::paginate();
        return (new WorkResourceCollection($workList))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkStoreRequest $request)
    {
        $work = new Work();
        $work->user_id = $request->input('user_id');
        $work->status = $request->input('status');
        $work->name = $request->input('name');
        $work->temporary_start_date = $request->input('temporary_start_date');
        $work->temporary_finish_date = $request->input('temporary_finish_date');
        $work->period_start_date = $request->input('period_start_date');
        $work->period_finish_date = $request->input('period_finish_date');
        $work->client_id = $request->input('client_id');
        $work->member_id = $request->input('member_id');
        $work->save();

        return (new WorkResource($work))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        return (new WorkResource($work->load('process')))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(WorkUpdateRequest $request, Work $work)
    // public function update(WorkUpdateRequest $request, $id)
    public function update(Request $request, $id)
    {
        // １．案件情報を更新する
        $work = Work::where('id', $id);
        $workParams = array (
            'name'                   => $request->input('name'),
            'temporary_start_date'   => $request->input('temporary_start_date'),
            'temporary_finish_date'  => $request->input('temporary_finish_date'),
            'period_start_date'      => $request->input('period_start_date'),
            'period_finish_date'     => $request->input('period_finish_date'),
            'postal'                 => $request->input('postal'),
            'address'                => $request->input('address'),
            'client_id'              => $request->input('client_id'),
            'member_id'              => $request->input('member_id'),
            'remark'                 => $request->input('remark'),
            'memo'                   => $request->input('memo'),
            'status'                 => $request->input('status'),
        );
        $work->update($workParams);

        // 職人が情報としてあった場合の処理
        if($request->input('workers')) {
            // ２．案件と紐づく職人情報を全て削除する
            ChargeWorker::where('work_id', $id)->delete();

            // ３．案件の職人情報を更新する
            $workers = $request->input('workers');
            foreach($workers as $worker) {
                $newChargeWorker = new ChargeWorker();
                $newChargeWorker->work_id   = $id;
                $newChargeWorker->worker_id = $worker['worker_id'];
                $newChargeWorker->save();
            }
        }

        // $work->name = $request->input('name');
        // $work->temporary_start_date = $request->input('temporary_start_date');
        // $work->temporary_finish_date = $request->input('temporary_finish_date');
        // $work->period_start_date = $request->input('period_start_date');
        // $work->period_finish_date = $request->input('period_finish_date');
        // $work->postal = $request->input('postal');
        // $work->address = $request->input('address');
        // $work->client_id = $request->input('client_id');
        // $work->member_id = $request->input('member_id');
        // $work->remark = $request->input('remark');
        // $work->memo = $request->input('memo');
        // $work->status = $request->input('status');
        // $work->save();
        // return (new WorkResource($work))->response();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        $work->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function completeWork($id)
    {
        $work = Work::find($id);
        $work->update(['status' => 2]);

        return (new WorkResource($work))->response();
    }

    public function confirmWork(Request $request, $id)
    {
        // $work = Work::find($id, ['status', 'period_start_date', 'period_finish_date']);
        $work = Work::find($id);
        $param = $request->all();
        $work->update($param);
        return (new WorkResource($work))->response();
    }

    public function updateMemo(WorkMemoUpdateRequest $request, $id) {

        $work = Work::find($id);
        $work->memo = $request->only('name','memo');
        $work->save();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Print the specified work report.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function exportPdf($id)
    {
        $workReport = WorkReport::findOrFail($id);

        view()->share('workReport', $workReport);

        $pdf = PDF::loadView('user.work-report.exportPDF');
        return $pdf->download('現場報告書.pdf');
    }

    /**
     * Search the work list from condition.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // var_dump($request->all());exit;
        
        return (new WorkResourceCollection(Work::search($request->all())
            ->where('name', 'like', "%$request->keyword%")
            ->orWhere('address', 'like', "%$request->keyword%")
            ->orWhere('remark', 'like', "%$request->keyword%")
            ->orWhere('memo', 'like', "%$request->keyword%")
            ->orderBy('created_at', 'DESC')
            ->paginate()))->response();
    }
}
