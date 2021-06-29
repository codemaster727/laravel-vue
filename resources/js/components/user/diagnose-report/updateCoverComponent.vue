<template>
    <div class="l-wrap l-wrap--form">
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>診断報告書の更新に成功しました。</p>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>診断報告書の更新に失敗しました。</p>
        </div>

        <div class="l-wrap--inner">
            <div class="l-alart errorAlart" v-if="errorMsg">
                <p>{{ errorMsg }}</p>
            </div>
            <div class="l-wrap--header">
                <div class="l-wrap--header__inner">
                    <div class="l-wrap--header__back">
                        <a href="javascript:void(0)" @click="historyBack">
                            <img src="/img/icon-arrow-left-black.png">
                        </a>
                    </div>
                    <h1 class="l-wrap--header__title u-w100per">診断報告書の表紙を編集</h1>
                </div>
            </div>
            <div class="l-wrap--body l-wrap--body__input">
                <div class="l-wrap--body__inner">
                    <ul class="noLink">
                        <li>
                            <div class="l-input__wrap">
                                <label>タイトル</label>
                                <input type="text" placeholder="診断報告書のタイトルを記入してください" v-model="newTitle">
                            </div>
                        </li>
                        <li>
                            <div class="l-input__wrap">
                                <label>ロゴ</label>
                                <div class="l-input__file">
                                    <div class="l-input__preview" v-if="previewUrl">
                                        <img :src="previewUrl">
                                        <!-- <button>削除する</button> -->
                                    </div>
                                    <div class="l-input__upload">
                                        <span class="u-color--blue"><img src="/img/icon-camera.png">ロゴ画像を選択する</span>
                                        <input type="file" @change="changeLogo">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="l-button--submit">
                    <input class="c-button--yellowRounded" type="button" value="変更内容を保存する" @click="updateCover">
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
        // props: ['id', 'title', 'logo'],
        data() {
            return {
                newTitle: '',
                newLogo: '',
                previewUrl: '',
                errorMsg: '',
                hasSuccess: false,
                hasError: false,
            }
        },
        // mounted() {
        //     this.newTitle = this.title;
        // },
        created() {
            this.loadDiagnoseReport();
        },
        methods: {
            // ローディング
            loadDiagnoseReport: function() {
                this.diagnoseReport = []
                axios
                    .get(`/api/user/diagnosereports/${this.id}`)
                    .then(res => {
                        this.item = res.data
                        this.previewUrl = `/storage/${this.item['logo']}`
                        this.newTitle = this.item['title']
                    })
                    .catch(err => {
                        console.log(err)
                        alert('エラーが発生しました。')
                    })
            },
            changeLogo(e) {
                this.newLogo = e.target.files[0];
                this.previewUrl = URL.createObjectURL(e.target.files[0]);
            },
            updateCover() {
                const formData = new FormData();
                formData.append('title', this.newTitle);
                if (this.newLogo) {
                    formData.append('logo', this.newLogo);
                }
                let config = {
                    headers: {
                        "content-type": "multipart/form-data",
                        'X-HTTP-Method-Override': 'PUT'
                    },
                }
                axios
                    // .post('/api/user/diagnosereports/' + this.id, formData, config)
                    .post(`/api/user/diagnosereports/${this.id}`, formData, config)
                    .then(res => {
                        console.log(res)
                        this.hasSuccess = true

                        let url = `/user/diagnose-report/detail/${this.id}`
                        setTimeout(function() {
                            location.href = url
                        }, 1000);
                    })
                    .catch(error => {
                        const errorResp = error.response.data.errors.original;
                        this.hasError = true
                        if (errorResp) {
                            if (errorResp.logo) {
                                this.errorMsg = errorResp.logo[0];
                            }
                        }
                    })
            },
            historyBack() {}
        }
    }
</script>
