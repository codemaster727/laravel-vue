<?php

use App\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if(config('app.env') === 'production') {
    // asset()やurl()がhttpsで生成される
    URL::forceScheme('https');
}

// TODO:初期の環境構築のOK/NG判断の為、表示用のルーティングなので最後に除外する
// Route::get('/', 'Front\TopController@index');

/* -------------------------------
	ユーザー画面
------------------------------- */
// ログイン
Route::get('/login', 'Front\User\Auth\LoginController@showLoginForm')->name('user.login');
// パスワードを忘れた方へ
Route::get('/password-send', 'Front\User\Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
Route::get('/password-reset', 'Front\User\Auth\ForgotPasswordController@showLinkResetForm')->name('user.password.reset');
// パスワード再登録
Route::get('/password-reset/new/{token?}', 'Front\User\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

// 新規登録_基本情報
Route::get('/register-info', 'Front\User\UserController@storeInfo')->name('user.store.info');
// 新規登録_担当者入力
Route::get('/register-member', 'Front\User\UserController@storeMember')->name('user.store.member');
// 新規登録_成功
Route::get('/register-success', 'Front\User\UserController@storeSuccess')->name('user.store.success');
// 新規登録_失敗
Route::get('/register-failed', 'Front\User\UserController@storeFailed')->name('user.store.failed');

Route::middleware('auth:web')->group(function() {
    // 現場_一覧取得
    Route::get('/user/work', 'Front\User\WorkController@workIndex')->name('user.work.index');
    // 現場_詳細取得
    Route::get('/user/work/detail/{id}', 'Front\User\WorkController@workShow')->name('user.work.show');
    // 現場_登録
    Route::get('/user/work/new', 'Front\User\WorkController@workStore')->name('user.work.store');
    // 現場_更新
    Route::get('/user/work/edit/{id}', 'Front\User\WorkController@workUpdate')->name('user.work.update');

    // 工程表_一覧取得
    Route::get('/user/process', 'Front\User\ProcessController@index')->name('user.process.index');
    // 工程表_登録
    Route::get('/user/process/register/{work_id}', 'Front\User\ProcessController@store')->name('user.process.store');
    // 工程表_詳細取得
    Route::get('/user/process/detail/{id}', 'Front\User\ProcessController@show')->name('user.process.show');
    // 工程表_更新
    Route::get('/user/process/edit/{id}', 'Front\User\ProcessController@update')->name('user.process.update');

    // 診断報告書_新規登録_表紙作成
    Route::get('/user/diagnose-report/register-cover/{work_id}', 'Front\User\DiagnoseReportController@storeCover')->name('user.diagnose_report.store_cover');
    // 診断報告書_新規登録_項目詳細
    Route::get('/user/diagnose-report/register-item/{id}', 'Front\User\DiagnoseReportController@storeItem')->name('user.diagnose_report.store_item');
    // 診断報告書_編集_表紙
    Route::get('/user/diagnose-report/edit-cover/{id}', 'Front\User\DiagnoseReportController@updateCover')->name('user.diagnose_report.update_cover');
    // 診断報告書_編集_項目詳細
    Route::get('/user/diagnose-report/edit-item/{id}', 'Front\User\DiagnoseReportController@updateItem')->name('user.diagnose_report.update_item');
    // 診断報告書_詳細取得_項目詳細
    Route::get('/user/diagnose-report/detail-item/{id}', 'Front\User\DiagnoseReportController@showItem')->name('user.diagnose_report.show_item');
    // 診断報告書_詳細取得
    Route::get('/user/diagnose-report/detail/{id}', 'Front\User\DiagnoseReportController@show')->name('user.diagnose_report.show');
    // 診断報告書_並び替え_項目
    Route::get('/user/diagnose-report/sort-item/{id}', 'Front\User\DiagnoseReportController@sortItem')->name('user.diagnose_report.sort_item');


    // 現場報告書_新規登録_表紙
    Route::get('/user/work-report/register-cover/{work_id}', 'Front\User\WorkReportController@storeCover')->name('user.work_report.store_cover');
    // 現場報告書_詳細
    Route::get('/user/work-report/detail/', 'Front\User\WorkReportController@show')->name('user.work_report.show');
    // 現場報告書_詳細_項目
    Route::get('/user/work-report/detail-item/{id}', 'Front\User\WorkReportController@showItem')->name('user.work_report.showItem');
    // 現場報告書_編集_表紙
    Route::get('/user/work-report/edit-cover/{id}', 'Front\User\WorkReportController@updateCover')->name('user.work_report.update_cover');
    // 現場報告書_編集_項目
    Route::get('/user/work-report/edit-item/', 'Front\User\WorkReportController@updateItem')->name('user.work_report.update_item');
    // 現場報告書_並び替え_PDF項目
    Route::get('/user/work-report/sort-item/', 'Front\User\WorkReportController@sortItem')->name('user.work_report.sort_item');
    // 現場報告書_選択_PDF項目
    Route::get('/user/work-report/select-item/', 'Front\User\WorkReportController@selectItem')->name('user.work_report.select_item');
    // 現場報告書_写真ダウンロード
    Route::get('/user/work-report/photo-download', 'Front\User\WorkReportController@photoDownload')->name('user.work_report.photo_download');

    // 見積書_登録
    Route::get('/user/quotation/register/{id}', 'Front\User\QuotationController@store')->name('user.quotation.store');
    // 見積書_詳細
    Route::get('/user/quotation/detail/{id}', 'Front\User\QuotationController@show')->name('user.quotation.show');
    // 見積書_編集
    Route::get('/user/quotation/edit/{id}', 'Front\User\QuotationController@update')->name('user.quotation.update');

    // 請求書_登録
    Route::get('/user/invoice/register/{id}', 'Front\User\InvoiceController@store')->name('user.invoice.store');
    // 請求書_詳細
    Route::get('/user/invoice/detail/{id}', 'Front\User\InvoiceController@show')->name('user.invoice.show');
    // 請求書_編集
    Route::get('/user/invoice/edit/{id}', 'Front\User\InvoiceController@update')->name('user.invoice.update');

    // 検索
    Route::get('/user/search', 'Front\User\SearchController@index')->name('user.search.index');

    // 書類一覧
    Route::get('/user/document', 'Front\User\DocumentController@index')->name('user.document.index');

    // メモ一覧
    Route::get('/user/memo', 'Front\User\MemoController@index')->name('user.memo.index');
    // メモ_詳細
    Route::get('/user/memo/detail', 'Front\User\MemoController@show')->name('user.memo.show');
    // メモ_更新
    Route::get('/user/memo/edit/{id}', 'Front\User\MemoController@update')->name('user.memo.update');
    // メモ_登録
    Route::get('/user/memo/register', 'Front\User\MemoController@store')->name('user.memo.store');

    // メニュー_一覧
    Route::get('/user/menu', 'Front\User\MenuController@index')->name('user.menu.index');
    // メニュー_登録_営業
    Route::get('/user/menu/member-register', 'Front\User\MenuController@storeMember')->name('user.menu.store_member');
    // メニュー_プロフィール編集
    Route::get('/user/menu/profile-edit', 'Front\User\MenuController@updateProfile')->name('user.menu.update_profile');
    // メニュー_パスワード編集
    Route::get('/user/menu/password-edit', 'Front\User\MenuController@updatePassword')->name('user.menu.update_password');
    // メニュー_退会
    Route::get('/user/menu/withdraw/', 'Front\User\MenuController@withdraw')->name('user.menu.withdraw');

    /* 銀行周り */
    // メニュー_銀行口座一覧
    Route::get('/user/bank', 'Front\User\MenuController@indexBank')->name('user.menu.index_bank');
    // メニュー_銀行口座編集
    Route::get('/user/bank/edit/{bank_id}', 'Front\User\MenuController@updateBank')->name('user.menu.update_bank');
    // メニュー_銀行口座登録
    Route::get('/user/bank-register', 'Front\User\MenuController@storeBank')->name('user.menu.store_bank');
    // メニュー_営業担当追加
    Route::get('/user/member-register', 'Front\User\MenuController@storeMember')->name('user.menu.store_member');
    // メニュー_営業担当編集
    Route::get('/user/member-edit/{id}', 'Front\User\MenuController@updateMember')->name('user.menu.update_member');
    // メニュー_お客様追加
    Route::get('/user/client-register', 'Front\User\MenuController@storeClient')->name('user.menu.store_client');
    // メニュー_お客様更新
    Route::get('/user/client-edit/{id}', 'Front\User\MenuController@updateClient')->name('user.menu.update_client');

    /* 職人 */
    // 職人_一覧
    Route::get('/user/worker', 'Front\User\WorkerController@index')->name('user.worker.index');
    // 職人_編集
    Route::get('/user/worker-edit/{id}', 'Front\User\WorkerController@updateWorker')->name('user.worker.update');
    // 職人_追加
    Route::get('/user/worker-register', 'Front\User\MenuController@storeWorker')->name('user.menu.store_worker');

    // 撮影項目マスター一覧
    Route::get('/user/photo-item', 'Front\User\MenuController@indexPhotoMaster')->name('user.menu.index_photo_master');
    // 工程目マスター一覧
    Route::get('/user/process-item', 'Front\User\MenuController@indexProcessMaster')->name('user.menu.index_process_master');


    /* PCのみ */
    // 営業担当一覧
    Route::get('/user/member', 'Front\User\MemberController@index')->name('user.member.index');
    // お客様一覧
    Route::get('/user/client', 'Front\User\ClientController@index')->name('user.client.index');
});


/* -------------------------------
	職人画面
------------------------------- */
// ログイン
Route::get('/worker/login', 'Front\Worker\Auth\LoginController@showLoginForm')->name('worker.login');
// パスワードを忘れた方へ
Route::get('/worker/password-reset', 'Front\Worker\Auth\ForgotPasswordController@showLinkRequestForm')->name('Worker.password.request');
// パスワード再登録
Route::get('/worker/password-reset/new', 'Front\Worker\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

// 職人用新規登録_リクエスト
Route::get('/worker/request-new', 'Front\Worker\WorkerController@storeRequest')->name('worker.store.request');
// 職人用新規登録_基本情報入力
Route::get('/worker/request-new/register', 'Front\Worker\WorkerController@storeInfo')->name('worker.store.info');
// 職人用新規登録_完了
Route::get('/worker/request-new/complete', 'Front\Worker\WorkerController@storeComplete')->name('worker.store.complete');

Route::middleware('auth:worker')->group(function() {
    // 担当現場_一覧
    Route::get('/worker/work-list', 'Front\Worker\WorkController@workIndex')->name('worker.work.index');
    // 担当現場_詳細
    Route::get('/worker/work-detail', 'Front\Worker\WorkController@workShow')->name('worker.work.show');
    // 担当現場_写真詳細
    Route::get('/worker/work-detail/photo', 'Front\Worker\WorkController@photoShow')->name('worker.work.photo_show');
    // 担当現場_黒板追加
    Route::get('/worker/work-detail/photo-blackboard/', 'Front\Worker\WorkController@blackboardStore')->name('worker.work.blackboard_store');
    // 担当現場_写真を位置
    Route::get('/worker/work-detail/photo-position/', 'Front\Worker\WorkController@photoPosition')->name('worker.work.photo_position');

    // プロフィール_詳細
    Route::get('/worker/profile', 'Front\Worker\ProfileController@profileShow')->name('worker.profile.show');
    // プロフィール_更新
    Route::get('/worker/profile/edit', 'Front\Worker\ProfileController@profileUpdate')->name('worker.profile.update');
});



/* -------------------------------
	お客様画面
------------------------------- */
// 詳細
Route::get('/client/daily-report', 'Front\Client\ClientController@show')->name('client.show');



/* -------------------------------
	管理者画面
------------------------------- */
// ログイン
Route::get('/manager/login', 'Front\Manager\Auth\LoginController@showLoginForm')->name('manager.login');
// パスワードを忘れた方へ
Route::get('/manager/password-reset', 'Front\Manager\Auth\ForgotPasswordController@showLinkRequestForm')->name('manager.password.request');
// パスワード再登録
Route::get('/manager/password-reset/new/', 'Front\Manager\Auth\ResetPasswordController@showResetForm')->name('manager.password.reset');

Route::middleware('auth:manager')->group(function() {
    // ユーザー_一覧
    Route::get('/manager/user', 'Front\Manager\UserController@index')->name('manager.user.index');
    // ユーザー_詳細
    Route::get('/manager/user/edit/{id}', 'Front\Manager\UserController@update')->name('manager.user.update');
    // ユーザー_更新
    Route::get('/manager/user/register', 'Front\Manager\UserController@store')->name('manager.user.store');

    // 職人_一覧
    Route::get('/manager/worker/', 'Front\Manager\WorkerController@index')->name('manager.worker.index');
    // 職人_更新
    Route::get('/manager/worker/edit', 'Front\Manager\WorkerController@update')->name('manager.worker.update');

    // 管理者_一覧
    Route::get('/manager/manager', 'Front\Manager\ManagerController@index')->name('manager.manager.index');
    // 管理者_更新
    Route::get('/manager/manager/edit/{id}', 'Front\Manager\ManagerController@update')->name('manager.manager.update');
    // 管理者_登録
    Route::get('/manager/manager/register', 'Front\Manager\ManagerController@store')->name('manager.manager.store');

    // 広告掲載_一覧
    Route::get('/manager/advertising', 'Front\Manager\AdvertisingController@index')->name('manager.advertising.index');
    // 広告掲載_更新
    Route::get('/manager/advertising/edit/{id}', 'Front\Manager\AdvertisingController@update')->name('manager.advertising.update');
    // 広告掲載_登録
    Route::get('/manager/advertising/register', 'Front\Manager\AdvertisingController@store')->name('manager.advertising.store');

    // SMS利用状況
    Route::get('/manager/sms', 'Front\Manager\SmsController@index')->name('manager.sms.index');
    // ログアウト
    Route::get('/manager/logout', 'Front\Manager\Auth\LoginController@logout')->name('manager.logout');
});



/* -------------------------------
	広告画面
------------------------------- */
// 広告_一覧
Route::get('/sponcer', 'Front\Sponcer\SponcerController@index')->name('sponcer.index');

// 広告_登録確認
Route::get('/sponcer/confirm', 'Front\Sponcer\SponcerController@confirm')->name('sponcer.confirm');

// 広告_登録完了
Route::get('/sponcer/complete', 'Front\Sponcer\SponcerController@complete')->name('sponcer.complete');


// ***** ユーザー画面 *****
// ユーザー未ログイン時に使用する画面
// TODO:ルーティングを定義する

// ユーザーログイン後に使用する画面
Route::middleware('auth:web')->group(function() {
    // TODO:ルーティングを定義する
});

// ***** 作業者画面 *****
Route::middleware('auth:worker')->prefix('worker')->group(function() {
    // TODO:ルーティングを定義する
});

// ***** 元請け画面 *****
// TODO:ルーティングを定義する

// ***** 管理者画面 *****
Route::middleware('auth:admin')->group(function() {
    // TODO:ルーティングを定義する
});


Route::get('/client/daily-report/{id}', 'Front\Client\ClientController@dailyReport')->name('client.dailyReport');

Route::get('/client/show', 'Front\Client\ClientController@show');
// Route::middleware(['cors'])->group(function () {
Route::get('/quotations/{id}/export-pdf','Api\User\QuotationController@exportPdf');
Route::get('/invoices/{id}/preview-pdf','Api\User\InvoiceController@previewPdf');
// Route::get('/quotations/{id}/preview-pdf1','Api\User\QuotationController@previewPdf1');
// });