<template>
    <!-- 管理者詳細 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__detail">
            <div class="l-owner--inner">
                <!-- modal：出稿停止 -->
                <div class="l-modal" :class="{'open': isModalHolt}">
                    <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalHolt">
                        <div class="l-modal__iosModel">
                            <div class="l-modal__iosModel__inner">
                                <p class="c-sentence textCenter">本当に出稿停止しても<br>よろしいでしょうか？</p>
                                <ul class="l-flex trueFalse">
                                    <li><a @click.self="toggleModalHolt">いいえ</a></li>
                                    <li><a @click="holtAdvertising">はい</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fin modal：出稿停止 -->

                <!-- modal：削除 -->
                <div class="l-modal" :class="{'open': isModalTrash}">
                    <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalTrash">
                        <div class="l-modal__iosModel">
                            <div class="l-modal__iosModel__inner">
                                <p class="c-sentence textCenter">本当に削除しても<br>よろしいでしょうか？</p>
                                <ul class="l-flex trueFalse">
                                    <li><a @click.self="toggleModalTrash">いいえ</a></li>
                                    <li><a @click="deleteAdvertising">はい</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fin modal：削除 -->

                <!--　case1：成功時 -->
                <!--
                <div class="l-alart managerAlart successAlart">
                    <p>変更内容を保存しました。</p>
                </div>
                -->

                <!--　case2：失敗時 -->
                <!--
                <div class="l-alart managerAlart errorAlart">
                    <p>変更に失敗しました。</p>
                </div>
                -->
                <div class="l-owner--head">広告出稿詳細</div>
                <div class="l-owner--tab">
                    <ul class="l-owner--tab__list two-tab l-flex">
                        <li class="stop"><a @click="toggleModalHolt">出稿停止</a></li>
                        <li class="delete"><a @click="toggleModalTrash">削除</a></li>
                    </ul>
                </div>
                <div class="l-owner--body">
                    <div class="l-owner--body__inner">
                        <div class="l-owner--body__input">
                            <div class="l-owner--body__input__content">
                                <label>会社名</label>
                                <input type="" name="" v-model="advertising.company">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>URL</label>
                                <input type="" name="" v-model="advertising.url">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>電話番号</label>
                                <input type="" name="" v-model="advertising.phone">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>担当者名</label>
                                <input type="" name="" v-model="advertising.charge">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>メールアドレス</label>
                                <input type="" name="" v-model="advertising.email">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>携帯電話</label>
                                <input type="" name="" v-model="advertising.mobile">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>郵便番号（※半角数字のみ入力可）</label>
                                <input type="" name="" class="c-input--post__one" v-model="postal1" maxlength="3">
                                <input type="" name="" class="c-input--post__two" v-model="postal2" maxlength="4">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>住所</label>
                                <input type="" name="" v-model="advertising.address">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>契約期間</label>
                                <div class="c-select--triangle">
                                    <select v-model="advertising.advertising_terms[0].period">
                                        <option selected disabled>選択してください</option>
                                        <option v-for="period in periods" v-bind:key="period" v-bind:value="period">{{ period }}ヶ月</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>契約金額</label>
                                <div class="c-select--triangle">
                                    <select v-model="advertising.advertising_terms[0].price">
                                        <option selected disabled>選択してください</option>
                                        <option v-for="price in prices" v-bind:key="price" v-bind:value="price">¥ {{ price }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="l-owner--body__submit">
                            <input type="submit" name="" value="変更内容を保存する" class="c-button--blueRounded"
                                :disabled="!checkInputPass" :class="{'notSubmit':!checkInputPass}" @click="udpateAdvertising">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        props: ['id'],
        data() {
            return {
                advertising: {advertising_terms: [{price: undefined, period: undefined}]},
                postal1: '',
                postal2: '',
                periods: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                prices: [5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000],
                isModalTrash: false, // 削除モーダル
				isModalHolt: false, // 出稿停止モーダル
            }
        },
        created: function() {
            this.fetchAdvertising();
        },
        computed: {
            checkInputPass: function() {
                return this.advertising.company && this.advertising.url
                    && this.advertising.phone && this.advertising.charge
                    && this.advertising.email && this.advertising.address
                    && this.advertising.mobile && this.advertising.zip
                    && this.advertising.zip.length == 7
                    && this.advertising.advertising_terms[0].period && this.advertising.advertising_terms[0].price;
            }
        },
        methods: {
            // 削除モーダル
			toggleModalTrash: function() {
                this.isModalTrash = !this.isModalTrash;
            },

			// 出稿停止モーダル
			toggleModalHolt: function() {
                this.isModalHolt = !this.isModalHolt;
            },

            // 広告レコードを取得
            fetchAdvertising: function() {
                axios.get(`/api/manager/advertisings/${this.id}`)
                .then(res => {
                    this.advertising = res.data.data;
                    if (this.advertising.zip && this.advertising.zip.length > 3) {
                        this.postal1 = this.advertising.zip.substring(0, 3);
                        this.postal2 = this.advertising.zip.substring(3);
                    }
                    console.log(this.advertising);
                })
                .catch(err => {
                    alert('広告レコード取得エラー' + err);
                });
            },

            // 広告変更内容を保存する
            udpateAdvertising: function() {
                axios.put(`/api/manager/advertisings/${this.id}`, this.advertising)
                .then(res => {
                    console.log(res);
                    window.history.back();
                })
                .catch(err => {
                    alert('広告変更エラー' + err);
                });
            },

            // 広告出稿停止
            holtAdvertising: function() {
                let advertising = this.advertising;
                advertising.status = 1;
                console.log(advertising);
                axios.put(`/api/manager/advertisings/${this.id}`, {status: 1})
                .then(res => {
                    console.log(res);
                    this.isModalHolt = false;
                    window.history.back();
                })
                .catch(err => {
                    this.isModalHolt = false;
                    alert('広告出稿停止エラー' + err);
                });
            },

            // 広告削除
            deleteAdvertising: function() {
                axios.delete(`/api/manager/advertisings/${this.id}`)
                .then(res => {
                    console.log(res);
                    this.isModalTrash = false;
                    window.history.back();
                })
                .catch(err => {
                    this.isModalTrash = false;
                    alert('広告削除エラー' + err);
                });
            },
        },
        watch: {
            postal1: function (val) {
                this.advertising.zip = val + this.postal2;
            },
            postal2: function (val) {
                this.advertising.zip = this.postal1 + val;
            }
        },
	}
</script>
