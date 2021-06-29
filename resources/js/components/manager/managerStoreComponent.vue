<template>
    <!-- 管理者追加 -->
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
                <div class="l-owner--head">管理者追加</div>
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
                            <div class="l-owner--body__input__content">
                                <label>パスワード</label>
                                <input
                                    type="password"
                                    name="password"
                                    v-model="fields.password"
                                    placeholder="パスワードを入力してください。"
                                />
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>権限</label>
                                <div class="c-select--triangle">
                                    <select v-model="name">
                                        <option>代理店</option>
                                        <option>管理者</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="l-owner--body__submit">
                            <input
                                type="button"
                                name=""
                                value="追加する"
                                class="c-button--blueRounded"
                                @click="store"
                            />
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
    name: "ManagerManagerStore",
    data() {
        return {
            fields: {
                email: "",
                password: "",
                name: "代理店",
            },
            errors: {
                email: false,
                password: false,
            },
        };
    },
    methods: {
        store() {
            this.errors.email = false;
            this.errors.password = false;
            if (this.fields.email == "") {
                this.errors.email = true;
            }
            if (this.fields.password == "") {
                this.errors.password = true;
            }
            if (!this.errors.email && !this.errors.password) {
                var fields = this.fields;
                axios
                    .post("/api/manager/manager/store", {
                        email: this.fields.email,
                        password: this.fields.password,
                        name: this.fields.name,
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
