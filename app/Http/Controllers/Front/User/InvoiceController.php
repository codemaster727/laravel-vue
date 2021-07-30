<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // 請求書_登録
    public function store($id) {
        return view('user.invoice.store', ['id' => $id]);
    }
    // 請求書_詳細
    public function show($id) {
        return view('user.invoice.show', ['id' => $id]);
    }
    // 請求書_編集
    public function update($id) {
        return view('user.invoice.update', ['id' => $id]);
    }
}
