<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>エラーが発生しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>撮影工程名マスターの追加が成功されました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasDeleted">
            <p>撮影工程名マスターの削除が成功されました。</p>
        </div>

        <div class="l-modal" :class="{'open': isItemEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleItemEdit">
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a @click="deleteItem">削除する</a></div>
                </div>
            </div>
        </div>

        <div class="l-wrap--inner">
            <div class="l-wrap--header">
                <div class="l-wrap--header__inner">
                    <div class="l-wrap--header__back">
                        <a href="javascript:void(0)" onclick="history.back(); return false">
                            <img src="/img/icon-arrow-left-black.png">
                        </a>
                    </div>
                    <h1 class="l-wrap--header__title u-w100per_pc">撮影項目名マスター</h1>
                </div>
            </div>
            <div class="l-wrap--body l-wrap--body__list">
                <div class="l-wrap--add">
                    <div class="l-wrap--add__inner">
                        <div class="l-wrap--add__box l-wrap--add__input">
                            <input :class="{'is-invalid': errorMsg.name != ''}" type="text" name="" v-model="name" @keydown="checkEnter" placeholder="新しく項目名を入力してください">
                            <span class="invalid-feedback">{{ errorMsg.name }}</span>
                        </div>
                        <div class="l-wrap--add__box l-wrap--add__submit" @click.prevent.stop="registerItem">
                            <input type="submit" name="" value="追加">
                        </div>
                    </div>
                </div>
                <div class="l-wrap--body__inner">
                    <div class="l-wrap--body__list__block">
                        <ul class="noLink">
                            <template v-for="(item, index) in items">
                            <li>
                                <div class="l-select__wrap l-flex">
                                    <div class="l-select__wrap__box u-wflex1">{{ item.name }}</div>
                                    <div class="l-select__wrap__box u-w30_pc u-w25_sp">
                                        <a @click="toggleItemEdit(index)"><img src="/img/icon-dust-black.png"></a>
                                    </div>
                                </div>
                            </li>
                            </template>
                        </ul>
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
			    isItemEdit: false,
                items: [],
                name: '',
                selectedIndex: 0,
                hasError: false,
                hasSuccess: false,
                hasDeleted: false,
                errorMsg: {
			        name: '',
                }
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadItems();
		},
		computed: {},
		methods: {
            toggleItemEdit: function(index) {
		        this.isItemEdit = !this.isItemEdit;
		        this.selectedIndex = index;
            },
            loadItems: function() {
		        this.hasError = false;
                axios.get('/api/user/workreportmasters')
                    .then(result => {
                        let datas = result.data.data;
                        this.items.splice(0);
                        if (datas) {
                            for (let i = 0; i < datas.length; i ++) {
                                let data = datas[i];
                                this.items.push({
                                    id: data.id,
                                    name: data.name,
                                })
                            }
                        }
                    })
                    .catch(error => {
                        this.hasError = true;
                        console.log('err', error);
                    });
            },
            checkEnter: function(e) {
                if (e.keyCode == 13) {
                    this.registerItem();
                }
            },
            registerItem: function() {
                this.hasError = false;
                this.hasSuccess = false;
                let params = {
                    id: this.id,
                    name: this.name,
                };
                axios.post('/api/user/workreportmasters', params)
                    .then(result => {
                        this.hasSuccess = true;
                        this.name = '';
                        this.errorMsg.name = '';
                        this.loadItems();
                    })
                    .catch(error => {
                        this.hasError = true;
                        let errorMsg = error.response.data.errors;
                        if (errorMsg) {
                            if (errorMsg.name) {
                                this.errorMsg.name = errorMsg.name[0];
                            }
                        }
                    });
            },
            deleteItem: function(index) {
                this.hasError = false;
                this.hasDeleted = false;
                axios.delete('/api/user/workreportmasters/' + this.selectedIndex)
                    .then(result => {
                        this.hasDeleted = true;
                        this.isItemEdit = false;
                        this.loadItems();
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
