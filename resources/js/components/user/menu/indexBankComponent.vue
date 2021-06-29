<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>エラーが発生しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasUpdatedBank">
            <p>メイン銀行が変更されました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasDeleted">
            <p>銀行が削除されました。</p>
        </div>

        <!-- 銀行口座編集 -->
        <div class="l-modal" :class="{'open': isBankEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleBankEdit">
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a @click="setMainBank">メインにする</a></div>
                    <div class="l-modak__list"><a :href="`/user/bank/edit/${selectedBankId}`">編集する</a></div>
                    <div class="l-modak__list"><a @click="deleteBank">削除する</a></div>
                </div>
            </div>
        </div>
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">銀行口座一覧</h1>
                <div class="l-wrap--header__inner__sub">
                    <!-- <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a href="">
                                <img src="/public/img/icon-chart-black.png">
                                <span>工程表</span>
                            </a>
                        </li>
                    </ul> -->
                </div>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__button">
                        <a class="c-button--addGreen" href="/user/bank-register">口座を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w100_pc"></div>
                                <div class="l-wrap--body__table__th u-w300_pc">銀行名</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">口座番号</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(bank, index) in banks">
                            <div class="l-wrap--body__table__tr">
                                <a class="c-link--edit" @click="toggleBankEdit(bank.type, bank.id)">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__td u-w100_pc u-w100per_sp">
                                            <span class="c-text--mark" v-if="isSelected(index)">メイン</span>
                                        </div>

                                        <div class="l-wrap--body__table__td u-w300_pc u-w100per_sp c-text--main_sp">{{ bank.type }}</div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">
                                            <span class="sp-only">末尾：</span>{{ bank.number }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
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
            bank_id: {
                type: String,
                required: false,
                default: null
            },
        },
		data() {
			return {
                panelActive: '1',
                selectedBankType: 0,
                selectdBankId: 0,
                banks: [],
                hasError: false,
                hasUpdatedBank: false,
                hasDeleted: false,
                // モーダル用
                isBankEdit: false,
                selectedBankType: '',
                selectedBankId: '',
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadBanks();
		},
		computed: {},
		methods: {
            changePanel: function(panel) {
                this.panelActive = panel;
            },
            toggleBankEdit: function(type, id) {
                this.selectedBankType = type;
                this.selectedBankId = id;
                console.log(this.selectedBankId);
                this.isBankEdit = !this.isBankEdit;
            },
            isSelected: function(index) {
                return (this.banks[index].id == this.bank_id);
            },
            loadBanks: async function() {
                this.hasError = false;
                await axios.get('/api/user/banks/')
                    .then(result => {
                        this.banks = result.data;
                        console.log(this.banks)
                        this.banks.forEach(element => {
                            if(element.type === 'japan') {
                                element.type = 'ゆうちょ銀行'
                            } else {
                                element.type = element.other_name
                            }
                        });
                    })
                    .catch(error => {
                        this.hasError = true;
                        console.log('err', error);
                    });
                // await axios.get('/api/user/japan-banks')
                //     .then(result => {
                //         let datas = result.data.data;
                //         this.banks.splice(0);
                //         if (datas) {
                //             for (let i = 0; i < datas.length; i ++) {
                //                 let data = datas[i];
                //                 this.banks.push({
                //                     id: data.id,
                //                     type: 0, // japan-bank
                //                     name: data.name,
                //                     number: data.number,
                //                     date: data.created_at.substr(0, 10),
                //                 })
                //             }
                //         }
                //     })
                //     .catch(error => {
                //         this.hasError = true;
                //         console.log('err', error);
                //     });
            },
            setMainBank: function() {
                this.hasError = false;
                this.hasUpdatedBank = false;
                let params = {
                    status: 'main',
                    bank_id: this.selectedBankId,
                }
                axios.put(`/api/user/banks/${this.selectedBankId}`, params)
                    .then(result => {
                        if (result.data == 0) {
                            this.hasUpdatedBank = true;
                            this.isBankEdit = false;
                            this.bank_id = this.selectedBankId;
                        }
                        else {
                            this.hasError = true;
                        }
                    })
                    .catch(error => {
                        this.hasError = true;
                        console.log('err', error);
                    });
            },
            deleteBank: function(index) {
                this.hasError = false;
                this.hasDeleted = false;
                axios.delete(`/api/user/banks/${this.selectedBankId}`)
                    .then(result => {
                        this.isBankEdit = false;
                        this.hasDeleted = true;
                        this.loadBanks();
                    })
                    .catch(error => {
                        this.hasError = true;
                        console.log('err', error);
                    });
                // if (this.selectedBankType == 0) {
                //     axios.delete(`/api/user/banks/${this.selectedBankId}`)
                //         .then(result => {
                //             this.isBankEdit = false;
                //             this.hasDeleted = true;
                //             this.loadBanks();
                //         })
                //         .catch(error => {
                //             this.hasError = true;
                //             console.log('err', error);
                //         });
                // }
                // else {
                //     // other-bank
                //     axios.delete('/api/user/other-banks/' + this.selectedBankId)
                //         .then(result => {
                //             this.isBankEdit = false;
                //             this.hasDeleted = true;
                //             this.loadBanks();
                //         })
                //         .catch(error => {
                //             this.hasError = true;
                //             console.log('err', error);
                //         });
                // }
            }
        },
		watch: {},
	}
</script>
