<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagnoseReportItem extends Model
{
    use SoftDeletes;
    protected $table = 'diagnose_report_items';
    protected $fillable = ['diagnose_report_id', 'photo', 'name', 'content', 'sort_order'];
    public function diagnoseReport() {
        return $this->belongsTo('App\Models\DiagnoseReport', 'diagnose_report_id');
    }

    /**
     *
     * 診断報告書項目の保存処理
     * $id：診断報告書ID（$reportIds）
     * $params：診断報告書項目一覧（$items）
     *
     */
    public function storeItems($id, $params)
    {
        // 既に登録済みの案件項目数を取得
        $registerItems = self::where('diagnose_report_id', $id)->get();
        $registerNumber = count($registerItems);
        // 登録数を取得する
        $number = count($params['name']);

        // 登録数ループ処理を行う
        for($i = 0; $i < $number; $i++) {
            $diagnoseReportItem = new DiagnoseReportItem();
            $diagnoseReportItem->diagnose_report_id = $id;
            $diagnoseReportItem->name = $params['name'][$i];
            $diagnoseReportItem->content = $params['content'][$i];
            $diagnoseReportItem->sort_order = $params['sort'][$i] + $registerNumber;
            // 画像のファイル名を決定する
            $photo = $params['photo'][$i];
            // return $photo;
            if($photo) {
                $filePath = "img/diagnose-report-items/";
                $fileName = md5(date('YmdHis') . $photo->getFilename()) . '.' . $photo->extension();
                // $photo->move(storage_path($filePath), $fileName);
                $photo->storeAs("public/img/diagnose-report-items/", $fileName);
                $diagnoseReportItem->photo = $filePath . $fileName;
            }
            $diagnoseReportItem->save();
        }
    }

    /**
     *
     * 診断報告書項目の保存処理
     * $id：診断報告書項目のID
     * $param：診断報告書項目の詳細
     *
     */
    public function updateItem($id, $param)
    {
        // 対象の診断報告書項目取得
        $diagnoseReportItem = self::where('id', $id);

        // 更新する情報を取得する
        $info = [
            'name'    => $param['name'],
            'content' => $param['content'],
        ];

        // 画像を別の場所に保存する
        $photo = $param['photo'];

        // 画像ファイルがある場合の処理
        if(is_object($photo)) {
            $filePath = "img/diagnose-reports/";
            $fileName = md5(date('YmdHis') . $photo->getFilename()) . '.' . $photo->extension();
            // $photo->move(storage_path($filePath), $fileName);
            $photo->storeAs("public/img/diagnose-reports/", $fileName);
            // $info.push({'photo': $filePath . $fileName});
            // $param['photo'] = $filePath . $fileName;
            $info += array('photo', $filePath . $fileName);
        } elseif(empty($photo)) {
            // 画像がない場合の保存方法
            // $param['photo'] = 'img/1560031.jpg';
            $info += array('photo', 'img/1560031.jpg');
        }

        // 配列の情報を更新する
        $diagnoseReportItem->update($info);
    }

    /**
     *
     * 診断報告書項目の保存処理
     * @param int $id（診断報告書ID）
     *
     */
    public function sortItems($id, $params)
    {
        // 繰り返し処理を行う
        $number = count($params['sort']);
        // 登録数ループ処理を行う
        for($i = 0; $i < $number; $i++) {
            $diagnoseReportItem = self::where('id', $params['id'][$i]);
            $info = [
                'sort_order' => $params['sort'][$i],
            ];
            $diagnoseReportItem->update($info);
        }
    }
}
