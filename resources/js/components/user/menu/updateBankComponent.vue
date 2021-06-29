<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasUndefined">
            <p
                v-for="(error, index) in errors"
                :key="index"
            >
                {{ error }}
            </p>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>エラーが発生しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>銀行変更が成功されました。</p>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="/user/bank/">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">銀行口座を編集</h1>
            </div>
        </div>
        <div class="l-wrap--button">
            <ul class="l-wrap--button__list button-two select-tab l-flex l-center_pc">
                <li :class="{'selected': panelActive === '1'}">
                    <a @click.prevent="changePanel('1')">ゆうちょ銀行</a>
                </li>
                <li :class="{'selected': panelActive === '2'}">
                    <a @click.prevent="changePanel('2')">その他</a>
                </li>
            </ul>
        </div>
        <div
            class="l-wrap--body l-wrap--body__input"
            v-if="panelActive === '1'"
        >
            <div class="l-wrap--body__input__confirm c-checkbox--confirm">
                <label class="l-select__wrap l-flex l-start">
                    <div class="l-select__area">
                        <div class="c-checkbox--select">
                            <input
                                type="checkbox"
                                v-model="isJapanMain"
                            >
                            <div class="c-checkbox--color"></div>
                        </div>
                    </div>
                    メインバンクにする
                </label>
            </div>
            <div class="l-wrap--body__inner">

                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>口座記号</label>
                            <input
                                type="number"
                                v-model="japanBank.mark"
                                placeholder="12345"
                                required
                            >
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座番号</label>
                            <input
                                class="c-input--white"
                                type="number"
                                v-model="japanBank.number"
                                placeholder="12345678"
                                required
                            >
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座名義人</label>
                            <input
                                class="c-input--white"
                                type="text"
                                v-model="japanBank.name"
                                placeholder="ユウチョギンコウ"
                                required
                            >
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit">
                <button
                    @click.prevent.stop="editJapanBank"
                    type="button"
                    class="c-button--yellowRounded"
                >
                    変更内容を保存する
                </button>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input" v-if="panelActive === '2'">
            <div class="l-wrap--body__input__confirm c-checkbox--confirm">
                <label class="l-select__wrap l-flex l-start">
                    <div class="l-select__area">
                        <div class="c-checkbox--select">
                            <input type="checkbox" name="" v-model="isOtherMain">
                            <div class="c-checkbox--color"></div>
                        </div>
                    </div>
                    メインバンクにする
                </label>
            </div>
            <div class="l-wrap--body__inner">

                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>金融機関名</label>
                            <input
                                type="text"
                                v-model="otherBank.financial_name"
                                placeholder="金融機関名"
                                required
                            >
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>支店名</label>
                            <input
                                class="text"
                                type="text"
                                v-model="otherBank.branch_name"
                                placeholder="支店名"
                                required
                            >
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>支店番号</label>
                            <input
                                class="text"
                                type="number"
                                v-model="otherBank.branch_number" placeholder="000 "
                                required
                            >
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座種別</label>
                            <div class="c-select--triangle">
                                <select v-model="otherBank.type" required>
                                    <option value="0">普通</option>
                                    <option value="1">当座</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座番号</label>
                            <input
                                class="c-input--white"
                                type="number"
                                v-model="otherBank.number"
                                placeholder="1234567"
                                required
                            >
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座名義人</label>
                            <input
                                class="c-input--white"
                                type="text"
                                v-model="otherBank.name"
                                placeholder="コウザメイギニン"
                                required
                            >
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit">
                <button
                    @click.prevent.stop="editOtherBank"
                    type="button"
                    class="c-button--yellowRounded"
                >
                    更内容を保存する
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    var numeral = require('numeral');

    Vue.filter("formatNumber", function (value) {
        return numeral(value).format("0,0");
    });

	export default {
        props: {
            bankId: {
                type: Number,
                required: true
            },
            user: {
                type: Object,
                required: true
            },
        },
		data() {
			return {
                panelActive: '',
                isJapanMain: false,
                isOtherMain: false,
                japanBank: {
                    id: 0,
                    mark: '',
                    number: '',
                    name: '',
                },
                otherBank: {
                    id: 0,
                    financial_name: '',
                    branch_name: '',
                    branch_number: '',
                    type: 0,
                    number: '',
                    name: '',
                },
                // バリデーション周り
                hasError: false,
                hasSuccess: false,
                hasUndefined: false,
                errors: [],
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadBank();
		},
		computed: {},
		methods: {
            changePanel: function(panel) {
                this.panelActive = panel;
            },
            loadBank: function() {
                this.hasError = false;
                axios.get(`/api/user/banks/${this.bankId}`)
                    .then(result => {
                        this.data = result.data;
                        // 取得した銀行情報に応じて値をセット
                        if(this.data.type === 'japan') {
                            // 銀行情報をセット
                            this.panelActive                = '1'
                            this.japanBank.id               = this.bankId
                            this.japanBank.mark             = result.data.mark
                            this.japanBank.number           = result.data.number
                            this.japanBank.name             = result.data.name

                            // メインバンクの有無
                            if(this.user.bank_id == this.japanBank.id) {
                                this.isJapanMain = true
                            }
                        } else {
                            // その他情報をセット
                            this.panelActive                = '2'
                            this.otherBank.id               = this.bankId
                            this.otherBank.financial_name   = result.data.financial_name
                            this.otherBank.branch_name      = result.data.branch_name
                            this.otherBank.branch_number    = result.data.branch_number
                            this.otherBank.type             = result.data.other_type
                            this.otherBank.number           = result.data.number
                            this.otherBank.name             = result.data.name

                            // メインバンクの有無
                            if(this.user.bank_id == this.otherBank.id) {
                                this.isOtherMain = true
                            }
                        }
                    })
                    .catch(error => {
                        this.hasError = true;
                        console.log('err', error);
                    });
		        // if (this.edit_bank_type == 0) {
                //     // japan bank
                //     axios.get('/api/user/japan-banks/' + this.edit_bank_id)
                //         .then(result => {
                //             let data = result.data.data;
                //             if (data) {
                //                 this.japanBank = data;
                //                 this.isJapanMain = (this.edit_bank_type == this.user_bank_type && this.japanBank.id == this.user_bank_id);
                //             }
                //         })
                //         .catch(error => {
                //             this.hasError = true;
                //             console.log('err', error);
                //         });
                // }
		        // else if (this.edit_bank_type == 1) {
		        //     // other bank
                //     axios.get('/api/user/other-banks/' + this.edit_bank_id)
                //         .then(result => {
                //             let data = result.data.data;
                //             if (data) {
                //                 this.otherBank = data;
                //                 this.isOtherMain = (this.edit_bank_type == this.user_bank_type && this.otherBank.id == this.user_bank_id);
                //             }
                //         })
                //         .catch(error => {
                //             this.hasError = true;
                //             console.log('err', error);
                //         });
                // }
            },
            // ゆうちょ銀行情報を登録
            editJapanBank: function() {
                this.hasError = false
                this.hasSuccess = false
                this.hasUndefined = false
                this.errors = []

                // バリデーションチェック
                if (!this.japanBank.mark || !this.japanBank.number || !this.japanBank.name) {
                    if (!this.japanBank.mark) {
                        this.errors.push('口座記号が未入力です。');
                    }
                    if (!this.japanBank.number) {
                        this.errors.push('口座番号が未入力です。');
                    }
                    if (!this.japanBank.name) {
                        this.errors.push('口座名義人が未入力です。');
                    }
                    this.hasUndefined = true
                } else {
                    // パラメーターに設置
                    let params = {
                        status : 'japan',
                        main   : this.isJapanMain,
                        mark   : this.japanBank.mark,
                        number : this.japanBank.number,
                        name   : this.japanBank.name,
                    };
                    axios.put('/api/user/banks/' + this.bankId, params)
                        .then(result => {
                            this.hasSuccess = true;
                            console.log(result)
                        })
                        .catch(error => {
                            this.hasError = true;
                            console.log('err', error);
                        });
                }
            },
            // その他銀行情報を登録
            editOtherBank: function() {
                this.hasError = false;
                this.hasSuccess = false;
                let params = {
                    status         : 'other',
                    main           : this.isOtherMain,
                    financial_name : this.otherBank.financial_name,
                    branch_name    : this.otherBank.branch_name,
                    branch_number  : this.otherBank.branch_number,
                    type           : this.otherBank.type,
                    number         : this.otherBank.number,
                    name           : this.otherBank.name,
                };
                axios.put('/api/user/banks/' + this.bankId, params)
                    .then(result => {
                        this.hasSuccess = true;
                        console.log(result)
                    })
                    .catch(error => {
                        this.hasError = true;
                        console.log('err', error);
                    });
            }
        },
		watch: {},
	}
</script>
