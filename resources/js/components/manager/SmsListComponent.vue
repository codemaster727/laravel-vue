<template>
    <!-- SMS利用状況 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__table">
            <div class="l-owner--inner">
                <div class="l-owner--head">SMS利用状況</div>
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
                                        <option value="">全ての状態</option>
                                        <option value="0">稼働中</option>
                                        <option value="1">停止中</option>
                                        <option value="2">削除済み</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__search__right">
                                <div class="l-owner--body__search__right__content l-flex">
                                    <div class="input-box"><input type="text" v-model="freeWord" name="" placeholder="検索キーワードを入力"></div>
                                    <div class="submit-box" @click.prevent.stop="fetchUsers"><input type="submit" name="" value="検索"></div>
                                </div>
                            </div>
                        </div>
                        <div class="l-owner--body__table">
                            <div class="l-owner--body__thead">
                                <div class="l-owner--body__tr">
                                    <div class="l-owner--body__tr__inner l-flex">
                                        <div class="l-owner--body__td u-w150">会社名</div>
                                        <div class="l-owner--body__td u-w150">メールアドレス<br>電話番号</div>
                                        <div class="l-owner--body__td u-wflex1">
                                            SMS利用状況
                                            <table class="u-w100per">
                                                <tr>
                                                    <template v-for="month in months">
                                                    <td class="u-wflex1">{{ month }}月</td>
                                                    </template>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="l-owner--body__tbody">
                                <template v-for="(user, index) in users">
                                <div class="l-owner--body__tr">
                                    <div class="l-owner--body__tr__inner l-flex">
                                        <div class="l-owner--body__td u-w150"><a :href="'/manager/user/edit/' + user.id" class="u-color--blue">{{ user.company }}</a></div>
                                        <div class="l-owner--body__td u-w150">{{ user.email }}<br>{{ user.tel }}</div>
                                        <div class="l-owner--body__td u-wflex1">
                                            <table class="u-w100per">
                                                <tr>
                                                    <template v-for="short_message in user.short_messages">
                                                    <td class="u-wflex1">¥{{ short_message.price | addComma }}/{{ short_message.count }}回</td>
                                                    </template>
                                                </tr>
                                            </table>
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
                months: []
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.createMonths();
            this.fetchUsers();
            this.fetchManagers();
        },
        computed: {
        },
        methods: {
            // 表示する月を生成
            createMonths: function() {
                let now = new Date();
                for (let i = 0; i < 4; i++) {
                    this.months.push(now.getMonth() + 1 - i);
                }
            },
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
        },
        watch: {},
        filters: {
            addComma: function (value) {
                return value.toLocaleString();
            }
        }
	}
</script>
