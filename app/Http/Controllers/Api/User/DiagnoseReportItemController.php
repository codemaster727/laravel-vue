<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\User\DiagnoseReportItemRequest;
use App\Http\Resources\User\DiagnoseReportItemResource;
use App\Models\DiagnoseReport;
use App\Models\DiagnoseReportItem;
use Illuminate\Http\Request;


class DiagnoseReportItemController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DiagnoseReportItemResource::collection(DiagnoseReportItem::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    // public function store(DiagnoseReportItemRequest $request)
    {
        // １．受け取った値を変数に入れ替える
        $reportId = $request->diagnose_report_id;
        $items = $request->items;

        // ２．繰り返し処理を行う
        $newDiagnoseReportItem = new DiagnoseReportItem();
        $newDiagnoseReportItem->storeItems($reportId, $items);
        return response()->noContent();

        // for($i = 0; $i < $number; $i++) {
        //     $diagnoseReportItem = new DiagnoseReportItem();
        //     $diagnoseReportItem->diagnose_report_id = $reportId;
        //     $diagnoseReportItem->name = $items['name'][$i];
        //     $diagnoseReportItem->content = $items['content'][$i];
        //     $diagnoseReportItem->sort_order = $items['sort'][$i];
        //     // 画像のファイル名を決定する
        //     $photo = $items['photo'][$i];
        //     // return $photo;
        //     if($photo) {
        //         $filePath = "img/diagnose-reports/{$reportId}/";
        //         $fileName = md5(date('YmdHis') . $photo->getFilename()) . '.' . $photo->extension();
        //         // $photo->move(storage_path($filePath), $fileName);
        //         $photo->storeAs("public/img/diagnose-reports/{$reportId}/", $fileName);
        //         $diagnoseReportItem->photo = $filePath . $fileName;
        //     }
        //     $diagnoseReportItem->save();
        //     // $diagnoseReportItem = new DiagnoseReportItem();
        //     // $diagnoseReportItem->diagnose_report_id = $reportId;
        //     // $diagnoseReportItem->name = $request->items['name'][$i];
        //     // $diagnoseReportItem->content = $request->items['content'][$i];
        //     // $diagnoseReportItem->sort_order = $request->items['sort'][$i];
        //     // // 画像のファイル名を決定する
        //     // $photo = $request->items['photo'][$i];
        //     // // return $photo;
        //     // if($photo) {
        //     //     $filePath = "img/diagnose-reports/{$reportId}/";
        //     //     $fileName = md5(date('YmdHis') . $photo->getFilename()) . '.' . $photo->extension();
        //     //     // $photo->move(storage_path($filePath), $fileName);
        //     //     $photo->storeAs("public/img/diagnose-reports/{$reportId}/", $fileName);
        //     //     $diagnoseReportItem->photo = $filePath . $fileName;
        //     // }
        // }
        // return response()->noContent();

        // 診断報告書の情報を取得する
        // $diagnoseReportID = $request->diagnose_report_id;
        // $diagnoseReport = DiagnoseReport::findOrFail($diagnoseReportID);

        // // 報告書項目の情報
        // $diagnoseReportItem = new DiagnoseReportItem();
        // $diagnoseReportItem->diagnose_report_id = $diagnoseReportID;
        // $diagnoseReportItem->name = $request->get('name');
        // $diagnoseReportItem->content = $request->get('content');
        // if ($request->hasFile('photo')) {
        //     $filePath = "img/diagnose_reports/{$diagnoseReport->work_id}/";
        //     $fileName = md5(date('YmdHis') . $request->photo->getFilename()) . '.' . $request->photo->extension();
        //     $request->photo->move(storage_path($filePath), $fileName);
        //     $diagnoseReport->photo = $filePath . $fileName;
        // }
        // $diagnoseReportItem->save();
        // return response()->noContent();


        // // 診断報告書の情報を取得する
        // $diagnoseReport = DiagnoseReport::findOrFail($reportId);



        // foreach ($items as $index => $item) {
        //     $diagnoseReportItem = new DiagnoseReportItem();
        //     $diagnoseReportItem->$item = $request->items[$index];
            // return $item;
            // return $request->items[$index];

            // return $request->items['name'][$index];
            // $diagnoseReportItem->name = $request->items['name'][$index];
            // $diagnoseReportItem->content = $request->items['content'][$index];
            // $diagnoseReportItem->sort = $request->items['sort'][$index];
            // return $request->items['photo'][$index];
        // foreach($items as $item) {
            // 診断報告書項目を登録
            // $diagnoseReportItem = new DiagnoseReportItem();
            // $diagnoseReportItem->diagnose_report_id = $reportId;
            // $diagnoseReportItem->name = $item['name'];
            // $diagnoseReportItem->content = $item['content'];
            // $diagnoseReportItem->sort_order = $item['sort'];
            // if ($item['photo']) {
                // ランダムな値
                // $randams = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 24);
                // $filePath = "img/diagnose-reports/{$diagnoseReport->work_id}/";
                // $fileName = md5(date('YmdHis') . $item['preview']) . '.' . $randams;
                // $item['preview']->move(storage_path($filePath), $fileName);
                // $diagnoseReportItem->photo = $filePath . $fileName;

                // $filePath = "img/diagnose_reports/{$diagnoseReport->work_id}/";
                // $fileName = md5(date('YmdHis') . $request->photo->getFilename()) . '.' . $request->photo->extension();
                // $request->photo->move(storage_path($filePath), $fileName);
                // $diagnoseReport->photo = $filePath . $fileName;
            // }
        //     $diagnoseReportItem->save();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return DiagnoseReportItem::find($id)->diagnose_reports;
        return new DiagnoseReportItemResource(DiagnoseReportItem::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(DiagnoseReportItemRequest $request, $id)
    public function update(Request $request, $id)
    {
        // 値をセットする
        $item = [
            'name' => $request->name,
            'content' => $request->content,
            'photo' => $request->photo,
        ];
        $newDiagnoseReportItem = new DiagnoseReportItem();
        return $newDiagnoseReportItem->updateItem($id, $item);
        return response()->noContent();

        // // 診断報告書の情報を取得する
        // $diagnoseReportItem = DiagnoseReportItem::findOrFail($id);
        // $diagnoseReport = DiagnoseReport::findOrFail($diagnoseReportItem->diagnose_report_id);

        // // PUT does not work with form-data request, so use POST with query parameter '?_method=PUT'
        // $photoFilePath = '';
        // if($request->hasFile('photo')) {
        //     $filePath = "img/diagnose-reports/{$diagnoseReport->work_id}/";
        //     $fileName = md5(date('YmdHis') . $request->photo->getFilename()) . '.' . $request->photo->extension();
        //     $request->photo->move(storage_path($filePath), $fileName);
        //     $photoFilePath = $filePath . $fileName;
        // }

        // // DBへ保存する。
        // $diagnoseReportItemInfo = [
        //     'name'     => $request->get('name'),
        //     'content'  => $request->get('content'),
        //     'photo'    => $photoFilePath
        // ];
        // $diagnoseReportItem->forceFill($diagnoseReportItemInfo)->save();
        // return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DiagnoseReportItem::where('id', $id)->delete();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sortItem(Request $request, $id)
    {
        $items = $request->items;
        $newDiagnoseReportItem = new DiagnoseReportItem();
        $newDiagnoseReportItem->sortItems($id, $items);
        return response()->noContent();
    }
}
