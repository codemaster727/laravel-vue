/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import store from './store/index'

window.Vue = require('vue');

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)
Vue.$cookies.config('7d')



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// TODO:共通で使用するライブラリがある場合、可能な限りここでインポートする

// TODO:初期表示テスト用なので、本格実装後に除外する
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('posts', require('./components/Posts.vue').default);
Vue.component('createPost', require('./components/CreatePost.vue').default);
Vue.component('dailyReports', require('./components/DailyReports.vue').default);

// ユーザー新規登録_基本情報入力
Vue.component('user-store-info-component', require('./components/user/store/infoComponent.vue').default);

// ユーザー画面
Vue.component('user-auth-login-component', require('./components/user/auth/loginComponent.vue').default);
Vue.component('user-auth-password-email-component', require('./components/user/auth/emailPasswordComponent.vue').default);
Vue.component('user-auth-password-reset-component', require('./components/user/auth/resetPasswordComponent.vue').default);

// Vue.component('yet-project-sp-component', require('./components/user/YetProjectSpComponent.vue').default);
// 現場_一覧（/user/work）
Vue.component('user-work-index-component', require('./components/user/work/indexComponent.vue').default);
// 現場_詳細(/user/work/new/)
Vue.component('user-work-show-component', require('./components/user/work/showComponent.vue').default);
// 現場_登録(/user/work/new/)
Vue.component('user-work-store-component', require('./components/user/work/storeComponent.vue').default);
// 現場_編集(/user/work/edit/)
Vue.component('user-work-update-component', require('./components/user/work/updateComponent.vue').default);

// 工程表_一覧_パソコン(/user/process)
Vue.component('user-process-pc-component', require('./components/user/process/indexPcComponent.vue').default);
// 工程表_一覧_スマホ(/user/process)
Vue.component('user-process-sp-component', require('./components/user/process/indexSpComponent.vue').default);
// 工程表_登録(/user/process/new)
Vue.component('user-process-create-component', require('./components/user/process/storeComponent.vue').default);
// 工程表_詳細(/user/process/detail)
Vue.component('user-process-show-component', require('./components/user/process/showComponent.vue').default);
// 工程表_更新(/user/process/edit)
Vue.component('user-process-update-component', require('./components/user/process/updateComponent.vue').default);

Vue.component('user-diagnose-report-register-cover-component', require('./components/user/diagnose-report/registerCoverComponent.vue').default);
Vue.component('user-diagnose-report-update-cover-component', require('./components/user/diagnose-report/updateCoverComponent.vue').default);
Vue.component('user-diagnose-report-store-item-component', require('./components/user/diagnose-report/storeItemComponent.vue').default);
Vue.component('user-diagnose-report-update-item-component', require('./components/user/diagnose-report/updateItemComponent.vue').default);

// 診断報告書_詳細取得(/user/deiagnose-report/detail)
Vue.component('user-diagnose-report-show-component', require('./components/user/diagnose-report/showComponent.vue').default);
// 診断報告書_詳細取得_項目(/user/diagnose-report/detail-item)
Vue.component('user-diagnose-report-show-item-component', require('./components/user/diagnose-report/showItemComponent.vue').default);
// 診断報告書_並び替え_項目(/user/diagnose-report/sort-item)
Vue.component('user-diagnose-report-sort-item-component', require('./components/user/diagnose-report/sortItemComponent.vue').default);

// 現場報告書_表紙作成
Vue.component('user-work-report-register-cover-component', require('./components/user/work-report/registerCoverComponent.vue').default);
Vue.component('user-work-report-update-cover-component', require('./components/user/work-report/updateCoverComponent.vue').default);
// 現場報告書_詳細
Vue.component('user-work-report-show-component', require('./components/user/work-report/showComponent.vue').default);
// 現場報告書_詳細取得_項目(/user/diagnose-report/detail-item)
Vue.component('user-work-report-show-item-component', require('./components/user/work-report/showItemComponent.vue').default);
// 現場報告書_並び替え_PDF
Vue.component('user-work-report-sort-item-component', require('./components/user/work-report/sortItemComponent.vue').default);

// 見積書_詳細
Vue.component('user-quotation-show-component', require('./components/user/quotation/showComponent.vue').default);
// 見積書_登録（/user/quotation/register）
Vue.component('user-quotation-store-component', require('./components/user/quotation/storeComponent.vue').default);
// 見積書_更新（/user/quotation/edit
Vue.component('user-quotation-update-component', require('./components/user/quotation/updateComponent.vue').default);

// 請求書_詳細
Vue.component('user-invoice-show-component', require('./components/user/invoice/showComponent.vue').default);
// 請求書_登録（/user/quotation/register）
Vue.component('user-invoice-store-component', require('./components/user/invoice/storeComponent.vue').default);
// 請求書_更新（/user/quotation/edit
Vue.component('user-invoice-update-component', require('./components/user/invoice/updateComponent.vue').default);

// 検索
Vue.component('user-search-index-component', require('./components/user/search/indexComponent.vue').default);

// 見積・請求書
Vue.component('user-document-index-component', require('./components/user/document/indexComponent.vue').default);

// メモ
Vue.component('user-memo-index-component', require('./components/user/memo/indexComponent.vue').default);
Vue.component('user-memo-store-component', require('./components/user/memo/storeComponent.vue').default);
Vue.component('user-memo-show-component', require('./components/user/memo/showComponent.vue').default);
Vue.component('user-memo-update-component', require('./components/user/memo/updateComponent.vue').default);

// 職人
Vue.component('user-worker-index-component', require('./components/user/worker/indexComponent.vue').default); // PCのみ
Vue.component('user-worker-store-component', require('./components/user/worker/storeComponent.vue').default);
Vue.component('user-worker-update-component', require('./components/user/worker/updateWorkerComponent.vue').default);

// メニュー
Vue.component('user-menu-index-component', require('./components/user/menu/indexComponent.vue').default);
Vue.component('user-menu-profile-update-component', require('./components/user/menu/updateProfileComponent.vue').default);
Vue.component('user-menu-password-update-component', require('./components/user/menu/updatePasswordComponent.vue').default);
Vue.component('user-menu-bank-index-component', require('./components/user/menu/indexBankComponent.vue').default);
Vue.component('user-menu-bank-store-component', require('./components/user/menu/storeBankComponent.vue').default);
Vue.component('user-menu-bank-update-component', require('./components/user/menu/updateBankComponent.vue').default);
Vue.component('user-menu-process-master-component', require('./components/user/menu/processMasterComponent.vue').default);
Vue.component('user-menu-photo-master-component', require('./components/user/menu/photoMasterComponent.vue').default);
Vue.component('user-menu-member-store-component', require('./components/user/menu/storeMemberComponent.vue').default);
Vue.component('user-menu-member-update-component', require('./components/user/menu/updateMemberComponent.vue').default);
Vue.component('user-menu-client-store-component', require('./components/user/menu/storeClientComponent.vue').default);
Vue.component('user-menu-client-update-component', require('./components/user/menu/updateClientComponent.vue').default);

/* PCのみ */
// お客様
Vue.component('user-client-index-component', require('./components/user/client/indexComponent.vue').default);
// 営業担当
Vue.component('user-member-index-component', require('./components/user/member/indexComponent.vue').default);


// 管理者画面
Vue.component('manager-auth-login', require('./components/manager/auth/managerAuthLogin.vue').default);
Vue.component('manager-auth-password-email-component', require('./components/manager/auth/emailPasswordComponent.vue').default);
Vue.component('manager-auth-password-reset-component', require('./components/manager/auth/resetPasswordComponent.vue').default);
Vue.component('manager-user-list-component', require('./components/manager/UserListComponent.vue').default);
Vue.component('manager-advertising-list-component', require('./components/manager/AdvertisingListComponent.vue').default);
Vue.component('manager-advertising-register-component', require('./components/manager/AdvertisingRegisterComponent.vue').default);
Vue.component('manager-advertising-update-component', require('./components/manager/AdvertisingUpdateComponent.vue').default);
Vue.component('manager-sms-list-component', require('./components/manager/SmsListComponent.vue').default);

// 広告
Vue.component('manager-sponcer-index-component', require('./components/manager/sponcer/indexComponent.vue').default);
Vue.component('manager-sponcer-confirm-component', require('./components/manager/sponcer/confirmComponent.vue').default);
Vue.component('manager-sponcer-complete-component', require('./components/manager/sponcer/completeComponent.vue').default);

// 職人用
Vue.component('worker-request-login-component', require('./components/user/worker/request/loginComponent.vue').default);
Vue.component('worker-request-register-component', require('./components/user/worker/request/registerComponent.vue').default);
Vue.component('worker-request-register-complete-component', require('./components/user/worker/request/registerCompleteComponent.vue').default);
Vue.component('worker-list-index-component', require('./components/user/worker/list/indexComponent.vue').default);
Vue.component('worker-detail-index-component', require('./components/user/worker/detail/indexComponent.vue').default);
Vue.component('worker-request-blackboard-component', require('./components/user/worker/detail/photoBlackBoardComponent.vue').default);
Vue.component('worker-request-blackboard-store-component', require('./components/user/worker/detail/photoBlackBoardStoreComponent.vue').default);

// ユーザー_追加
Vue.component('manager-user-store-component', require('./components/manager/userStoreComponent.vue').default);
// ユーザー_更新
Vue.component('manager-user-update-component', require('./components/manager/userUpdateComponent.vue').default);
// 職人_一覧
Vue.component('manager-worker', require('./components/manager/workerComponent.vue').default);
// 職人_更新
Vue.component('manager-worker-update', require('./components/manager/workerUpdateComponent.vue').default);
// 管理者_一覧
Vue.component('manager-manager', require('./components/manager/managerComponent.vue').default);
// 管理者_追加
Vue.component('manager-manager-store', require('./components/manager/managerStoreComponent.vue').default);
// 管理者_更新
Vue.component('manager-manager-update', require('./components/manager/managerUpdateComponent.vue').default);

// モーダルウィンドウ
// Vue.component('modal', require('./components/common/Modal.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 
