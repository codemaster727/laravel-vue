<template>
    <!-- ユーザー詳細 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__detail">
            <div class="l-owner--inner">
                <div class="l-owner--head">ユーザー詳細</div>
                <div class="l-owner--tab">
                    <ul class="l-owner--tab__list two-tab l-flex">
                        <li :class="{'stop': user.status==USER_ACTIVE, 'start': user.status==USER_HALTING}">
                            <a v-if="user.status==USER_ACTIVE" @click="haltUser">停止</a>
                            <a v-if="user.status==USER_HALTING" @click="restoreUser">再開</a>
                        </li>
                        <li class="delete"><a @click="deleteUser">削除</a></li>
                    </ul>
                </div>
                <div class="l-owner--body">
                    <div class="l-owner--body__inner">
                        <div class="l-owner--body__input">
                            <div class="l-owner--body__input__content">
                                <label>契約管理者名</label>
                                <div class="c-select--triangle">
                                    <select class="c-input--white" v-model="user.manager_id">
                                        <option v-for="manager in managers" v-bind:key="manager.id" v-bind:value="manager.id">{{ manager.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>契約金額</label>
                                <div class="c-select--triangle">
                                    <select>
                                        <option selected disabled>選択してください</option>
                                        <option v-for="price in prices" v-bind:key="price" v-bind:value="price">¥ {{ price }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>メールアドレス</label>
                                <input type="" name="" v-model="user.email"/>
                            </div>
                            <div class="l-owner--body__input__content">
                                <label
                                    >パスワード
                                    <span
                                        class="u-color--gray u-textSize--small"
                                        >（新しいパスワードを入力してください）</span
                                    ></label
                                >
                                <input type="password" name="" v-model="user.password">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>会社名</label>
                                <input type="" name="" v-model="user.company">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>電話番号</label>
                                <input type="" name="" v-model="user.tel">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>住所</label>
                                <input type="" name="" v-model="user.address">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>郵便番号</label>
                                <input type="" name="" class="c-input--post__one" v-model="postal1">
                                <input type="" name="" class="c-input--post__two" v-model="postal2">
                            </div>
                            <div class="l-owner--body__input__content">
                                <label>社内メモ</label>
                                <textarea v-model="user.manager_remark"></textarea>
                            </div>
                        </div>
                        <div class="l-owner--body__submit">
                            <input type="submit" name="" value="変更内容を保存する" class="c-button--blueRounded"
                                @click="updateUser" :disabled="!form_all" :class="{'notSubmit':!form_all}">
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
        name: "ManagerUserUpdate",
        data() {
            return {
                user: {},
                managers: [],
                postal1: '',
                postal2: '',
                prices: [5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000],
                USER_ACTIVE: 0,
                USER_HALTING: 1,
            };
        },
        created: function() {
            this.loadUser();
            this.fetchManagers();
        },
        computed: {
            // 入力状況でsubmitができる
            form_all: function() {
                let required_fields = [
                    this.user.manager_id,
                    this.user.email,
                    this.user.company,
                ]
                return required_fields.indexOf('') === -1
            },
        },
        methods: {
            // 管理者一覧を取得
            fetchManagers: function() {
                this.managers = [];
                axios.get('/api/manager/managers', { is_deleted: '0' })
                .then(result => {
                    this.managers = result.data;
                    console.log(this.managers);
                })
                .catch(error => {
                    alert('管理者一覧取得エラー');
                });
            },

            // ユーザー情報のローディング
            loadUser: function() {
                this.user = {};
                axios.get(`/api/manager/users/${this.id}`)
                .then(res => {
                    this.user = res.data.data;
                    if (this.user.postal && this.user.postal.length > 3) {
                        this.postal1 = this.user.postal.substring(0, 3);
                        this.postal2 = this.user.postal.substring(3);
                    }
                    console.log(this.user);
                }).catch(error => {
                    alert("Edit: " + error);
                });
            },

            // ユーザー情報更新
            updateUser() {
                axios.put(`/api/manager/users/${this.id}`, this.user)
                .then(res => {
                    alert('保存成功');
                    window.history.back();
                })
                .catch((err) => {
                    alert("サーバーエラー" + err);
                });
            },

            // ユーザー停止
            haltUser() {
                axios.post(`/api/manager/users/${this.id}/halt`,)
                .then(res => {
                    this.user.status = 1;
                    alert('停止成功');
                })
                .catch((err) => {
                    alert("サーバーエラー" + err);
                });
            },

            // ユーザー再開
            restoreUser() {
                axios.post(`/api/manager/users/${this.id}/restore`,)
                .then(res => {
                    this.user.status = 0;
                    alert('再開成功');
                })
                .catch((err) => {
                    alert("サーバーエラー" + err);
                });
            },

            // ユーザー削除
            deleteUser() {
                axios.delete(`/api/manager/users/${this.id}`)
                .then(res => {
                    alert('削除成功');
                    window.history.back();
                })
                .catch((err) => {
                    alert("サーバーエラー" + err);
                });
            },
        },
        watch: {
            postal1: function (val) {
                this.user.postal = val + this.postal2;
            },
            postal2: function (val) {
                this.user.postal = this.postal1 + val;
            }
        },
    };
</script>
