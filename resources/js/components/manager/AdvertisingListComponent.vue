<template>
    <!-- 広告出稿一覧 -->
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__table">
            <div class="l-owner--inner">
                <div class="l-owner--head">広告出稿一覧</div>
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
                                    <select v-model="selectedStatus">
                                        <option value="0">出稿中</option>
                                        <option value="1">停止中</option>
                                        <option value="2">削除済み</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__search__right">
                                <div class="l-owner--body__search__right__content l-flex">
                                    <div class="input-box"><input type="text"  name="" v-model="freeWord" placeholder="検索キーワードを入力"></div>
                                    <div class="submit-box" @click.prevent.stop="fetchAdvertisings"><input type="submit" name="" value="検索"></div>
                                </div>
                            </div>
                        </div>
                        <div class="l-owner--body__table">
                            <div class="l-owner--body__thead">
                                <div class="l-owner--body__tr">
                                    <div class="l-owner--body__tr__inner l-flex">
                                        <div class="l-owner--body__td u-w100">会社名</div>
                                        <div class="l-owner--body__td u-w150">URL<br>電話番号</div>
                                        <div class="l-owner--body__td u-w150">メールアドレス<br>会社名</div>
                                        <div class="l-owner--body__td u-w150">郵便番号<br>住所</div>
                                        <div class="l-owner--body__td u-wflex1">広告出稿履歴<br>（回数 / 金額 / 開始日 / 終了日）</div>
                                    </div>
                                </div>
                            </div>
                            <div class="l-owner--body__tbody">
                                <template v-for="(advertising, idx1) in advertisings">
                                <div class="l-owner--body__tr" v-bind:key="idx1">
                                    <div class="l-owner--body__tr__inner l-flex">
                                        <div class="l-owner--body__td u-w100"><a :href="`/manager/advertising/edit/` + advertising.id" class="u-color--blue">{{ advertising.company }}</a></div>
                                        <div class="l-owner--body__td u-w150">{{ advertising.url }}<br>{{ advertising.phone }}</div>
                                        <div class="l-owner--body__td u-w150">{{ advertising.email }}<br>{{ advertising.company }}</div>
                                        <div class="l-owner--body__td u-w150">{{ advertising.zip }}<br>{{ advertising.address }}</div>
                                        <div class="l-owner--body__td u-wflex1">
                                            <table class="add-history">
                                                <template v-for="(term, idx2) in advertising.advertising_terms">
                                                <tr v-bind:key="idx2">
                                                    <th>{{ idx2 + 1 }}回目</th>
                                                    <td>¥{{term.price_amount | addComma }}</td>
                                                    <td>{{ term.started_at }}</td>
                                                    <td>{{ term.ended_at }}</td>
                                                </tr>
                                                </template>
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
                advertisings: [],
                managers: [],
                status: [0, 1],
                managerId: '',
                // is_deleted: null,
                freeWord: '',
                selectedStatus: '0',
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.fetchAdvertisings();
            this.fetchManagers();
        },
        computed: {
        },
        methods: {
            // 広告会社一覧を取得
            fetchAdvertisings: function() {
                this.calcParams();
                let params = {
                    status: this.status,
                    manager_id: this.managerId,
                    // is_deleted: this.is_deleted,
                    free_word: this.freeWord
                };
                axios.get('/api/manager/advertisings', {params})
                .then(result => {
                    this.advertisings = result.data.data;
                    console.log(this.advertisings);
                })
                .catch(error => {
                    alert('広告会社一覧取得エラー');
                });
            },
            // 管理者一覧を取得
            fetchManagers: function() {
                axios.get('/api/manager/managers', {})
                .then(result => {
                    this.managers = result.data.data;
                    console.log(this.managers);
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
                        // this.is_deleted = '0';
                        break;
                    case '0':
                        this.status = [0];
                        // this.is_deleted = '0';
                        break;
                    case '1':
                        this.status = [1];
                        // this.is_deleted = '0';
                        break;
                    case '2':
                        this.status = [0, 1];
                        // this.is_deleted = '1';
                        break;
                }
            }

        },
        watch: {},
        filters: {
            addComma: function (value) {
                return value.toLocaleString();
            }
        }
	}
</script>
