<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkReport;

class WorkReportController extends Controller
{
    // 現場報告書_詳細
    public function show() {
        return view('user.work-report.show');
    }
    // 現場報告書_詳細
    public function storeCover($workId) {
        return view('user.work-report.storeCover', compact('workId'));
    }
    // 現場報告書_詳細_項目
    public function showItem() {
        return view('user.work-report.showItem');
    }
    // 現場報告書_編集_表紙
    public function updateCover($id) {
        $workReport = WorkReport::findOrFail($id);
        $title = $workReport->title;
        $logo = $workReport->logo;
        return view('user.work-report.updateCover', compact('id', 'title', 'logo'));
    }
    // 現場報告書_編集_項目
    public function updateItem() {
        return view('user.work-report.updateItem');
    }
    // 現場報告書_写真ダウンロード
    public function photoDownload() {
        return view('user.work-report.photoDownload');
    }
    // 現場報告書_並び替え_PDF
    public function sortItem() {
        return view('user.work-report.sortItem');
    }
    // 現場報告書_選択_PDF
    public function selectItem() {
        return view('user.work-report.selectItem');
    }
}
