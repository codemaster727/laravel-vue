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
                            <li><a @click="deleteInvoice">はい</a></li>
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
                <h1 class="l-wrap--header__title">請求書詳細</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li><a :href="`/api/user/invoices/${this.id}/export-pdf`">PDFダウンロード</a></li>
                        <li><a :href="`/api/user/invoices/${this.id}/preview-pdf`" target="_blank">PDFプレビュー</a></li>
                        <li><a :href="`/user/quotation/detail/${invoice.quotation_id}`">見積書をみる</a></li>
                        <li><a :href="`/user/invoice/edit/${this.id}`">編集する</a></li>
                        <li class="icon"><a @click.prevent="toggleModalTrush"><img src="/img/icon-dust-navygray.png"></a></li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a :href="`/user/invoice/edit/${this.id}`">
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
                <ul class="l-wrap--button__list" :class="{'button-three': invoice.quotation_id, 'button-two': !invoice.quotation_id}">
                    <li><a :href="`/api/user/invoices/${this.id}/export-pdf`">PDFダウンロード</a></li>
                    <li><a :href="`/api/user/invoices/${this.id}/preview-pdf`" target="_blank">PDFプレビュー</a></li>
                    <li v-if="invoice.quotation_id"><a :href="`/api/user/invoices/${invoice.quotation_id}/preview-pdf`" target="_blank">見積書を見る</a></li>
                </ul>
            </div>
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__detail__box box-left">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">請求情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>件名</th>
                                <td>{{ invoice.name }}</td>
                            </tr>
                            <tr>
                                <th>請求書番号</th>
                                <td>{{ invoice.invoice_number }}</td>
                            </tr>
                            <tr>
                                <th>お客様</th>
                                <td>{{ invoice.client.name }}</td>
                            </tr>
                            <tr>
                                <th>発行日</th>
                                <td>{{ invoice.publish_date }}</td>
                            </tr>
                            <tr>
                                <th>支払期限</th>
                                <td>{{ invoice.limit_date }}</td>
                            </tr>
                            <tr>
                                <th>備考</th>
                                <td>{{ invoice.remark }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="l-wrap--body__detail__box box-right">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">請求元情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>担当者</th>
                                <td>{{ invoice.member.name }}</td>
                            </tr>
                            <tr>
                                <th>自社名</th>
                                <td>{{ invoice.bill_company_name }}</td>
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
                        <embed :src="`/api/user/invoices/${id}/preview-pdf#toolbar=0&navpanes=0&scrollbar=0&scrollbar=0`" width="100%" height="740px" type="application/pdf">
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
                invoice: {},
            }
        },
        props: ['id'],
        created: function() {
            this.loadInvoiceDetail();
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

            // 請求書詳細のローディング
            loadInvoiceDetail: function() {
                this.invoice = {client: [], member: []};
                console.log("here", this.id);
                axios.get(`/api/user/invoices/${this.id}`)
                .then(
                    (response) => {
                        console.log(response.data);
                        this.invoice = response.data.data;
                        console.log(this.invoice);
                    }
                );
            },

            // 請求書を削除する
            deleteInvoice: function() {
                axios.delete(`/api/user/invoices/${this.id}`)
                .then(
                    (response) => {
                        this.isModalTrash = false;
                        window.history.back();
                    }
                );
            },
        },
        watch: {},
    }
</script>
