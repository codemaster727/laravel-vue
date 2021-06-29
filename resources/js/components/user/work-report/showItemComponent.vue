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
                            <li><a href="">はい</a></li>
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
                <h1 class="l-wrap--header__title u-w100per">撮影項目詳細</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__block">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__block__tab">
                    <ul class="l-flex l-center">
                        <li><a href="/user/work-report/edit-item">編集する</a></li>
                        <li><a @click.prevent="toggleModalTrush">削除する</a></li>
                    </ul>
                </div>
                <div class="l-wrap--body__block__list">
                    <table>
                        <tr>
                            <th>タイトル</th>
                            <td>タイトルタイトルタイトルタイトルタイトルタイトル</td>
                        </tr>
                        <tr>
                            <th>写真詳細</th>
                            <td>写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細</td>
                        </tr>
                        <tr>
                            <th>共有メモ</th>
                            <td>共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ</td>
                        </tr>
                        <tr>
                            <th>社内メモ</th>
                            <td>社内メモ社内メモ社内メモ社内メモ社内メモ社内メモ社内メモ社内メモ社内メモ社内メモ社内メモ社内メモ</td>
                        </tr>
                        <tr>
                            <th>診断写真</th>
                            <td class="u-color--gray">画像が未登録です</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                isModalTrash: false, // モーダル
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
        },
        computed: {},
        methods: {
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },
        },
        watch: {},
    }
</script>