<template>
    <!-- 管理者一覧 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__table">
            <div class="l-owner--inner">
                <div class="l-owner--head">管理者一覧</div>
                <div class="l-owner--body">
                    <div class="l-owner--body__inner">
                        <div class="l-owner--body__search l-flex">
                            <div class="l-owner--body__search__left l-flex">
                                <div class="l-owner--body__search__left__content c-select--triangle">
                                    <select v-model="selectedStatus" @change="fetchManagers">
                                        <option selected value="">全ての状態</option>
                                        <option value="0">稼働中</option>
                                        <option value="1">停止中</option>
                                        <option value="2">削除済み</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__search__right">
                                <div class="l-owner--body__search__right__content l-flex">
                                    <div class="input-box"><input type="text" v-model="freeWord" name="" placeholder="キーワードを入力"></div>
                                    <div class="submit-box" @click.prevent.stop="fetchManagers"><input type="submit" name="" value="検索"></div>
                                </div>
                            </div>
                        </div>
                        <div class="l-owner--body__table">
                            <div class="l-owner--body__thead">
                                <div class="l-owner--body__tr">
                                    <div class="l-owner--body__tr__inner l-flex">
                                        <div class="l-owner--body__td u-w100">管理者名</div>
                                        <div class="l-owner--body__td u-w150">メールアドレス</div>
                                        <div class="l-owner--body__td u-w50">権限</div>
                                        <div class="l-owner--body__td u-wflex1">社内メモ</div>
                                        <div class="l-owner--body__td u-w160 l-flex"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="l-owner--body__tbody">
                                <div class="l-owner--body__tr" v-for="(manager, index) in managers" v-bind:key="index">
                                    <div class="l-owner--body__tr__inner l-flex">
                                        <div class="l-owner--body__td u-w100">
                                            <a :href="`/manager/manager/edit/${manager.id}`" class="u-color--blue">{{ manager.name }}</a>
                                        </div>
                                        <div class="l-owner--body__td u-w150" style="overflow-wrap: anywhere;">
                                            {{ manager.email }}
                                        </div>
                                        <div class="l-owner--body__td u-w50">
                                            {{ manager.authority == 1 ? '代理店' : '管理者' }}
                                        </div>
                                        <div class="l-owner--body__td u-wflex1">
                                            <textarea v-model="manager.memo" @blur="updateMemo(manager)"></textarea>
                                        </div>
                                        <div class="l-owner--body__td u-w160 l-flex">
                                            <div class="td-button">
                                                <a :href="`/manager/manager/edit/${manager.id}`" class="edit">編集</a>
                                            </div>
                                            <div v-if="manager.status == MANAGER_ACTIVE" class="td-button" @click.prevent.stop="haltManager(manager, index)"><a class="stop">停止</a></div>
                                            <div v-if="manager.status == MANAGER_HALTING" class="td-button" @click.prevent.stop="restoreManager(manager, index)"><a class="start">再開</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        name: "ManagerManager",
        data() {
            return {
                managers: [],
                status: [0, 1],
                isDeleted: null,
                freeWord: '',
                selectedStatus: '',
                MANAGER_ACTIVE: 0,
                MANAGER_HALTING: 1,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.fetchManagers();
        },
        methods: {
            // 管理者一覧を取得
            fetchManagers: function() {
                this.calcParams();
                const params = {
                    status: this.status,
                    is_deleted: this.isDeleted,
                    free_word: this.freeWord
                };
                axios.get('/api/manager/managers', {params})
                .then(result => {
                    this.managers = result.data;
                })
                .catch(error => {
                    alert('管理者一覧取得エラー');
                });
            },
            // 選択肢に応じて、管理者のステータス・削除済みフラグをセット
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
            updateMemo: function(m) {
                console.log(m);
                axios.put('/api/manager/managers/' + m.id, m)
                .then(result => {
                    console.log(result);
                })
                .catch(error => {
                    alert('管理者備考更新エラー');
                });
            },
            // アカウントを停止する
            haltManager: function(m, index) {
                if (confirm('管理者を停止します。よろしいですか？')) {
                    axios.post('/api/manager/managers/' + m.id + '/halt')
                    .then(result => {
                        // this.managers[index].status = this.MANAGER_HALTING;
                        m.status = this.MANAGER_HALTING;
                        alert('管理者を停止しました。');
                    })
                    .catch(error => {
                        alert('管理者停止処理エラー');
                    });
                }
            },
            // アカウントを再開する
            restoreManager: function(m, index) {
                if (confirm('管理者を再開します。よろしいですか？')) {
                    axios.post('/api/manager/managers/' + m.id + '/restore')
                    .then(result => {
                        // this.managers[index].status = this.MANAGER_ACTIVE;
                        m.status = this.MANAGER_ACTIVE;
                        alert('管理者を再開しました。');
                    })
                    .catch(error => {
                        alert('管理者再開処理エラー');
                    });
                }
            },

        },
    };
</script>
