<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>エラーが発生しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>銀行追加に成功されました。</p>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">銀行口座を追加する</h1>
            </div>
        </div>
        <div class="l-wrap--button">
            <ul class="l-wrap--button__list button-two select-tab l-flex l-center_pc">
                <li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">ゆうちょ銀行</a></li>
                <li :class="{'selected': panelActive === '2'}"><a @click.prevent="changePanel('2')">その他</a></li>
            </ul>
        </div>
        <div class="l-wrap--body l-wrap--body__input" v-if="panelActive === '1'">
            <div class="l-wrap--body__input__confirm c-checkbox--confirm">
                <label class="l-select__wrap l-flex l-start">
                    <div class="l-select__area">
                        <div class="c-checkbox--select">
                            <input type="checkbox" name="" v-model="isMain">
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
                            <input :class="{'is-invalid': this.errorJapanMsg.mark != ''}" type="" name="" v-model="mark" placeholder="12345">
                            <span class="invalid-feedback">{{ errorJapanMsg.mark }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座番号</label>
                            <input :class="{'is-invalid': this.errorJapanMsg.number != ''}" class="c-input--white" type="text" name="" v-model="number" placeholder="12345678">
                            <span class="invalid-feedback">{{ errorJapanMsg.number }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座名義人</label>
                            <input :class="{'is-invalid': this.errorJapanMsg.name != ''}" class="c-input--white" type="text" name="" v-model="name" placeholder="ユウチョギンコウ">
                            <span class="invalid-feedback">{{ errorJapanMsg.name }}</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit" @click.prevent.stop="registerJapanBank">
                <input class="c-button--yellowRounded" type="submit" name="" value="追加する">
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input" v-if="panelActive === '2'">
            <div class="l-wrap--body__input__confirm c-checkbox--confirm">
                <label class="l-select__wrap l-flex l-start">
                    <div class="l-select__area">
                        <div class="c-checkbox--select">
                            <input type="checkbox" name="" v-model="isMain">
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
                            <input :class="{'is-invalid': this.errorOtherMsg.financial_name != ''}" type="" name="" v-model="financial_name" placeholder="金融機関名">
                            <span class="invalid-feedback">{{ errorOtherMsg.financial_name }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>支店名</label>
                            <input :class="{'is-invalid': this.errorOtherMsg.branch_name != ''}" class="" type="text" name="" v-model="branch_name" placeholder="支店名">
                            <span class="invalid-feedback">{{ errorOtherMsg.branch_name }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>支店番号</label>
                            <input :class="{'is-invalid': this.errorOtherMsg.financial_number != ''}" class="" type="text" name="" v-model="branch_number" placeholder="支店名">
                            <span class="invalid-feedback">{{ errorOtherMsg.branch_number }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座種別</label>
                            <div class="c-select--triangle">
                                <select :class="{'is-invalid': this.errorOtherMsg.type != ''}" v-model="type">
                                    <option value="0">普通</option>
                                    <option value="1">当座</option>
                                    <option value="2">定期</option>
                                </select>
                            </div>
                            <span class="invalid-feedback">{{ errorOtherMsg.type }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座番号</label>
                            <input :class="{'is-invalid': this.errorOtherMsg.number != ''}" class="" type="text" name="" v-model="number1" placeholder="口座番号">
                            <span class="invalid-feedback">{{ errorOtherMsg.number }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>口座名義人</label>
                            <input :class="{'is-invalid': this.errorOtherMsg.name != ''}" class="c-input--white" type="text" name="" v-model="name1" placeholder="コウザメイギニン">
                            <span class="invalid-feedback">{{ errorOtherMsg.name }}</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit" @click.prevent.stop="registerOtherBank">
                <input class="c-button--yellowRounded" type="submit" name="" value="追加する">
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
		data() {
			return {
                panelActive: '1',
                isMain: false,
                mark: '',
                number: '',
                name: '',
                financial_name: '',
                branch_name: '',
                branch_number: '',
                type: 0,
                number1: '',
                name1: '',
                hasError: false,
                hasSuccess: false,
                errorJapanMsg: {
                    mark: '',
                    number: '',
                    name: '',
                },
                errorOtherMsg: {
                    financial_name: '',
                    branch_name: '',
                    branch_number: '',
                    type: '',
                    number: '',
                    name: '',
                }
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
		},
		computed: {},
		methods: {
		    changePanel: function(panel) {
		        this.panelActive = panel;
            },
            registerJapanBank: function() {
		        this.hasError = false;
		        this.hasSuccess = false;
                let params = {
                    main: this.isMain,
                    mark: this.mark,
                    number: this.number,
                    name: this.name,
                }
                axios.post('/api/user/japan-banks', params)
                    .then(result => {
                        this.hasSuccess = true;
                        this.errorJapanMsg = {
                            mark: '',
                            number: '',
                            name: '',
                        }
                        setTimeout(function() {
                            location.href = '/user/bank';
                        }, 1000)
                    })
                    .catch(error => {
                        this.hasError = true;
                        let errorMsg = error.response.data.errors.original;
                        if (errorMsg) {
                            if (errorMsg.mark) {
                                this.errorJapanMsg.mark = errorMsg.mark[0];
                            }
                            if (errorMsg.number) {
                                this.errorJapanMsg.number = errorMsg.number[0];
                            }
                            if (errorMsg.name) {
                                this.errorJapanMsg.name = errorMsg.name[0];
                            }
                        }
                    });
            },
            registerOtherBank: function() {
                this.hasError = false;
                this.hasSuccess = false;
                let params = {
                    main: this.isMain,
                    financial_name: this.financial_name,
                    branch_name: this.branch_name,
                    branch_number: this.branch_number,
                    type: this.type,
                    number: this.number1,
                    name: this.name1,
                }
                axios.post('/api/user/other-banks', params)
                    .then(result => {
                        this.hasSuccess = true;
                        this.errorOtherMsg = {
                            financial_name: '',
                            branch_name: '',
                            branch_number: '',
                            type: '',
                            number: '',
                            name: '',
                        };
                        setTimeout(function() {
                            location.href = '/user/bank';
                        }, 1000)
                    })
                    .catch(error => {
                        this.hasError = true;
                        let errorMsg = error.response.data.errors.original;
                        if (errorMsg) {
                            if (errorMsg.financial_name) {
                                this.errorOtherMsg.financial_name = errorMsg.financial_name[0];
                            }
                            if (errorMsg.branch_name) {
                                this.errorOtherMsg.branch_name = errorMsg.branch_name[0];
                            }
                            if (errorMsg.branch_number) {
                                this.errorOtherMsg.branch_number = errorMsg.branch_number[0];
                            }
                            if (errorMsg.type) {
                                this.errorOtherMsg.type = errorMsg.type[0];
                            }
                            if (errorMsg.number) {
                                this.errorOtherMsg.number = errorMsg.number[0];
                            }
                            if (errorMsg.name) {
                                this.errorOtherMsg.name = errorMsg.name[0];
                            }
                        }
                    });
            }
        },
		watch: {},
	}
</script>
