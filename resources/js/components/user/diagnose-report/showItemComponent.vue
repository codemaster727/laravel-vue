<template>
    <div class="l-wrap--inner">
        <!-- アラート -->
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>診断写真項目の削除に成功しました。</p>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>診断写真項目の削除に失敗しました。</p>
        </div>
        <!-- modal：削除 -->
        <div class="l-modal" :class="{'open': isModalTrash}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalTrush">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">本当に削除しても<br>よろしいでしょうか？</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalTrush">いいえ</a></li>
                            <li><a @click.prevent="deleteItem">はい</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal：削除 -->

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">診断報告書項目詳細</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__block">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__block__tab">
                    <ul class="l-flex l-center">
                        <li><a :href="`/user/diagnose-report/edit-item/${this.item['id']}`">編集する</a></li>
                        <li><a @click.prevent="toggleModalTrush">削除する</a></li>
                    </ul>
                </div>
                <div class="l-wrap--body__block__list">
                    <table>
                        <tr>
                            <th>タイトル</th>
                            <td>{{ this.item['name'] }}</td>
                        </tr>
                        <tr>
                            <th>写真詳細</th>
                            <td>{{ this.item['content'] }}</td>
                        </tr>
                        <tr>
                            <th>診断写真</th>
                            <td v-if="this.item['photo']">
                                <img :src="`/storage/${this.item['photo']}`">
                            </td>
                            <td v-else class="u-color--gray">画像が未登録です</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            id: {
                type: Number,
                required: true
            },
        },
        data() {
            return {
                // モーダル
                isModalTrash: false,
                item: '',
                hasSuccess: false,
                hasError: false,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadDiagnoseItems();
        },
        computed: {},
        methods: {
            // モーダル処理
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },
            // 項目詳細のロード
            loadDiagnoseItems: function() {
                this.item = ''
                axios
                    .get(`/api/user/diagnosereport-items/${this.id}`)
                    .then(res => {
                        this.item = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            // 項目削除
            deleteItem: function() {
                axios
                    .delete(`/api/user/diagnosereport-items/${this.id}`)
                    .then(res => {
                        console.log(res)
                        this.isModalTrash = false
                        this.hasSuccess = true
                        let url = `/user/diagnose-report/detail/${this.item['diagnose_report_id']}`

                        setTimeout(function() {
                            location.href = url
                        }, 1000);

                    })
                    .then(err => {
                        console.log(err)
                        this.isModalTrash = false
                        this.hasError = true
                    })
            },
        },
        watch: {},
    }
</script>
