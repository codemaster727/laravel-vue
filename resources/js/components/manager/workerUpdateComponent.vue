<template>
    <!-- 職人詳細 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__detail">
            <div class="l-owner--inner">
                <div class="l-owner--head">職人詳細</div>
                <div class="l-owner--tab">
                    <ul class="l-owner--tab__list two-tab l-flex">
                        <li class="stop"><a href="">停止</a></li>
                        <li class="delete"><a href="">削除</a></li>
                    </ul>
                </div>
                <div class="l-owner--body">
                    <div class="l-owner--body__inner">
                        <div class="l-owner--body__input">
                            <div class="l-owner--body__input__content">
                                <label>職人ID</label>
                                <input
                                    type="text"
                                    name="worker_code"
                                    v-model="fields.workerCode"
                                />
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>職人名</label>
                                <input
                                    type="text"
                                    name="name"
                                    v-model="fields.name"
                                />
                            </div>
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
                                <label
                                    >パスワード
                                    <span
                                        class="u-color--gray u-textSize--small"
                                        >（新しいパスワードを入力してください）</span
                                    ></label
                                >
                                <input
                                    type="password"
                                    name="password"
                                    v-model="fields.password"
                                    placeholder="パスワードを入力してください。"
                                />
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>社内メモ</label>
                                <textarea></textarea>
                            </div>
                        </div>
                        <div class="l-owner--body__submit">
                            <input
                                type="submit"
                                name=""
                                value="変更内容を保存する"
                                class="c-button--blueRounded"
                                @click="update"
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
    name: "ManagerWorkerUpdate",
    data() {
        return {
            fields: {
                workerCode: "",
                email: "",
                password: "",
                name: "",
            },
            errors: {
                email: false,
                password: false,
            },
        };
    },
    methods: {
        update() {
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
                var id = 0;
                axios
                    .post(`/api/manager/worker/update`, {
                        email: this.fields.email,
                        password: this.fields.password,
                        name: this.fields.name,
                    })
                    .then((res) => {
                        console.log(res);
                        if (res.data === "ok") commit("DELETE_POST", post); //確認:res.data === "ok" ← ソースを追っていないので自信がない
                        // 更新成功後、職人一覧へURL遷移
                        location.href = "/manager/worker";
                    })
                    .catch((err) => {
                        // TODO:更新失敗の旨を画面に表示する
                        alert("サーバーエラー");
                        console.log(err);
                    });
            }
        },
    },
};
</script>
