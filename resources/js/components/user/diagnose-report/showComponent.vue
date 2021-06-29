<template>
    <div class="l-main__wrap">
        <!-- modal：削除 -->
        <div class="l-modal" :class="{'open': isModalTrash}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalTrush">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">本当に削除しても<br>よろしいでしょうか？</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalTrush">いいえ</a></li>
                            <li><a @click.self="deleteDiagnoseReport">はい</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal：削除 -->

        <!-- modal：PDF -->
        <div class="l-modal" :class="{'open': isModalPdf}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalPdf">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">PDFをダウンロードしますか？</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalPdf">いいえ</a></li>
                            <li><a @click.self="">はい</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal：PDF -->
        <div class="l-main__header">
            <div class="l-main__header__title">
                <div class="sp-only l-main__header__title__back">
                    <img src="/img/icon-arrow-left-black.png">
                </div>
                <h1>診断報告書</h1>
                <div class="sp-only l-main__header__title__icon">
                    <ul class="l-flex">
                        <li>
                            <a @click.prevent="toggleModalTrush">
                                <img src="/img/icon-dust-black.png">
                                <span>削除</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="l-main__header__sub pc-only">
                <div class="l-flex l-v__center">
                    <div class="l-main__header__sub__link"><a @click="toggleModalPdf">PDFダウンロード</a></div>
                    <!-- 画像選択画面に遷移するため、スマホのライブラリにアクセスする（画像は複数登録可） -->
                    <div class="l-main__header__sub__link"><a :href="`/user/diagnose-report/edit-cover/${this.reportId}`">表紙を編集する</a></div>
                    <div class="l-main__header__sub__link dust">
                        <a @click="toggleModalTrush"><img src="/img/icon-dust-navygray.png"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-main__tab">
            <ul class="l-main__tab__two l-flex l-start">
                <li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">基本情報</a></li>
                <li :class="{'selected': panelActive === '2'}"><a @click.prevent="changePanel('2')">診断写真</a></li>
            </ul>
        </div>
        <!-- panel：基本情報 -->
        <div class="l-main__body" v-if="panelActive === '1'">
            <div class="l-main__link sp-only">
                <ul class="l-editButton two__box">
                    <li><a @click="toggleModalPdf">PDFダウンロード</a></li>
                    <li><a href="/user/diagnose-report/edit-cover">表紙を編集する</a></li>
                </ul>
            </div>
            <div class="l-main__two__wrap">
                <div class="l-main__two__box">
                    <div class="l-main__body__thead">
                        <p class="theadHeadline">表紙情報</p>
                    </div>
                    <div class="l-main__body__tbody">
                        <table>
                            <tr>
                                <th class="u-w80">タイトル</th>
                                <td>
                                    <span v-if="diagnoseReport">{{ diagnoseReport.title }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>ロゴ</th>
                                <td>
                                    <span v-if="diagnoseReport.logo">
                                        <img :src="`/storage/${diagnoseReport.logo}`">
                                    </span>
                                    <span v-else class="u-color--gray">画像が未登録です</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- panel：診断写真 -->
        <div class="l-main__body" v-else-if="panelActive === '2'">
            <div class="l-main__body__add whiteList">
                <a class="textLink download" :href="`/user/diagnose-report/sort-item/${this.reportId}`">診断報告書写真を並び替える（PDF反映）</a>
            </div>
            <div class="l-main__body__add whiteList">
                <!--
                    １：画像選択画面に遷移するため、スマホのライブラリにアクセスする（画像は複数登録可）
                    ２：選択された画像を一覧で表示し、それぞれのタイトル及び詳細を記入できるようにする（遷移先：/user/diagnose-report/register-item）
                -->
                <a class="c-button--addGreen" :href="`/user/diagnose-report/register-item/${this.reportId}`">診断写真を追加</a>
            </div>
            <div class="l-main__body__thead pc-only">
                <div class="l-flex l-sp_">
                    <div class="l-main__body__thead__td u-w80_pc">
                        <p>写真</p>
                    </div>
                    <div class="l-main__body__thead__td u-w240_pc">
                        <p>診断項目</p>
                    </div>
                    <div class="l-main__body__thead__td u-wflex1_pc">
                        <p>備考</p>
                    </div>
                </div>
            </div>
            <ul class="l-main__body__tbody" v-if="diagnoseReport">
                <li
                    class="listType--edit"
                    v-for="(item, index) in diagnoseReport.diagnose_report_items"
                    :key="index"
                >
                    <a :href="`/user/diagnose-report/detail-item/${item.id}`">
                        <div class="l-flex">
                            <div class="l-main__body__tbody__left u-w80_pc u-w40_sp">
                                <img :src="`/storage/${item.photo}`">
                            </div>
                            <div class="l-main__body__tbody__right u-wflex1 l-flex l-sp__column ">
                                <div class="l-main__body__tbody__td u-w240_pc">
                                    <p class="workDetail_title">{{ item.name }}</p>
                                </div>
                                <div class="l-main__body__tbody__td u-wflex1_pc">
                                    <p class="workDetail_remark">{{ item.content }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            reportId: {
                type: Number,
                required: true
            },
        },
        data() {
            return {
                isModalTrash: false, // 削除モーダル
                isSearchActive: false, // 検索モーダル
                isModalPdf: false, // PDFダウンロードモーダル
                panelActive: '1', // タブパネルの切り替え
                diagnoseReport: [],
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadDiagnoseReport();
        },
        computed: {},
        methods: {
            // ローディング
            loadDiagnoseReport: function() {
                this.diagnoseReport = []
                axios
                    .get(`/api/user/diagnosereports/${this.reportId}`)
                    .then(res => {
                        this.diagnoseReport = res.data
                        console.log(res)
                    })
                    .catch(err => {
                        console.log(err)
                        alert('エラーが発生しました。')
                    })
            },
            // ゴミ箱モーダル
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },
            // 検索モーダル
            toggleSearchActive: function() {
                this.isSearchActive = !this.isSearchActive;
            },
            // PDFモーダル
            toggleModalPdf: function() {
                this.isModalPdf = !this.isModalPdf;
            },
            // タブパネルの切り替え
            changePanel: function(num) {
                this.panelActive = num
            },
            // 診断報告書削除
            deleteDiagnoseReport: function() {
                axios
                    .delete(`/api/user/diagnosereports/${this.reportId}`)
                    .then(res => {
                        console.log(res)

                        setTimeout(function() {
                            location.href = '/user/work'
                        }, 1000);
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
        },
        watch: {},
    }
</script>
