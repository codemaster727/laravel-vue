<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">メモ詳細</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li><a :href="editUrl()">編集する</a></li>
                        <li class="icon"><a @click="toggleModalTrush"><img src="/img/icon-dust-navygray.png"></a></li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a @click.prevent="toggleModalTrush">
                                <img src="/img/icon-add-black.png">
                                <span>メモ作成</span>
                            </a>
                        </li>
                        <li class="icon">
                            <a @click.prevent="toggleModalTrush">
                                <img src="/img/icon-dust-black.png">
                                <span>削除</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__detail">
            <div class="l-wrap--button sp-only">
                <ul class="l-wrap--button__list button-one">
                    <li><a href="">編集する</a></li>
                    <li><a href="">復元する</a></li>
                </ul>
            </div>
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__detail__box" style="width: 100% !important">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">メモ情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>ステータス</th>
                                <td>{{ data.status }}</td>
                            </tr>
                            <tr>
                                <th>作成者</th>
                                <td>{{ data.member }}</td>
                            </tr>
                            <tr>
                                <th>タイトル</th>
                                <td>{{ data.title }}</td>
                            </tr>
                            <tr>
                                <th>本文</th>
                                <td>{{ data.text }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
	    props: ['memo_id', 'url'],
        data() {
            return {
                data: [],
                field1: '',
                field2: '',
                ja: vdp_translation_ja.js,
                DatePickerFormat: 'yyyy-MM-dd', // datepicker
                panelActive: '1', // タブ切り替え
                isModalSms: false, // SMSモーダル
                isModalTrash: false, // 削除モーダル
                isModalConfirm: false, // 現場確定モーダル
                isModalComplete: false, // 現場完了モーダル
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadData();
        },
        computed: {},
        methods: {
            // パネルの切り替え
            changePanel: function(num) {
                this.panelActive = num
            },
            // SMSモーダル
            toggleModalSms: function() {
                this.isModalSms = !this.isModalSms
            },
            // 削除モーダル
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },
            // 現場確定モーダル
            toggleModalConfirm: function() {
                this.isModalConfirm = !this.isModalConfirm
            },
            // 現場完了モーダル
            toggleModalComplete: function() {
                this.isModalComplete = !this.isModalComplete
            },
            editUrl: function() {
                return this.url + '/user/memo/edit?id=' + this.memo_id;
            },
            loadData: function() {
                axios.get('/api/user/memos/' + this.memo_id)
                    .then(result => {
                        let data = result.data.data;
                        if (data) {
                            this.data = {
                                status: (data.deleted_at == null) ? '削除前' : '削除済み',
                                member: data.member_name,
                                title: data.title,
                                text: data.text,
                            }
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            }
        },
        watch: {},
	}
</script>
