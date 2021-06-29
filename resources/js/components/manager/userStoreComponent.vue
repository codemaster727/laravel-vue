<template>
    <!-- ユーザー追加 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__detail">
            <div class="l-owner--inner">
                <!--　case1：送信成功時 -->
                <!--
						<div class="l-alart managerAlart successAlart">
							<p>送信成功しました。</p>
						</div>
						-->

                <!--　case2：既に登録済み -->
                <!--
						<div class="l-alart managerAlart errorAlart">
							<p>既にメールアドレスは登録済みです。</p>
						</div>
						-->
                <div class="l-owner--head">ユーザー追加</div>
                <div class="l-owner--body">
                    <div class="l-owner--body__inner">
                        <div class="l-owner--body__input">
                            <div class="l-owner--body__input__content">
                                <label>メールアドレス</label>
                                <input
                                    type="email"
                                    name="email"
                                    v-model="fields.email"
                                    placeholder="メールアドレスを入力してください。"
                                />
                            </div>
                        </div>
                        <div class="l-owner--body__submit">
                            <button type="submit" class="c-button--blueRounded" @click="registerUser()">追加する</button>
                            <!-- <input
                                type="button"
                                name=""
                                value="追加する"
                                class="c-button--blueRounded"
                                @click="store"
                            /> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "ManagerUserStore",
    props: ['manager'],
    data() {
        return {
            tanaka: 'tanak',
            fields: {
                // company: "",
                // tel: "",
                // postal: "",
                // address: "",
                // status: "",
                // bank_type: "",
                // bank_id: "",
                email: "",
                // password: "",
            },
            errors: {
                email: false,
                // password: false,
            },
        };
    },
    created: function() {
    },
    mounted: function() {
    },
    methods: {
        registerUser() {
            this.errors.email = false;
            // this.errors.password = false;
            if (this.fields.email == "") {
                this.errors.email = true;
            }
            // if (this.fields.password == "") {
            //     this.errors.password = true;
            // }
            // if (!this.errors.email && !this.errors.password) {
            if (!this.errors.email) {
                var fields = this.fields;
                console.log(this.fields.manager_id);
                axios
                    .post("/api/manager/user/store", {
                        manager_id: this.manager,
                        // company: this.fields.company,
                        // tel: this.fields.tel,
                        // postal: this.fields.postal,
                        // address: this.fields.address,
                        // status: this.fields.status,
                        // bank_type: this.fields.bank_type,
                        // bank_id: this.fields.bank_id,
                        email: this.fields.email,
                        // password: this.fields.password,
                        // name: this.fields.name,
                    })
                    .then((res) => {
                        console.log(res);
                        if (res.data === "ok") commit("DELETE_POST", post); //確認:res.data === "ok" ← ソースを追っていないので自信がない
                        // 追加成功後、管理者一覧へURL遷移
                        location.href = "/manager/manager";
                    })
                    .catch((err) => {
                        // TODO:追加失敗の旨を画面に表示する
                        alert("サーバーエラー");
                        console.log(err);
                    });
            }
        },
    },
};
</script>
