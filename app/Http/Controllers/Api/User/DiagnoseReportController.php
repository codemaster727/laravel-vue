<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\DiagnoseReportRequest;
use App\Http\Resources\User\DiagnoseReportResource;
use App\Models\DiagnoseReport;
use PDF;
use App\Exceptions\BadRequestErrorResponseException;

class DiagnoseReportController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DiagnoseReportResource::collection(DiagnoseReport::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiagnoseReportRequest $request)
    {
        // 診断報告書モデルインスタンス化
        $diagnoseReport = new DiagnoseReport();
        // 値を設定する
        $diagnoseReport->work_id = $request->work_id;
        $diagnoseReport->title = $request->title;
        // ロゴ画像の処理
        if ($request->hasFile('logo')) {
            $fileName = md5(date('YmdHis') . $request->logo->getFilename()) . '.' . $request->logo->extension();
            $filePath = $request->logo->storeAs('uploads/diagnose-reports', $fileName);
            $diagnoseReport->logo = '/'.$filePath;
        }
        // 保存
        $diagnoseReport->save();
        // 値を返す
        return response()->json([
            'id' => $diagnoseReport->id
        ]);
        // $diagnoseReport->work_id = $request->work_id;
        // $diagnoseReport->title = $request->title;
        // if ($request->hasFile('logo')) {
        //     $fileName = md5(date('YmdHis') . $request->logo->getFilename()) . '.' . $request->logo->extension();
        //     $filePath = $request->logo->storeAs('uploads/diagnosereports', $fileName);
        //     $diagnoseReport->logo = '/'.$filePath;
        // }
        // $diagnoseReport->save();
        // return response()->json([
        //     'id' => $diagnoseReport->id
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newDiagnoseReport = new DiagnoseReport();
        $diagnoseReports = $newDiagnoseReport->diagnoseReportShow($id);
        return $diagnoseReports;
        // return new DiagnoseReportResource(DiagnoseReport::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiagnoseReportRequest $request, $id)
    {
        $diagnoseReport = DiagnoseReport::findOrFail($id);
        $diagnoseInfo = [
            'title' => $request->title
        ];

        // PUT does not work with form-data request, so use POST with query parameter '?_method=PUT'
        if ($request->hasFile('logo')) {
            // $fileName = md5(date('YmdHis') . $request->logo->getFilename()) . '.' . $request->logo->extension();
            // $filePath = $request->logo->storeAs('public/uploads/diagnose-reports', $fileName);
            // $diagnoseInfo['logo'] = '/'.$filePath;

            $logo = $request->logo;
            $filePath = "uploads/diagnose-reports/";
            $fileName = md5(date('YmdHis') . $logo->getFilename()) . '.' . $logo->extension();
            // $photo->move(storage_path($filePath), $fileName);
            $logo->storeAs("public/uploads/diagnose-reports/", $fileName);
            $diagnoseInfo['logo'] = '/'.$filePath . $fileName;
        }

        // DBへ保存する。
        $diagnoseReport->forceFill($diagnoseInfo)->save();

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DiagnoseReport::where('id', $id)->delete();
        return response()->noContent();
    }

    /**
     * Print the specified diagnose report.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function exportPdf($id)
    {
        $diagnoseReport = DiagnoseReport::findOrFail($id);

        view()->share('diagnoseReport', $diagnoseReport);

        $pdf = PDF::loadView('user.diagnose-report.exportPDF');
        return $pdf->download('診断報告書.pdf');
    }
}
