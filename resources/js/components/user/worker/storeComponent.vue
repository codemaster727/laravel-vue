<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>職人の追加に失敗しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>職人の追加に成功しました。</p>
        </div>
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="/user/worker">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">職人を追加</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">
                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>職人ID</label>
                            <!-- aJax通信 -->
                            <input v-model="workerCode" placeholder="職人IDを入力してください">
                        </div>
                    </li>
                    <!-- submit時 -->
                    <li v-if="findType === 1">
                        <!-- ①：IDから見つからなかった場合 -->
                        <div v-if="showType === 0" class="l-input__wrap">
                            <p class="u-text--center">IDから見つかりませんでした。</p>
                        </div>
                        <!-- ②：IDから見つかった場合 -->
                        <div v-else-if="showType === 1" class="l-input__wrap">
                            <p class="u-text--center">職人が見つかりました。</p>
                            <p class="c-text--border u-text--center u-mt10">{{ workerName }}</p>
                        </div>
                    </li>
                    <!-- fin submit時 -->
                </ul>
            </div>
            <div class="l-button--submit">
                <button v-if="showType === 0" @click.stop.prevent="searchWorker" class="c-button--yellowRounded" type="button">職人IDから検索する</button>
                <button v-else-if="showType === 1" @click.stop.prevent="addWorker" class="c-button--yellowRounded" type="button">職人を追加する</button>
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
        props: ['user_id'],
        data() {
            return {
                findType: 0,
                showType: 0,
                hasError: false,
                hasSuccess: false,
                workerName: '',
                workerCode: '',
                workerId: '',
            }
        },
        computed: {},
        methods: {
            // 職人を検索する
            searchWorker: function() {
                axios
                    .post(`/api/user/workers/${this.workerCode}/search`)
                    .then(result => {
                        if(result.data) {
                            this.showType = 1
                        }
                        this.findType = 1
                        this.workerName = result.data.name
                        this.workerId = result.data.id
                    })
                    .catch(error => {
                        this.showType = 0
                        this.findType = 1
                        console.log(error)
                    })
            },
            // 職人を追加する
            addWorker: function() {
                const params = {
                    id: this.workerId,
                }
                this.hasError = false
                this.hasSuccess = false
                axios
                    .post('/api/user/charge-users', params)
                    .then(result => {
                        this.hasSuccess = true
                        setTimeout(function() {
                            location.href = '/user/worker';
                        }, 1000);
                    })
                    .catch(error => {
                        this.hasError = true
                    })
            },
        },
        watch: {},
    }
</script>
