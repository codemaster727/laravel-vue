<template>
    <!-- 管理者詳細 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__detail">
            <div class="l-owner--inner">
                <!--　case1：送信成功時 -->
                <!--
                <div class="l-alart managerAlart successAlart">
                    <p>送信成功しました。</p>
                </div>
                -->

                <!--　case2：既に登録済み -->
                <!--
                <div class="l-alart managerAlart errorAlart">
                    <p>既にメールアドレスは登録済みです。</p>
                </div>
                -->
                <div class="l-owner--head">広告出稿追加</div>
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
                                <label>画像</label>
                                <input type="file" id="img" name="" @change="onSelectImage">
                                <img id="img-preview" src="">
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
                                    <select v-model="advertising_terms.period">
                                        <option selected disabled>選択してください</option>
                                        <option v-for="period in periods" v-bind:key="period" v-bind:value="period">{{ period }}ヶ月</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>契約金額</label>
                                <div class="c-select--triangle">
                                    <select v-model="advertising_terms.price">
                                        <option selected disabled>選択してください</option>
                                        <option v-for="price in prices" v-bind:key="price" v-bind:value="price">¥ {{ price }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="l-owner--body__submit">
                            <input type="submit" name="" value="追加する" class="c-button--blueRounded"
                                :disabled="!checkInputPass" :class="{'notSubmit':!checkInputPass}" @click="storeAdvertising">
                        </div>
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
                advertising: {manager_id: 1},
                advertising_terms: {},
                postal1: '',
                postal2: '',
                periods: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                prices: [5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000],
            }
        },
        created: function() {
        },
        computed: {
            checkInputPass: function() {
                return this.advertising.company && this.advertising.url
                    && this.advertising.phone && this.advertising.charge
                    && this.advertising.email && this.advertising.address
                    && this.advertising.mobile && this.advertising.zip
                    && this.advertising.zip.length == 7
                    && this.advertising_terms.period && this.advertising_terms.price;
            }
        },
        methods: {
            // 広告追加
            storeAdvertising: function() {
                this.advertising.advertising_terms = [];
                this.advertising.advertising_terms.push(this.advertising_terms);
                let input = document.getElementById('img');
                let formData = new FormData();
                formData.append('img', input.files[0]);
                formData.append('manager_id', this.advertising.manager_id);
                formData.append('company', this.advertising.company);
                formData.append('url', this.advertising.url);
                formData.append('phone', this.advertising.phone);
                formData.append('charge', this.advertising.charge);
                formData.append('email', this.advertising.email);
                formData.append('mobile', this.advertising.mobile);
                formData.append('zip', this.advertising.zip);
                formData.append('address', this.advertising.address);
                formData.append('advertising_terms', JSON.stringify(this.advertising.advertising_terms));
                axios.post('/api/manager/advertisings', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(res => {
                        /*setTimeout(function() {
                            document.location.href = '/manager/advertising';
                        }, 1000);*/
                    }).catch(err => {
                        alert(err);
                    });
            },
            onSelectImage: function() {
                let input = document.getElementById('img');
                let img = $('#img-preview');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        img.attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
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
