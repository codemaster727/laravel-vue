<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiagnoseReport;
use App\Models\DiagnoseReportItem;

class DiagnoseReportController extends Controller
{
    // 診断報告書_詳細取得
    public function show($id) {
        return view('user.diagnose-report.show', compact('id'));
    }

    // 診断報告書_登録_表紙
    public function storeCover($workId) {
        return view('user.diagnose-report.storeCover', compact('workId'));
    }

    // 診断報告書_登録_項目
    public function storeItem($id) {
        return view('user.diagnose-report.storeItem', compact('id'));
    }

    // 診断報告書_編集_項目
    public function updateItem($id) {
        return view('user.diagnose-report.updateItem', compact('id'));
        // $diagnoseReportItem = DiagnoseReportItem::findOrFail($id);
        // $name = $diagnoseReportItem->name;
        // $content = $diagnoseReportItem->content;
        // $photo = $diagnoseReportItem->photo;
        // return view('user.diagnose-report.updateItem', compact('id', 'name', 'content', 'photo'));
    }

    // 診断報告書_編集_表紙
    public function updateCover($id) {
        return view('user.diagnose-report.updateCover', compact('id'));
        // $diagnoseReport = DiagnoseReport::findOrFail($id);
        // $title = $diagnoseReport->title;
        // $logo = $diagnoseReport->logo;
        // return view('user.diagnose-report.updateCover', compact('id', 'title', 'logo'));
    }

    // 診断報告書_詳細取得_項目
    public function showItem($id) {
        return view('user.diagnose-report.showItem', compact('id'));
    }

    // 診断報告書_並び替え_項目
    public function sortItem($id) {
        return view('user.diagnose-report.sortItem', compact('id'));
    }
}
