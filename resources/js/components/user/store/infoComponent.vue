<template>
    <div class="l-login__wrap">
        <div class="l-login__title">
            <h1>新規登録 基本情報入力(1/2)</h1>
        </div>
        <div class="l-form__area">
            <div class="l-alart errorAlart" v-if="hasRegisterd" style="position:fixed; z-input:999; top:70px">
                <p>既に登録が完了しています。</p>
            </div>
            <div class="l-alart errorAlart" v-if="hasTimePassed" style="position:fixed; z-input:999; top:70px">
                <p>8時間以内に登録が完了しませんでした。最初からやり直してください。</p>
            </div>
            <div class="l-alart errorAlart" v-if="storeFailed" style="position:fixed; z-input:999; top:70px">
                <p>新規ユーザーの基本情報の登録に失敗しました。</p>
            </div>
            <div class="l-alart errorAlart" v-if="userFailed" style="position:fixed; z-input:999; top:70px">
                <p>新規ユーザー情報が存在しません。</p>
            </div>
            <div class="l-form__explain">
                <p class="c-sentence">ぬりえもんのユーザー用新規登録のご案内です。<br>パスワードは、ログイン情報として使用しますので、必ず保存してください。</p>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>パスワード</label>
                <input class="c-input--white" :class="{'is-invalid': errorMsg.password != ''}" type="password" name="" v-model="password" placeholder="パスワードを入力してください。">
                <span class="invalid-feedback">{{ errorMsg.password }}</span>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>確認用パスワード</label>
                <input class="c-input--white" :class="{'is-invalid': errorMsg.repassword != ''}" type="password" name="" v-model="repassword" placeholder="パスワードを入力してください。">
                <span class="invalid-feedback">{{ errorMsg.repassword }}</span>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>電話番号</label>
                <input class="c-input--white" :class="{'is-invalid': errorMsg.tel != ''}" type="text" name="" v-model="tel" placeholder="電話番号を入力してください。">
                <span class="invalid-feedback">{{ errorMsg.tel }}</span>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>会社名</label>
                <input class="c-input--white" :class="{'is-invalid': errorMsg.company != ''}" type="text" name="" v-model="company" placeholder="会社名を入力してください。">
                <span class="invalid-feedback">{{ errorMsg.company }}</span>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>郵便番号</label>
                <input class="c-input--white c-input--post__one u-mr10" :class="{'is-invalid': errorMsg.postal != ''}" type="" name="" v-model="front_postal" placeholder="000">
                <input class="c-input--white c-input--post__two" :class="{'is-invalid': errorMsg.postal != ''}" type="" name="" v-model="back_postal" placeholder="0000">
                <span class="invalid-feedback">{{ errorMsg.postal }}</span>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>住所</label>
                <input class="c-input--white" :class="{'is-invalid': errorMsg.address != ''}" type="text" name="" v-model="address" placeholder="住所を入力してください。">
                <span class="invalid-feedback">{{ errorMsg.address }}</span>
            </div>
            <div class="l-button--submit" @click.prevent.stop="doStoreInfo">
                <input class="c-button--yellowRounded" type="submit" name="" value="営業担当の登録に進む">
            </div>
        </div>
    </div>
</template>

<script>
	export default {
	    props: ['token', 'status'],
        data() {
            return {
                password: '',
                repassword: '',
                tel : '',
                company: '',
                front_postal: '',
                back_postal: '',
                address: '',
                storeFailed: false,
                userFailed: false,
                hasRegisterd: false,
                hasTimePassed: false,
                errorMsg: {
                    password: '',
                    repassword: '',
                    tel: '',
                    company: '',
                    postal: '',
                    address: ''
                }
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            switch (this.status) {
                case 1:
                    this.hasRegisterd = true; 
//                    setTimeout(function(){ location.href = '/login'; }, 2000);
                    break;
                case 2:
                    this.hasTimePassed = true; 
//                    setTimeout(function(){ location.href = '/'; }, 2000);
                    break;
            }
        },
        computed: {
        },
        methods: {
            doStoreInfo: function() {
                this.storeFailed = false;
                this.userFailed = false;
                this.hasRegisterd = false;
                this.hasTimePassed = false;
                
                let params = {
                    password    : this.password,
                    repassword  : this.repassword,
                    tel         : this.tel,
                    company     : this.company,
                    postal      : this.front_postal+this.back_postal,
                    address     : this.address,
                    token       : this.token,
                };
                axios.post('/api/users/store-info', params)
                    .then(result => {
                        console.log(result.data);
                        let response = result.data;

                        this.errorMsg = {
                            password: '',
                            repassword: '',
                            tel: '',
                            company: '',
                            postal: '',
                            address: ''
                        };
                        if (response && response.message) {
                            if(response.message == 'ok'){
                                location.href = '/login';
                            }else if(response.message == 'not_user'){
                                this.userFailed = true;
                            }else{
                                this.storeFailed = true;
                            }
                        }
                    })
                    .catch(error => {
                        this.storeFailed = true;
                        let errorMsg = error.response.data.errors.original;
                        if (errorMsg) {
                            if (errorMsg.password) {
                                this.errorMsg.password = errorMsg.password[0];
                            }else{
                                this.errorMsg.password = '';
                            }
                            if (errorMsg.repassword) {
                                this.errorMsg.repassword = errorMsg.repassword[0];
                            }else{
                                this.errorMsg.repassword = '';
                            }
                            if (errorMsg.tel) {
                                this.errorMsg.tel = errorMsg.tel[0];
                            }else{
                                this.errorMsg.tel = '';
                            }
                            if (errorMsg.company) {
                                this.errorMsg.company = errorMsg.company[0];
                            }else{
                                this.errorMsg.company = '';
                            }
                            if (errorMsg.postal) {
                                this.errorMsg.postal = errorMsg.postal[0];
                            }else{
                                this.errorMsg.postal = '';
                            }
                            if (errorMsg.address) {
                                this.errorMsg.address = errorMsg.address[0];
                            }else{
                                this.errorMsg.address = '';
                            }
                        }
                    });

            }
        },
        watch: {},
	}
</script>