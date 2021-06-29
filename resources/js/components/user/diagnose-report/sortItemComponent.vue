<template>

    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">診断写真を並び替える</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__list">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__list__block">
                    <draggable
                        tag="ul"
                        :list="items"
                        class="noLink"
                        @end="draggableEnd"
                    >
                        <li
                            class="listType--edit"
                            v-for="(item, index) in items"
                            :key="index"
                        >
                            <label class="l-order__wrap l-flex">
                                <div class="l-order__detail l-flex">
                                    <div class="c-detail--img">
                                        <img :src="`/storage/${item.photo}`">
                                    </div>
                                    <div class="c-detail--text">
                                        <p class="c-detail--text__headline">{{ item.name }}</p>
                                        <p class="c-detail--text__other">{{ item.content }}</p>
                                    </div>
                                </div>
                                <!-- この箇所をドラッグ&ドロップで選択でき、ブロック全体を移動できる -->
                                <div class="l-order__area">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </label>
                        </li>
                    </draggable>
                </div>
            </div>
            <div class="l-button--submit">
                <button
                    class="c-button--yellowRounded"
                    @click="registerDiagnoseItems"
                >
                    変更内容を保存する
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import draggable from 'vuedraggable'

    export default {
        props: {
            id: {
                type: Number,
                required: true,
                diagnoseReport: [],
            },
        },
        data() {
            return {
                items: [],
                isModalTrash: false, // モーダル
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadDiagnoseReport();
        },
        computed: {},
        methods: {
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },
            // ローディング
            loadDiagnoseReport: function() {
                this.diagnoseReport = []
                axios
                    .get(`/api/user/diagnosereports/${this.id}`)
                    .then(res => {
                        // this.items = res.data.diagnose_report_items
                        console.log(res)
                        this.items = res.data.diagnose_report_items
                        // ソート順に並び替え
                        this.items.sort(function(a, b) {
                            return a.sort_order - b.sort_order
                        })
                    })
                    .catch(err => {
                        console.log(err)
                        alert('エラーが発生しました。')
                    })
            },
            // 診断報告書並び替え
            draggableEnd: function(index) {
                // 現在の位置情報からsortを設定する
                let lists = this.items
                lists.forEach((element, index) =>
                    lists[index]['sort'] = index + 1
                )
            },
            // 診断報告書登録処理
            registerDiagnoseItems: function() {
                let fd = new FormData();
                this.items.map(item => {
                    fd.append("items[id][]", item.id);
                    fd.append("items[sort][]", item.sort);
                })
                let config = {
                    headers: {
                        "content-type": "multipart/form-data",
                    },
                }
                axios
                    .post(`/api/user/diagnosereport-items/${this.id}/sort`, fd, config)
                    .then(res => {
                        console.log(res)
                        this.hasSuccess = true
                        let url = `/user/diagnose-report/detail/${this.id}`

                        setTimeout(function() {
                            location.href = url
                        }, 1000);
                    })
                    .catch(err => {
                        console.log(err)
                        this.hasError = true
                    })
            },
        },
        watch: {},
    }
</script>
