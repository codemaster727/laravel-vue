<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    // 見積もり書_登録
    public function store() {
        return view('user.quotation.store');
    }
    // 見積もり書_詳細
    public function show($id) {
    	return view('user.quotation.show', array('id' => $id));
    }
    // 見積もり書_編集
    public function update($id) {
        return view('user.quotation.update', array('id' => $id));
    }
}
