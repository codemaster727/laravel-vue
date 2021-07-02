<template>
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__table">
            <div class="l-owner--inner">
                <div class="l-owner--head">ユーザー一覧</div>
                <div class="l-owner--body">
                    <div class="l-owner--body__inner">
                        <div class="l-owner--body__search l-flex">
                            <div class="l-owner--body__search__left l-flex">
                                <div class="l-owner--body__search__left__content c-select--triangle">
                                    <select v-model="managerId">
                                        <option value="">全ての代理店</option>
                                        <template v-for="manager in managers">
                                            <option :value="manager.id">{{ manager.name }}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="l-owner--body__search__left__content c-select--triangle">
                                    <select v-model="selectedStatus" @change="calcParams">
                                        <option selected value="">全ての状態</option>
                                        <option value="0">稼働中</option>
                                        <option value="1">停止中</option>
                                        <option value="2">削除済み</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__search__right">
                                <div class="l-owner--body__search__right__content l-flex">
                                    <div class="input-box">
                                        <input type="text" v-model="freeWord" name="" placeholder="キーワードを入力してください">
                                    </div>
                                    <div class="submit-box" @click.prevent.stop="fetchUsers"><input type="submit" name="" value="検索"></div>
                                </div>
                            </div>
                        </div>
                        <div class="l-owner--body__table">
                            <div class="l-owner--body__thead">
                                <div class="l-owner--body__tr">
                                    <div class="l-owner--body__tr__inner l-flex">
                                        <div class="l-owner--body__td u-w100">会社名</div>
                                        <div class="l-owner--body__td u-w150">メールアドレス<br>電話番号</div>
                                        <div class="l-owner--body__td u-w100">契約情報<br>契約金額</div>
                                        <div class="l-owner--body__td u-wflex1">社内メモ</div>
                                        <div class="l-owner--body__td u-w160 l-flex"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="l-owner--body__tbody">
                                <!-- 各一覧の値を割りあてる（dataのusersの値） -->
                                <template v-for="(user, index) in users">
                                    <div class="l-owner--body__tr" v-bind:key="index">
                                        <div class="l-owner--body__tr__inner l-flex">
                                            <div class="l-owner--body__td u-w100"><a href="/manager/user/edit" class="u-color--blue">{{ user.company }}</a></div>
                                            <div class="l-owner--body__td u-w150">{{ user.email }}<br>{{ user.tel }}</div>
                                            <div class="l-owner--body__td u-w100">{{ user.manager.name }}<br>￥{{ user.price_amount | addComma }}</div>
                                            <div class="l-owner--body__td u-wflex1">
                                                <textarea v-model="user.manager_remark" @blur="updateManagerRemarks(user.id, index)"></textarea>
                                            </div>
                                            <div class="l-owner--body__td u-w160 l-flex">
                                                <div class="td-button"><a :href="'/manager/user/edit/'+user.id" class="edit">編集</a></div>
                                                <div v-if="user.status === USER_ACTIVE" class="td-button" @click.prevent.stop="haltUser(user.id, index)"><a href="" class="stop">停止</a></div>
                                                <div  v-if="user.status === USER_HALTING" class="td-button" @click.prevent.stop="restoreUser(user.id,  index)"><a href="" class="start">再開</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        data() {
            return {
                users: [],
                managers: [],
                status: [0, 1],
                managerId: '',
                isDeleted: null,
                freeWord: '',
                selectedStatus: '',
                USER_ACTIVE: 0,
                USER_HALTING: 1,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.fetchUsers();
            this.fetchManagers();
        },
        computed: {
        },
        methods: {
            // ユーザー一覧を取得
            fetchUsers: function() {
                this.calcParams();
                const params = {
                    status: this.status,
                    manager_id: this.managerId,
                    is_deleted: this.isDeleted,
                    free_word: this.freeWord
                };
                axios.get('/api/manager/users', {params})
                    .then(result => {
                        this.users = result.data.data;
                    })
                    .catch(error => {
                        alert('ユーザー一覧取得エラー');
                    });
            },
            // 管理者一覧を取得
            fetchManagers: function() {
                axios.get('/api/manager/managers', {})
                    .then(result => {
                        this.managers = result.data.data;
                    })
                    .catch(error => {
                        alert('管理者一覧取得エラー');
                    });
            },
            // 選択肢に応じて、ユーザーのステータス・削除済みフラグをセット
            calcParams: function() {
                switch(this.selectedStatus) {
                    case '':
                        this.status = [0, 1];
                        this.isDeleted = '0';
                        break;
                    case '0':
                        this.status = [0];
                        this.isDeleted = '0';
                        break;
                    case '1':
                        this.status = [1];
                        this.isDeleted = '0';
                        break;
                    case '2':
                        this.status = [0, 1];
                        this.isDeleted = '1';
                        break;
                }
            },
            // 管理者備考を更新する
            updateManagerRemarks: function(userId, index) {
                const params = {
                    manager_remark: this.users[index].manager_remark
                };
                axios.put('/api/manager/users/' + userId, params)
                    .then(result => {
                    })
                    .catch(error => {
                        alert('ユーザー管理者備考更新エラー');
                    });
            },
            // アカウントを停止する
            haltUser: function(userId, index) {
                if (confirm('ユーザーのアカウントを停止します。よろしいですか？')) {
                    axios.post('/api/manager/users/' + userId + '/halt', {})
                        .then(result => {
                            alert('ユーザーのアカウントを停止しました。');
                            this.users[index].status = this.USER_HALTING;
                        })
                        .catch(error => {
                            alert('ユーザー停止処理エラー');
                        });
                }
            },
            // アカウントを再開する
            restoreUser: function(userId, index) {
                if (confirm('ユーザーのアカウントを再開します。よろしいですか？')) {
                    axios.post('/api/manager/users/' + userId + '/restore', {})
                        .then(result => {
                            alert('ユーザーのアカウントを再開しました。');
                            this.users[index].status = this.USER_ACTIVE;
                        })
                        .catch(error => {
                            alert('ユーザー再開処理エラー');
                        });
                }
            },

        },
        watch: {},
        filters: {
            addComma: function (value) {
                return value.toLocaleString();
            }
        }
	}
</script>
