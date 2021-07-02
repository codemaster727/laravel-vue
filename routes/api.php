<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ユーザー
Route::resource('users', 'Api\User\UserController');
Route::prefix('users')->group(function() {
    Route::post('auth', 'Api\User\UserController@auth');
    Route::post('logout', 'Api\User\UserController@logout');
    Route::post('password-sent', 'Api\User\UserController@sentPassword');
    Route::post('password-reset', 'Api\User\UserController@resetPassword');
    Route::post('password-reset1', 'Api\User\UserController@resetPasswordByOldPass');
    Route::post('update-bank', 'Api\User\UserController@updateBank');
    Route::post('store-info', 'Api\User\UserController@input_info');
});

// ********** 管理者画面用API <BEGIN> **********
Route::namespace('Api\Manager')->prefix('manager')->group(function () {
    // 管理者
    // Route::prefix('managers')->group(function() {
    Route::post('auth', 'ManagerController@auth');
    Route::post('password-sent', 'ManagerController@sentPassword');
    Route::post('password-reset', 'ManagerController@resetPassword');
    Route::post('password-reset1', 'ManagerController@resetPasswordByOldPass');
    Route::post('manager/store', 'ManagerController@store');
    Route::post('managers/{id}/update', 'ManagerController@update');
    Route::post('managers/{id}/halt', 'ManagerController@halt');
    Route::post('managers/{id}/restore', 'ManagerController@restore');
    // });/api/user/members
    Route::apiResource('managers', 'ManagerController')->only(['index', 'show', 'destroy']);
    // ユーザー
    Route::apiResource('users', 'UserController')->only(['index', 'show', 'update', 'destroy']);
    Route::post('users/{id}/halt', 'UserController@halt');
    Route::post('users/{id}/restore', 'UserController@restore');
    Route::post('user/store', 'UserController@store');
    // 職人
    Route::apiResource('workers', 'WorkerController')->only(['index', 'show', 'update', 'destroy']);
    Route::post('workers/{id}/halt', 'WorkerController@halt');
    Route::post('workers/{id}/restore', 'WorkerController@restore');
    Route::post('worker/update', 'WorkerController@update');
    // メッセージ
    Route::apiResource('short_messages', 'ShortMessageController')->only(['index']);
    // 広告
    Route::apiResource('advertisings', 'AdvertisingController');
    Route::post('advertisings/confirm', 'AdvertisingController@confirm');
});
// ********** 管理者画面用API <END> **********

// ********** ユーザー画面用API <BEGIN> **********
Route::namespace('Api\User')->prefix('user')->group(function () {
    // 作業者
    Route::resource('workers', 'WorkerController');
    Route::post('login', 'WorkerController@login');
    Route::prefix('workers/{worker}')->group(function() {
        Route::post('changePassword', 'WorkerController@changePassword');
        Route::post('search', 'WorkerController@search');
    });
    Route::prefix('workers')->group(function() {
        Route::post('searchNew', 'WorkerController@searchNew');
    });
    // 営業担当者
    Route::apiResource('charge-users', 'ChargeUserController')->only(['index', 'store', 'show', 'update', 'destroy']);
    // 案件工程
    Route::apiResource('process', 'ProcessController')->only(['index', 'store', 'show', 'update', 'destroy']);
    // 案件職人
    Route::apiResource('charge-workers', 'ChargeWorkerController')->only(['index', 'store', 'show', 'update', 'destroy']);
    // 営業担当者
    Route::resource('members', 'MemberController');
    // メモAPI
    Route::resource('memos', 'MemoController');
    Route::post('memos/search', 'MemoController@search');
    // 診断報告書
    Route::resource('diagnosereports', 'Api\User\DiagnoseReportController')->only(['index', 'show', 'update', 'store','destroy']);
    // プロセス
    Route::resource('processmasters', 'ProcessMasterController');
    Route::resource('workreportmasters', 'WorkReportMasterController');
    Route::resource('workreportphotos', 'WorkReportPhotoController');
    Route::resource('shortmessages', 'ShortMessageController');
    // 銀行API
    Route::apiResource('banks', 'BankController')->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::get('banks/all','BankController@indexOfUser')->name('banks.index.user');
});
// ********** ユーザー画面用API <END> **********

// ********** 作業者画面用API <BEGIN> **********
Route::namespace('Api\Worker')->prefix('worker')->group(function () {
});
// ********** 作業者画面用API <END> **********

// CORS用の設定
Route::middleware(['cors'])->group(function () {
    Route::options('accounts', function () {
        return response()->json();
    });

    Route::group(['prefix' => 'user','as' =>'user.'],function () {
        // Member
        Route::resource('members', 'Api\User\MemberController')->only(['index', 'show','update','store','destroy']);
        Route::post('/members/updateMemo/{id}','Api\User\MemberController@updateMemo')->name('members.updateMemo');

        // Invoice
        Route::resource('invoices', 'Api\User\InvoiceController')->only(['index', 'show','update','store','destroy']);
        Route::get('/invoices/{id}/export-pdf','Api\User\InvoiceController@exportPdf')->name('invoices.export_pdf');
        Route::get('/invoices/{id}/preview-pdf','Api\User\InvoiceController@previewPdf')->name('invoices.preview_pdf');
        Route::post('invoices/search', 'Api\User\InvoiceController@search');
        // InvoiceItem
        Route::resource('invoice-items', 'Api\User\InvoiceItemController')->only(['index', 'show','update','store','destroy']);

        // DiagnoseReport
        Route::resource('diagnosereports', 'Api\User\DiagnoseReportController')->only(['index', 'show', 'update', 'store','destroy']);
        Route::get('/diagnosereports/{id}/pdf','Api\User\DiagnoseReportController@exportPdf')->name('diagnosereports.export_pdf');
        // DiagnoseReportItem
        Route::resource('diagnosereport-items', 'Api\User\DiagnoseReportItemController')->only(['index', 'show','update','store','destroy']);
        Route::post('diagnosereport-items/{id}/sort','Api\User\DiagnoseReportItemController@sortItem')->name('diagnosereports.sort-item');

        // Quotation
        Route::resource('quotations', 'Api\User\QuotationController')->only(['index', 'show','update', 'destroy']);
        Route::get('/quotations/{id}/export-pdf','Api\User\QuotationController@exportPdf')->name('quotations.export_pdf');
        Route::get('/quotations/{id}/preview-pdf','Api\User\QuotationController@previewPdf')->name('quotations.preview_pdf');
        Route::get('/quotations/{id}/invoice', 'Api\User\QuotationController@createOrUpdateInvoice')->name('quotations.invoice');
        Route::prefix('quotations')->group(function() {
            Route::post('store', 'Api\User\QuotationController@store');
            Route::post('search', 'Api\User\QuotationController@search');
        });

        // QuotationItem
        Route::resource('quotation-items', 'Api\User\QuotationItemController')->only(['index', 'show','update','store','destroy']);

        Route::resource('other-banks', 'Api\User\UserOtherBankController')->only(['index', 'show','update','store','destroy']);

        Route::resource('workreports', 'Api\User\WorkReportController')->only(['index', 'show','update','store','destroy']);

        Route::resource('workreportitems', 'Api\User\WorkReportItemController');
        Route::post('workreportitems/download', 'Api\User\WorkReportItemController@download');

        Route::resource('workreportphotos', 'Api\User\WorkReportPhotoController');
    });
});

Route::namespace('Api\Work')->group(function () {
    Route::apiResource('/works', 'WorkController');
    Route::prefix('works')->group(function () {
        Route::post('/updateMemo/{id}','WorkController@updateMemo')->name('works.updateMemo');
        Route::post('/confirmWork/{id}','WorkController@confirmWork')->name('works.confirmWork');
        Route::post('/completeWork/{id}','WorkController@completeWork')->name('works.completeWork');
        Route::post('/search', 'WorkController@search')->name('works.search');
        Route::get('/{id}/pdf', 'WorkController@exportPdf')->name('works.export_pdf');
    });
});

Route::namespace('Api\Client')->group(function () {
    Route::apiResource('/clients', 'ClientController');
    Route::prefix('clients')->group(function () {
        Route::post('/updateMemo/{id}','ClientController@updateMemo')->name('clients.updateMemo');
        Route::post('/search','ClientController@search')->name('clients.search');
    });
});
Route::apiResource('/charge_works', 'Api\ChargeWork\ChargeWorkController');
Route::post('/chargers', 'Api\ChargeWork\ChargeWorkController@chargers')->name('charger.list');
Route::post('/uploadBlackboard', 'Api\ChargeWork\ChargeWorkController@upload')->name('charger.upload');
Route::apiResource('/processes', 'Api\Process\ProcessController');
Route::post('/processes/search', 'Api\Process\ProcessController@search');
Route::apiResource('/process-periods', 'Api\ProcessPeriod\ProcessPeriodController');
Route::apiResource('/process-colors', 'Api\ProcessColor\ProcessColorController')->only(['index']);
Route::apiResource('/history', 'Api\History\HistoryController');
Route::get('history/daily-report/{id}', 'Api\History\HistoryController@getDailyReport');
