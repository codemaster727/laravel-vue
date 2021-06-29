<template>
    <div class="l-wrap l-wrap--form">

        <!-- アラート -->
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>診断写真項目の更新に成功しました。</p>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>診断写真項目の更新に失敗しました。</p>
        </div>

        <div class="l-wrap--inner">
            <div class="l-wrap--header">
                <div class="l-wrap--header__inner">
                    <div class="l-wrap--header__back">
                        <!-- <a href="javascript:void(0)" @click="historyBack"> -->
                        <a :href="`/user/diagnose-report/detail-item/${this.id}`">
                            <img src="/img/icon-arrow-left-black.png">
                        </a>
                    </div>
                    <h1 class="l-wrap--header__title u-w100per">診断写真編集</h1>
                </div>
            </div>
            <div class="l-wrap--body l-wrap--body__input">
                <div class="l-wrap--body__inner">
                    <ul class="noLink">
                        <li>
                            <div class="l-input__wrap">
                                <label>診断写真タイトル</label>
                                <input
                                    v-model="item['name']"
                                    placeholder="診断報告書のタイトルを記入してください"
                                >
                            </div>
                        </li>
                        <li>
                            <div class="l-input__wrap">
                                <label>診断写真詳細</label>
                                <textarea
                                    v-model="item['content']"
                                    placeholder="診断報告書の詳細を記入してください"
                                />
                            </div>
                        </li>
                        <li>
                            <div class="l-input__wrap">
                                <label>診断写真</label>
                                <div class="l-input__file">
                                    <div class="l-input__preview" v-if="preview">
                                        <img :src="preview">
                                        <!-- <img :src="`/storage/${item['photo']}`"> -->
                                        <!-- <img :src="/img/1560031.jpg"> -->
                                    </div>
                                    <div class="l-input__upload">
                                        <span class="u-color--blue">
                                            <img src="/img/icon-camera.png">診断報告書画像を変更する
                                        </span>
                                        <input type="file" @change="selectPhoto">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="l-button--submit">
                    <button
                        class="c-button--yellowRounded"
                        type="button"
                        @click="updateItem"
                    >
                        変更内容を保存する
                    </button>
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
                item: '',
                preview: '',
                hasSuccess: false,
                hasError: false,
            }
        },
        // props: ['id', 'name', 'content', 'photo'],
        created() {
            this.loadDiagnoseItem();
        },
        computed: {},
        methods: {
            historyBack() {},
            // 項目詳細のロード
            loadDiagnoseItem: function() {
                this.item = ''
                axios
                    .get(`/api/user/diagnosereport-items/${this.id}`)
                    .then(res => {
                        this.item = res.data.data
                        this.preview = `/storage/${this.item['photo']}`
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            // 診断写真更新
            selectPhoto(e) {
                this.item['photo'] = e.target.files[0];
                this.preview = URL.createObjectURL(e.target.files[0]);
            },
            // 診断写真詳細更新
            updateItem: function() {
                let fd = new FormData()

                fd.append('name', this.item['name'])
                fd.append('content', this.item['content'])
                fd.append('photo', this.item['photo'])

                let config = {
                    headers: {
                        "content-type": "multipart/form-data",
                        'X-HTTP-Method-Override': 'PUT'
                    },
                }
                axios
                    .post(`/api/user/diagnosereport-items/${this.id}`, fd, config)
                    .then(res => {
                        console.log(res)
                        this.hasSuccess = true
                        let url = `/user/diagnose-report/detail/${this.item['diagnose_report_id']}`
                        setTimeout(function() {
                            location.href = url
                        }, 1000);
                    })
                    .catch(err => {
                        console.log(err)
                        this.hasError = true
                    })
            },
        }
    }
</script>
