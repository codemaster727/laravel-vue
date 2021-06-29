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

        <div class="l-main__header">
            <div class="l-main__header__title">
                <div class="sp-only l-main__header__title__back">
                    <img src="/img/icon-arrow-left-black.png">
                </div>
                <h1>工程内容詳細</h1>
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
                    <div class="l-main__header__sub__link"><a :href="`/user/process/edit/${this.id}`">編集する</a></div>
                    <div class="l-main__header__sub__link dust">
                        <a @click="toggleModalTrush"><img src="/img/icon-dust-navygray.png"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-main__body">

            <div class="l-main__link sp-only">
                <ul class="l-editButton one__box">
                    <li><a>編集する</a></li>
                </ul>
            </div>
            <div class="l-main__two__wrap">
                <div class="l-main__two__box">
                    <div class="l-main__body__thead">
                        <p class="theadHeadline">工程内容情報</p>
                    </div>
                    <div class="l-main__body__tbody">
                        <table>
                            <tr>
                                <th>該当現場</th>
                                <td><span v-if="process"><a href="" class="u-color--blue">{{ process ? process.work.name : '-' }}</a></span></td>
                            </tr>
                            <tr>
                                <th>名称</th>
                                <td><span v-if="process">{{ process.name }}</span></td>
                            </tr>
                            <tr>
                                <th>期間</th>
                                <td v-if="process">
                                    <span v-for="period in process.process_period" :key="period.id">
                                        {{ period.start_date }}-{{ period.finish_date }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>備考</th>
                                <td><span v-if="process">{{ process.memo }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="l-main__two__box">
                    <div class="l-main__body__thead">
                        <p class="theadHeadline">カラーを選択</p>
                    </div>
                    <div class="l-main__body__tbody">
                        <div class="l-inputLabel u-inputBox">
                            <ul class="color__list l-flex">
                                <li v-for="processColor in processColors" v-bind:key="processColor.id">
                                    <input type="radio" :checked="processColor.id==process.process_color_id" name="color" disabled>
                                    <label class="color__box" :class="'color' + processColor.color"></label>
                                </li>
                            </ul>
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
                isModalTrash: false, // モーダル
                process: undefined,
                processColors: [],
            }
        },
        created: function() {
            this.loadProcessColors();
            this.loadProcessDetail();
        },
        computed: {},
        methods: {
            // 工程カラーリストのローディング
            loadProcessColors: function() {
                this.processColors = [];
                axios
                    .get('/api/process-colors/')
                    .then((response) => {
                        this.processColors = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error)
                    });
            },

            // 工程詳細のローディング
            loadProcessDetail: function() {
                this.process = undefined;
                axios
                    .get(`/api/processes/${this.id}`)
                    .then((response) => {
                        this.process = response.data.data;
                        console.log(this.process)
                    })
                    .catch((error) => {
                        console.log(error)
                    });
            },

            // ゴミ箱のモーダル
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },
        },
        watch: {},
    }
</script>
