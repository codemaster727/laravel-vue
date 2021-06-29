<template>
    <div class="l-wrap--inner">
        <!-- modal：見積書項目追加 -->
        <div class="l-modal" :class="{'open': isModalQuotationItemAdd}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleQuotationItemAdd">
                <div class="l-modal--area__input">
                    <div class="l-modal--area__input__box">
                        <label>品番・品名</label>
                        <input type="text" name="" v-model="itemName">
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>数量</label>
                        <input @input="validateQuantity" v-model="itemNumber"> <!-- 数字のみのバリデーション -->
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>単位</label>
                        <input type="text" name="" v-model="itemUnit">
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>単価</label>
                        <input @input="validatePrice" v-model="itemPrice">
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>金額</label>
                        <span>{{ itemSum }}</span>
                    </div>
                    <div class="l-modal--area__input__submit l-button--submit">
                        <input class="c-button--yellowRounded" type="submit" name="" value="登録する" :disabled="!form_all" :class="{'notSubmit':!form_all}" @click="addItem">
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal：見積書項目追加 -->

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">見積書作成</h1>
            </div>
        </div>

        <div class="l-wrap--body l-wrap--body__detail l-wrap--body__table">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__detail__box box-left table-input">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">現場情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>件名</th>
                                <td>
                                    <div class="c-select--triangle">
                                        <select class="c-input--white" v-model="quotation.work_id">
                                            <option v-for="work in works" v-bind:key="work.id" v-bind:value="work.id">{{ work.name }}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>見積書番号</th>
                                <td><input type="" name="" v-model="quotation.number"></td>
                            </tr>
                            <tr>
                                <th>お客様</th>
                                <td>
                                    <div class="c-select--triangle">
                                        <select class="c-input--white" v-model="quotation.client_id">
                                            <option v-for="client in clients" v-bind:key="client.id" v-bind:value="client.id">{{ client.name }}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <div class="l-flex">
                                        <div class="u-w49per c-input__supplement__box">
                                            <span class="u-color--grayNavy u-mb5 u-textSize--small">発行日</span>
                                            <vuejs-datepicker
                                                v-model="quotation.publish_date"
                                                :language="ja"
                                                :format="DatePickerFormat"
                                                calendar-class="c-bgColor--white"
                                                required=""
                                            >
                                            </vuejs-datepicker>
                                        </div>
                                        <div class="u-w49per c-input__supplement__box vue-right">
                                            <span class="u-color--grayNavy u-mb5 u-textSize--small">有効期限</span>
                                            <vuejs-datepicker
                                                v-model="quotation.expiration_date"
                                                :language="ja"
                                                :format="DatePickerFormat"
                                                calendar-class="c-bgColor--white"
                                                required=""
                                            >
                                            </vuejs-datepicker>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="l-wrap--body__detail__box box-right table-input">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">見積元情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>担当者</th>
                                <td>
                                    <div class="c-select--triangle">
                                        <select class="c-input--white" v-model="quotation.member_id">
                                            <option v-for="member in members" v-bind:key="member.id" v-bind:value="member.id">{{ member.name }}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>自社名</th>
                                <td>
                                    <span class="u-mb5 u-display--block"><input type="" name="" v-model="quotation.bill_company_name"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table" v-if="isInvoiceActive">
                            <tr>
                                <th class="u-w120_pc">郵便番号</th>
                                <td>
                                    <input type="" name="" class="c-input--post__one" v-model="postal1" maxlength="3">
                                    <input type="" name="" class="c-input--post__two" v-model="postal2" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td><input type="" v-model="quotation.bill_address"></td>
                            </tr>
                            <tr>
                                <th>TEL</th>
                                <td><input type="" v-model="quotation.bill_tel"></td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td><input type="" v-model="quotation.bill_email"></td>
                            </tr>
                        </table>
                        <a @click.prevent="toggleInvoiceActive" class="open-detail u-mt10">
                            <span v-if="!isInvoiceActive">詳細（住所、連絡先など）を変更する</span>
                            <span v-else>詳細を閉じる</span>
                        </a>
                    </div>
                </div>
                <div class="l-wrap--body__detail__box l-wrap--body__detail__invoice">
                    <!-- SP start -->
                    <div class="l-wrap--body__detail__invoice__box sp-only">
                        <div class="l-wrap--body__table__area">
                            <div class="l-wrap--body__table__tbody">
                                <div class="l-wrap--body__table__tr" v-for="(quotationItem, index) in quotation.quotation_items" v-bind:key="quotationItem.id">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__td u-w30_sp">
                                            <div class="u-w24_sp">
                                                <img src="/img/icon-minus.png" @click="deleteItem(index)">
                                            </div>
                                        </div>
                                        <div class="l-wrap--body__table__tr__inner u-wflex1_sp">
                                            <div class="l-wrap--body__table__td">
                                                <div class="l-wrap--body__table__td u-mb10">{{ quotationItem.name }}</div>
                                                <div class="l-wrap--body__table__td c-text--sub_sp u-mb0">{{ quotationItem.price }}円 × {{ quotationItem.quantity }}個 ＝ {{ quotationItem.total }}円(税抜)</div>
                                            </div>
                                        </div>
                                        <div class="l-wrap--body__table__td u-w40_sp">
                                            <div class="l-order__area">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="l-wrap--body__table__tr">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__td u-w100per_sp">
                                            <a class="c-button--addGreen" @click.self="toggleQuotationItemAdd">品目を追加する</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fin SP -->
                    <div class="l-wrap--body__detail__invoice__box">

                        <!-- PC start -->
                        <table class="field-invoice pc-only">
                            <thead>
                                <tr>
                                    <th class="u-w40 u-border--none" style="background: #fff"></th>
                                    <th class="u-w360">品番・品名</th>
                                    <th class="u-w120">数量</th>
                                    <th class="u-w100">単位</th>
                                    <th class="u-w140">単価</th>
                                    <th class="u-wflex1">金額</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(quotationItem, index) in quotation.quotation_items" :key="index">
                                    <th class="u-w40 u-border--none" v-if="!quotationItem.deleted_at">
                                        <span>
                                            <img src="/img/icon-minus.png" @click="deleteItem(index)">
                                        </span>
                                    </th>
                                    <td class="u-w320" v-if="!quotationItem.deleted_at">
                                        <input type="" name="" v-model="quotationItem.name">
                                    </td>
                                    <td class="u-w120" v-if="!quotationItem.deleted_at">
                                        <input type="" name="" v-model="quotationItem.quantity">
                                    </td>
                                    <td class="u-w100" v-if="!quotationItem.deleted_at">
                                        <input type="" name="" v-model="quotationItem.unit">
                                    </td>
                                    <td class="u-w140" v-if="!quotationItem.deleted_at">
                                        <input type="" name="" v-model="quotationItem.price">
                                    </td>
                                    <td class="u-wflex1" v-if="!quotationItem.deleted_at">
                                        <span class="total">{{ quotationItem.quantity * quotationItem.price }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="u-border--none" style="vertical-align: middle;">
                                        <span class="c-button--attention" @click="toggleQuotationItemAdd">＋行を追加する</span>
                                    </td>
                                    <td colspan="3" class="u-text--center" style="vertical-align: middle;">小計</td>
                                    <td><span class="total">{{ preTaxTotal }}円</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="u-border--none"></td>
                                    <td colspan="3" class="u-text--center" style="vertical-align: middle;">消費税（10%）</td>
                                    <td><span class="total">{{ tax }}円</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="u-border--none"></td>
                                    <td colspan="3" class="u-text--center" style="vertical-align: middle;">合計</td>
                                    <td><span class="total">{{ total }}円</span></td>
                                </tr>
                            </tbody>
                        </table>
                         <!-- fin PC -->
                        <div class="field-remark">
                            <p>備考 <span>（最大1000文字、20行以内）</span></p>
                            <div class="field-remark__inner">
                                <textarea v-model="quotation.remark"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-trackingFooter">
            <div class="l-trackingFooter__inner">
                <div class="l-trackingFooter__box l-trackingFooter__simutale">
                    <table>
                        <tr>
                            <td class="u-pr10 u-pb5">小計</td>
                            <td class="u-pb5">{{ preTaxTotal }}円</td>
                        </tr>
                        <tr>
                            <td class="u-pr10">消費税</td>
                            <td>{{ tax }}円</td>
                        </tr>
                    </table>
                </div>
                <div class="l-trackingFooter__box l-trackingFooter__total">
                    <table>
                        <tr>
                            <th class="u-pr10">合計</th>
                            <th>{{ total }}円</th>
                        </tr>
                    </table>
                </div>
                <div class="l-trackingFooter__box">
                    <div class="l-button--submit">
                        <input type="submit" name="" value="見積書を作成" class="c-button--yellowRounded"
                            :disabled="!proccess_all" :class="{'notSubmit':!proccess_all}" @click="storeQuotation">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import vuejsDatepicker from 'vuejs-datepicker'
    import {ja} from 'vuejs-datepicker/dist/locale' // 日本語化

    export default {
        components: {
            'vuejs-datepicker':vuejsDatepicker,
        },
        data() {
            return {
                ja: vdp_translation_ja.js, // カレンダー日本語化
                DatePickerFormat: 'yyyy年MM月dd日', // カレンダーの表示形式
                isInvoiceActive: false, // 詳細情報
                isModalQuotationItemAdd: false, // 項目追加モーダル
                itemName: '', // 品番
                itemUnit: '', // 単位
                itemNumber: 0, // 数量
                itemPrice: 0, // 合計
                quotation: {quotation_items: []},
                members: [],
                clients: [],
                works: [],
                postal1: '',
                postal2: '',
            }
        },
        created: function() {
            this.quotation = {quotation_items: []};
            this.loadMembers();
            this.loadClients();
            this.loadWorks();
        },
        computed: {
            form_all: function() {
                let required_fields = [
                    this.itemName,
                    this.itemNumber,
                    this.itemUnit,
                    this.itemPrice,
                ]
                return required_fields.indexOf('') === -1
            },
            proccess_all: function() {
                let required_fields = [
                    this.quotation.work_id,
                    this.quotation.number,
                    this.formatDate(this.quotation.publish_date),
                    this.formatDate(this.quotation.expiration_date),
                    this.quotation.remark,
                    this.quotation.memo,
                    this.quotation.status,
                    this.quotation.client_id,
                    this.quotation.member_id,
                ]
                return (required_fields.indexOf('') === -1) && this.quotation.quotation_items && (this.quotation.quotation_items.length > 0)
            },
            // 合計を自動計算
            itemSum: function() {
                return this.itemNumber * this.itemPrice
            },
            preTaxTotal: function() {
                if (!this.quotation.quotation_items) {
                    return 0;
                }
                let total = 0;

                this.quotation.quotation_items.forEach(item=> {
                    if (!item.deleted_at) total += item.price * item.quantity;
                });

                return total;
            },
            tax: function() {
                return this.preTaxTotal * 0.1;
            },
            total: function() {
                return this.preTaxTotal + this.tax;
            },
        },
        methods: {
            // 担当者リストのローディング
            loadMembers: function() {
                this.members = [];
                axios.get('/api/user/members/')
                .then(response => {
                    this.members = response.data.data;
                    console.log(this.members);
                });
            },

            // お客様リストのローディング
            loadClients: function() {
                this.clients = [];
                axios.get('/api/clients/')
                .then(response => {
                    this.clients = response.data.data;
                    console.log(this.clients);
                });
            },

            // ワークリストのローディング
            loadWorks: function() {
                this.works = [];
                axios.get('/api/works/')
                .then(response => {
                    this.works = response.data.data;
                    console.log(this.works);
                });
            },

            // 詳細情報
            toggleInvoiceActive: function() {
                this.isInvoiceActive = !this.isInvoiceActive;
            },
            // 項目追加
            toggleQuotationItemAdd: function() {
                this.isModalQuotationItemAdd = !this.isModalQuotationItemAdd;
            },

            // バリデーション：半角数字のみ＋先頭の数字を0以外にする
            validateQuantity: function() {
                if (this.itemQuantity) this.itemQuantity = parseInt(this.itemQuantity.replace(/\D/g, ''), 10)
            },
            validatePrice: function() {
                if (this.itemPrice) this.itemPrice = parseInt(this.itemPrice.replace(/\D/g, ''), 10)
            },

            // 品目追加
            addItem: function() {
                this.quotation.quotation_items.push({
                    name: this.itemName, price: this.itemPrice, quantity: this.itemNumber, unit: this.itemUnit,
                });
                this.isModalQuotationItemAdd = false;
                this.itemName = '';
                this.itemPrice = 0;
                this.itemNumber = 0;
                this.itemUnit = '';
            },

            // 品目削除
            deleteItem: function(index) {
                if (this.quotation.quotation_items.length > 1) {
                    this.quotation.quotation_items[index].deleted_at = this.formatDate(new Date());
                }
            },

            // 見積書作成
            storeQuotation: function() {
                axios.post(`/api/user/quotations`, this.quotation)
                .then(response => {
                    window.history.back();
                }).catch(error => {
                    console.log("Edit: " + error);
                });
            },

            formatDate: function(date) {
                if (!date) return '';

                if (typeof(date) == 'String') return date.substring(0, 10);

                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            },
        },
        watch: {
            quotation: function(v) {
                this.quotation.total = this.total;
                this.works.forEach(v => {
                    if (v.work_id == this.quotation.work_id) {
                        this.quotation.name = v.name;
                    }
                });
                this.members.forEach(v => {
                    if (v.id == this.quotation.member_id) {
                        this.quotation.bill_company_name = v.user.company;
                        this.quotation.bill_postal = v.user.postal;
                        this.quotation.bill_email = v.user.email;
                        this.quotation.bill_tel = v.user.tel;
                        this.quotation.bill_address = v.user.address;

                        if (this.quotation.bill_postal && this.quotation.bill_postal.length > 3) {
                            this.postal1 = this.quotation.bill_postal.substring(0, 3);
                            this.postal2 = this.quotation.bill_postal.substring(4);
                        }
                    }
                });
                this.quotation.publish_date = this.formatDate(this.quotation.publish_date);
                this.quotation.expiration_date = this.formatDate(this.quotation.expiration_date);
            },

            total: function(v) {
                this.quotation.total = v;
            },

            postal1: function (val) {
                this.quotation.bill_postal = val + this.postal2
            },

            postal2: function (val) {
                this.quotation.bill_postal = this.postal1 + val
            }
        },
    }
</script>
