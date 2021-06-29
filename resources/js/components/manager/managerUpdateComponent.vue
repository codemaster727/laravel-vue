<template>
    <!-- 管理者詳細 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__detail">
            <div class="l-owner--inner">
                <div class="l-owner--head">管理者詳細</div>
                <div class="l-owner--tab">
                    <ul class="l-owner--tab__list two-tab l-flex">
                        <li :class="{'stop': manager.status==MANAGER_ACTIVE, 'start': manager.status==MANAGER_HALTING}">
                            <a v-if="manager.status==MANAGER_ACTIVE" @click="haltManager">停止</a>
                            <a v-if="manager.status==MANAGER_HALTING" @click="restoreManager">再開</a>
                        </li>
                        <li class="delete"><a @click="deleteManager">削除</a></li>
                    </ul>
                </div>
                <div class="l-owner--body">
                    <div class="l-owner--body__inner">
                        <div class="l-owner--body__input">
                            <div class="l-owner--body__input__content">
                                <label>管理者名</label>
                                <input type="email" name="email" v-model="manager.name" placeholder="メールアドレスを入力してください。">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>メールアドレス</label>
                                <input type="email" name="email" v-model="manager.email" placeholder="メールアドレスを入力してください。">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>パスワード<span class="u-color--grayNavy u-textSize--small"></span></label>
                                <input type="password" name="password" v-model="manager.password" placeholder="パスワードは上書きされます。">
                            </div>
                            <div style="margin-bottom: 21px;">
                                <label for="authority">
                                    <input type="checkbox" name="authority" v-model="manager.isAdmin">
                                    管理者
                                </label>
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>社内メモ</label>
                                <textarea v-model="manager.memo"></textarea>
                            </div>
                        </div>
                        <div class="l-owner--body__submit">
                            <input type="button" name="" value="変更内容を保存する" class="c-button--blueRounded"
                                @click="updateManager" :disabled="!form_all" :class="{'notSubmit':!form_all}">
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
    props: ['id'],
    name: "ManagerManagerUpdate",
    data() {
        return {
            manager: {},
            MANAGER_ACTIVE: 0,
            MANAGER_HALTING: 1,
        };
    },
    created: function() {
        this.loadManager();
    },
    computed: {
        // 入力状況でsubmitができる
        form_all: function() {
            let required_fields = [
                this.manager.name,
                this.manager.email,
            ]
            return required_fields.indexOf('') === -1
        },
    },
    methods: {
        // 管理者情報のローディング
        loadManager: function() {
            this.manager = {name: '', email: '', password: '', authority: 1, memo: ''};
            axios.get(`/api/manager/managers/${this.id}`)
            .then(res => {
                this.manager = res.data.data;
                this.manager.isAdmin = 1 - this.manager.authority;
                console.log(this.manager);
            }).catch(error => {
                alert("Edit: " + error);
            });
        },

        // 管理者情報更新
        updateManager() {
            this.manager.authority = this.manager.isAdmin ? '0' : '1';
            axios.post(`/api/manager/managers/${this.id}/update`, this.manager)
            .then(res => {
                alert('保存成功');
                window.history.back();
            })
            .catch((err) => {
                alert("サーバーエラー" + err);
            });
        },

        // 管理者停止
        haltManager() {
            axios.post(`/api/manager/managers/${this.id}/halt`,)
            .then(res => {
                console.log(res);
                alert('停止成功');
            })
            .catch((err) => {
                alert("サーバーエラー" + err);
            });
        },

        // 管理者再開
        restoreManager() {
            axios.post(`/api/manager/managers/${this.id}/restore`,)
            .then(res => {
                console.log(res);
                alert('再開成功');
            })
            .catch((err) => {
                alert("サーバーエラー" + err);
            });
        },

        // 管理者削除
        deleteManager() {
            axios.delete(`/api/manager/managers/${this.id}`)
            .then(res => {
                console.log(res);
                alert('削除成功');
                window.history.back();
            })
            .catch((err) => {
                alert("サーバーエラー" + err);
            });
        },
    },
};
</script>
