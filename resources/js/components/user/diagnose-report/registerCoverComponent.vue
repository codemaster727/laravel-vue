<template>
    <div class="l-wrap l-wrap--form">
        <div class="l-wrap--inner">
            <div class="l-alart errorAlart" v-if="errorMsg">
                <p>{{ errorMsg }}</p>
            </div>
            <div class="l-wrap--header">
                <div class="l-wrap--header__inner">
                    <div class="l-wrap--header__back">
                        <!-- <a href="javascript:void(0)" @click="historyBack"> -->
                        <a :href="`/user/work/detail/${this.work_id}`">
                            <img src="/img/icon-arrow-left-black.png">
                        </a>
                    </div>
                    <h1 class="l-wrap--header__title u-w100per">診断報告書の表紙を作成</h1>
                </div>
            </div>
            <div class="l-wrap--body l-wrap--body__input">
                <div class="l-wrap--body__inner">
                    <ul class="noLink">
                        <li>
                            <div class="l-input__wrap">
                                <label>タイトル</label>
                                <input type="text" name="title" placeholder="診断報告書のタイトルを記入してください" v-model="title">
                            </div>
                        </li>
                        <li>
                            <div class="l-input__wrap">
                                <label>ロゴ</label>
                                <div class="l-input__file">
                                    <div class="l-input__preview" v-if="previewUrl">
                                        <img :src="previewUrl">
                                    </div>
                                    <div class="l-input__upload">
                                        <span class="u-color--blue">
                                            <img src="/img/icon-camera.png">ロゴ画像を選択する
                                        </span>
                                        <input type="file" @change="selectLogo">
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
                        :disabled="!btnEnabled"
                        :class="{'notSubmit':!btnEnabled}"
                        @click="registerCover"
                    >
                        画像を選択する
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['work_id'],
    data() {
        return {
            title: '',
            logo: null,
            previewUrl: null,
            errorMsg: ''
        }
    },
    methods: {
        registerCover() {
            // formDataコンストラクトのインスタンス化
            const formData = new FormData();
            // 値を入れる
            formData.append('work_id', this.work_id);
            formData.append('title', this.title);
            // ロゴが設定されている場合
            if (this.logo !== null) {
                formData.append('logo', this.logo);
            }
            axios.post('/api/user/diagnosereports', formData)
                .then((res) => {
                    const result = res.data;
                    location.href = '/user/diagnose-report/detail/' + result.id;
                })
                .catch(err => {
                    const errorResp = err.response.data.errors.original;
                })
            //     .then((response) => {
            //         const result = response.data;
            //         // location.href = '/user/diagnose-report/edit-cover/' + result.id;
            //     })
            //     .catch(error => {
            //         const errorResp = error.response.data.errors.original;
            //         // if (errorResp) {
            //         //     if (errorResp.logo) {
            //         //         this.errorMsg = errorResp.logo[0];
            //         //     }
            //         // }})
        },
        selectLogo(e) {
            this.logo = e.target.files[0];
            this.previewUrl = URL.createObjectURL(e.target.files[0]);
        },
        historyBack() {}
    },
    computed: {
        btnEnabled() {
            return this.title.length > 0;
        }
    }
}
</script>
