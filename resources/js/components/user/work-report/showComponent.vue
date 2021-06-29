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
        <!-- modal：項目を追加 -->
        <div class="l-modal" :class="{'open': isModalItemAdd}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalItemAdd">
                <div class="l-modal--area__input">
                    <div class="l-modal--area__input__box">
                        <label>撮影項目名</label>
                        <input type="text" name="">
                    </div>
                    <div class="l-modal--area__input__submit l-button--submit">
                        <input class="c-button--yellowRounded" type="submit" name="" value="登録">
                    </div>
                </div>
            </div>
        </div>
        <!-- fn modal：詳細を追加 -->

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">現場報告書</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li><a href="">PDFダウンロード</a></li>
                        <li><a href="/user/work-report/edit-cover/">表紙を編集する</a></li>
                        <li class="icon"><a @click="toggleModalTrush"><img src="/img/icon-dust-navygray.png"></a></li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a @click.prevent="toggleModalTrush">
                                <img src="/img/icon-dust-black.png">
                                <span>削除</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="l-wrap--tab">
            <ul class="l-wrap--tab__list tab-three">
                <li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">表紙情報</a></li>
                <li :class="{'selected': panelActive === '2'}"><a @click.prevent="changePanel('2')">撮影項目</a></li>
                <li :class="{'selected': panelActive === '3'}"><a @click.prevent="changePanel('3')">PDF項目一覧</a></li>
            </ul>
        </div>
        <!-- panel1：表紙情報 -->
        <div class="l-wrap--body l-wrap--body__detail" v-if="panelActive === '1'">
            <div class="l-wrap--button sp-only">
                <ul class="l-wrap--button__list button-one">
                    <li><a href="/user/work-report/edit-cover/">表紙を編集する</a></li>
                </ul>
            </div>
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__detail__box box-left">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">表紙情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>タイトル</th>
                                <td>タイトルタイトル</td>
                            </tr>
                            <tr>
                                <th>ロゴ</th>
                                <td><span class="u-color--gray">画像が未登録です</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- panel2：撮影項目 -->
        <div class="l-wrap--body l-wrap--body__table" v-if="panelActive === '2'">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__button">
                        <a class="c-button--addGreen" @click="toggleModalItemAdd">撮影項目を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__td u-w100_pc u-w80_sp">写真</div>
                                <div class="l-wrap--body__table__tr__inner u-wflex1">
                                    <div class="l-wrap--body__table__td u-w170_pc c-text--main_sp">撮影項目</div>
                                    <div class="l-wrap--body__table__td u-w170_pc c-text--sub_sp">撮影日 / 撮影者</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub_sp">写真詳細</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub_sp">共有メモ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <div class="l-wrap--body__table__tr" v-for="i in 3">
                            <a href="">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w100_pc u-w80_sp">
                                        <div class="c-detail--img">
                                            <img src="/img/384597_s.png">
                                        </div>
                                    </div>
                                    <div class="l-wrap--body__table__tr__inner u-wflex1">
                                        <div class="l-wrap--body__table__td u-w170_pc c-text--main_sp">工程内容工程内容</div>
                                        <div class="l-wrap--body__table__td u-w170_pc c-text--sub_sp">2020-12-10 / 撮影者名前</div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub_sp">写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細</div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub_sp">共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ共有メモ</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- panel3：PDF項目一覧-->
        <div class="l-wrap--body l-wrap--body__table" v-if="panelActive === '3'">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__download">
                        <a href="/user/work-report/sort-item/">PDFの写真を並び替える（PDFに反映）</a>
                    </div>
                    <div class="l-wrap--body__table__button">
                        <a class="c-button--addGreen" href="/user/work-report/select-item/">PDF用写真を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__td u-w100_pc u-w80_sp">写真</div>
                                <div class="l-wrap--body__table__tr__inner u-wflex1">
                                    <div class="l-wrap--body__table__td u-w170_pc c-text--main_sp">撮影項目</div>
                                    <div class="l-wrap--body__table__td u-w170_pc c-text--main_sp">撮影日 / 撮影者</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub_sp">写真詳細</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <div class="l-wrap--body__table__tr" v-for="i in 3">
                            <a href="">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w100_pc u-w80_sp">
                                        <div class="c-detail--img">
                                            <img src="/img/384597_s.png">
                                        </div>
                                    </div>
                                    <div class="l-wrap--body__table__tr__inner u-wflex1">
                                        <div class="l-wrap--body__table__td u-w170_pc c-text--main_sp">工程内容工程内容</div>
                                        <div class="l-wrap--body__table__td u-w170_pc c-text--sub_sp">2020-12-10 / 撮影者名前</div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub_sp">写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細写真詳細</div>
                                    </div>
                                </div>
                            </a>
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
                isModalItemAdd: false, // 撮影項目追加モーダル
                isModalTrash: false, // 削除モーダル
                isSearchActive: false, // 検索モーダル
                isModalPdf: false, // PDFダウンロードモーダル
                panelActive: '1', // タブパネルの切り替え
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
        },
        computed: {},
        methods: {
            // 撮影項目もーだる
            toggleModalItemAdd: function() {
                this.isModalItemAdd = !this.isModalItemAdd
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
        },
        watch: {},
    }
</script>