<template>
    <div class="l-wrap l-wrap--form">
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>診断報告書の登録に成功しました。</p>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>診断報告書の登録に失敗しました。</p>
        </div>
        <div class="l-wrap--inner">
            <div class="l-wrap--header">
                <div class="l-wrap--header__inner">
                    <div class="l-wrap--header__back">
                        <a :href="`/user/diagnose-report/detail/${this.id}`">
                            <img src="/img/icon-arrow-left-black.png">
                        </a>
                    </div>
                    <h1 class="l-wrap--header__title u-w100per">診断報告書の詳細を記入</h1>
                </div>
            </div>
            <div class="l-wrap--body l-wrap--body__list">
                <div class="l-input__file">
                    <div class="l-input__upload">
                        <span class="u-color--blue">
                            <img src="/img/icon-camera.png" alt="カメラアイコン">診断報告書の画像を追加する</span>
                        <input
                            type="file"
                            @change="addItem"
                            multiple
                        >
                    </div>
                </div>
                <div class="l-wrap--body__inner">
                    <div class="l-wrap--body__list__block" v-if="items">
                        <draggable
                            tag="ul"
                            :list="items"
                            class="noLink"
                            @end="draggableEnd"
                        >
                            <li
                                v-for="item in items"
                                :key="item.id"
                                draggable="true"
                            >
                                <label class="l-select__wrap l-flex">
                                    <div class="l-select__detail l-flex">
                                        <div class="c-detail--img">
                                            <!-- <img :src="item.photo"> -->
                                            <img :src="item.preview">
                                        </div>
                                        <div class="c-detail--text l-flex">
                                            <div class="c-detail--text__input">
                                                <input
                                                    type="text"
                                                    v-model="item.name"
                                                    placeholder="タイトルを記入してください"
                                                >
                                            </div>
                                            <div class="c-detail--text__input">
                                                <textarea
                                                    v-model="item.content"
                                                    placeholder="詳細を記入してください"
                                                />
                                            </div>
                                        </div>
                                    </div>
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
                        type="button"
                        :disabled="!form_all"
                        :class="{'notSubmit':!form_all}"
                        @click="registerDiagnoseItems"
                    >
                        診断報告書を追加する
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable
        },
        // diagnose report id
        props: {
            id: {
                type: Number,
                required: true
            },
        },
        data() {
            return {
                title: '',
                logo: null,
                previewUrl: null,
                errorMsg: '',
                items: [],
                hasSuccess: false,
                hasError: false,
            }
        },
        created() {
        },
        computed: {
            // 入力状況でsubmitができる
            form_all: function() {
                let required_fields = [
                    this.items
                ]
                return required_fields.indexOf('') === -1
            },
        },
        methods: {
            // 診断報告書追加
            addItem: function(event) {
                // 取得した画像の配列を入れ直す
                let images = []
                images = event.target.files
                // 現状のsortの番号を取得
                let number = this.items.length + 1
                // 配列に追加する
                Array.from(images).forEach((element, index) =>
                    this.items.push(...[{
                        // photo: URL.createObjectURL(element),
                        photo: element,
                        preview: URL.createObjectURL(element),
                        name: '',
                        content: '',
                        id: null,
                        sort: number + index
                    }])
                )
            },
            // 診断報告書並び替え
            draggableEnd: function(index) {
                // 現在の位置情報からsortを設定する
                let lists = this.items
                lists.forEach((element, index) =>
                    lists[index]['sort'] = index + 1
                )
            },
            targetClick: function(index) {
            },
            registerDiagnoseItems: function() {
                // let params = {
                //     diagnose_report_id: this.id,
                //     items: this.items,
                // }

                let fd = new FormData();
                fd.append('diagnose_report_id', this.id);
                this.items.map(item => {
                    fd.append("items[photo][]", item.photo);
                    fd.append("items[name][]", item.name);
                    fd.append("items[content][]", item.content);
                    fd.append("items[id][]", item.id);
                    fd.append("items[sort][]", item.sort);
                })
                let config = {
                    headers: {
                        "content-type": "multipart/form-data",
                    },
                }
                axios
                    .post("/api/user/diagnosereport-items", fd, config)
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
            historyBack() {},
        }
    }
</script>
