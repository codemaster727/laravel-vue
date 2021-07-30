<template>
    <div class="l-wrap--inner">

        <!-- modal：削除 -->
        <div class="l-modal" :class="{'open': isModalTrash}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalTrush">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">本当に削除しても<br>よろしいでしょうか？</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalTrush">いいえ</a></li>
                            <li><a @click="deleteQuotation">はい</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal：削除 -->


        <!-- modal：確定 -->
        <div class="l-modal" :class="{'open': isModalConfirm}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalConfirm">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">見積書を確定しても<br>よろしいでしょうか？</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalConfirm">いいえ</a></li>
                            <li><a @click="confirmQuotation">はい</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal：削除 -->


        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">見積書詳細</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li><a :href="`/api/user/quotations/${id}/export-pdf`">PDFダウンロード</a></li>
                        <li><a :href="`/api/user/quotations/${id}/preview-pdf`" target="_blank">PDFプレビュー</a></li>
                        <!-- case：確定していない場合 -->
                        <li v-if="quotation.status==0"><a @click="toggleModalConfirm()">確定する</a></li>
                        <!-- case1：請求書が作成されていない場合 -->
                        <li><a @click="createOrUpdateInvoice">同じ内容で請求書を作成</a></li>
                        <!-- case2：請求書が作成されている場合 -->
                        <li v-if="quotation.status>0&&invoice.id>0"><a :class="invoice.id>0?'':'disabled'" :href="`/user/invoice/detail/${invoice.id}`">請求書をみる</a></li>
                        <li><a :href="`/user/quotation/edit/${id}`">編集する</a></li>
                        <li class="icon"><a @click.prevent="toggleModalTrush"><img src="/img/icon-dust-navygray.png"></a></li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a :href="`/user/quotation/edit/${id}`">
                                <img src="/img/icon-edit-hoso-black.png">
                                <span>編集</span>
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
                <ul class="l-wrap--button__list" :class="{'button-three': quotation.status==1, 'button-two': quotation.status==0}">
                    <li><a :href="`/api/user/quotations/${id}/export-pdf`">PDFダウンロード</a></li>
                    <li><a :href="`/quotations/${id}/preview-pdf`" target="_blank">PDFプレビュー</a></li>
                    <li :class="{'u-mt3': (quotation.status==0) && !invoice.id}" v-if="!invoice.id">
                        <a @click="createOrUpdateInvoice">請求書反映</a>
                    </li>
                    <li :class="{'u-mt3': (quotation.status==0) && !invoice.id}" v-if="quotation.status==0">
                        <a @click="toggleModalConfirm">確定する</a>
                    </li>
                </ul>
            </div>
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__detail__box box-left">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">見積情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>ステータス</th>
                                <td>{{ getStatus(quotation.status) }}</td>
                            </tr>
                            <tr>
                                <th>件名</th>
                                <td>{{ quotation.name }}</td>
                            </tr>
                            <tr>
                                <th>見積書番号</th>
                                <td>{{ quotation.number }}</td>
                            </tr>
                            <tr>
                                <th>お客様</th>
                                <td>{{ quotation.client ? quotation.client.name : '' }}</td>
                            </tr>
                            <tr>
                                <th>発行日</th>
                                <td>{{ quotation.publish_date }}</td>
                            </tr>
                            <tr>
                                <th>有効期限</th>
                                <td>{{ quotation.expiration_date }}</td>
                            </tr>
                            <tr>
                                <th>備考</th>
                                <td>{{ quotation.remark }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="l-wrap--body__detail__box box-right">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">見積元情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>担当者</th>
                                <td>{{ quotation.member ? quotation.member.name : '' }}</td>
                            </tr>
                            <tr>
                                <th>自社名</th>
                                <td>{{ quotation.bill_company_name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__pdf pc-only">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__pdf__panel">
                    <div class="l-wrap--body__pdf__inner">
                        <embed :src="`/api/user/quotations/${id}/preview-pdf#toolbar=0&navpanes=0&scrollbar=0&scrollbar=0`" width="100%" height="740px" type="application/pdf">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isModalTrash: false, // 削除モーダル
                isModalConfirm: false, // 確定モーダル
                quotation: {},
                invoice: {},
            }
        },
        props: ['id'],
        created: function() {
            this.loadQuotationDetail();
            // this.getPdf();
        },
        computed: {},
        methods: {
            // 削除モーダル
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },
            // 確定モーダル
            toggleModalConfirm: function() {
                this.isModalConfirm = !this.isModalConfirm
            },


            loadInvoice: function() {
                console.log(this.quotation);
                axios
                    .post('/api/user/invoices/existInvoice', {
                        work_id: this.quotation.work_id,
                    })
                    .then(res => {
                        console.log("here", res.data);
                        this.invoice = res.data[0]??{};

                    })
                    .catch(err => {
                        console.log("SendSMS: " + err);
                    })
            },

            // 見積書詳細のローディング
            loadQuotationDetail: function() {
                this.quotation = {};
                axios.get(`/api/user/quotations/${this.id}`)
                .then(
                    (response) => {
                        this.quotation = response.data.data;
                        if (this.quotation.bill_postal && this.quotation.bill_postal.length > 3) {
                            this.postal1 = this.quotation.bill_postal.substring(0, 3);
                            this.postal2 = this.quotation.bill_postal.substring(4);
                        }

                        if(this.quotation.status > 0){
                            console.log("object");
                            this.loadInvoice();
                        }
                    }
                );
            },

            

            // 見積書を削除する
            deleteQuotation: function() {
                axios.delete(`/api/user/quotations/${this.id}`)
                .then(
                    (response) => {
                        this.isModalTrash = false;
                        window.history.back();
                    }
                );
            },

            // 見積書を確定する
            confirmQuotation: function() {
                axios.put(`/api/user/quotations/${this.id}`, {
                    status: 1,
                }).then(response => {
                    console.log(response);
                    this.quotation.status = 1;
                    this.isModalConfirm = false;
                });
            },

            // 請求書を作成する
            createOrUpdateInvoice: function() {
                // axios.get(`/api/user/quotations/${this.id}/invoice`, this.quotation)
                // .then(response => {
                //     console.log(response);
                //     this.quotation.status = 1;
                    window.location.href = `/user/invoice/register/${this.id}`;
                    // this.isModalConfirm = false;
                // });
            },

            //
            getPdf: function() {
                axios.get(`/api/user/quotations/${this.id}/export-pdf`)
                .then(response => {
                    console.log(response.data);
                });
            },

            //
            getStatus: function(v) {
                if (v == 0) {
                    return "未受注";
                } else if (v == 1) {
                    return '受注済み';
                }
            }
        },
        watch: {},
    }
</script>

<style lang="css">
    a.disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.5;
    }
</style>