<template>
    <div class="l-owner--wrap">
        <div class="l-owner--wrap__table">
            <div class="l-owner--inner">
                <div class="l-owner--head">職人一覧</div>
                <div class="l-owner--body">
                    <div class="l-owner--body__inner">
                        <div class="l-owner--body__search l-flex">
                            <div class="l-owner--body__search__left l-flex">
                                <div class="l-owner--body__search__left__content c-select--triangle">
                                    <select v-model="selectedStatus" @change="fetchWorkers">
                                        <option selected value="">全ての状態</option>
                                        <option value="0">稼働中</option>
                                        <option value="1">停止中</option>
                                        <option value="2">削除済み</option>
                                    </select>
                                </div>
                            </div>
                            <div class="l-owner--body__search__right">
                                <div
                                    class="l-owner--body__search__right__content l-flex"
                                >
                                    <div class="input-box"><input type="text" v-model="freeWord" name="" placeholder="キーワードを入力してください"></div>
                                    <div class="submit-box" @click.prevent.stop="fetchWorkers"><input type="submit" name="" value="検索"></div>
                                </div>
                            </div>
                        </div>
                        <div class="l-owner--body__table">
                            <div class="l-owner--body__thead">
                                <div class="l-owner--body__tr">
                                    <div class="l-owner--body__tr__inner l-flex">
                                        <div class="l-owner--body__td u-w150">名前</div>
                                        <div class="l-owner--body__td u-w100">ID</div>
                                        <div class="l-owner--body__td u-w150">メールアドレス</div>
                                        <div class="l-owner--body__td u-wflex1">社内メモ</div>
                                        <div class="l-owner--body__td u-w160"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="l-owner--body__tbody">
                                <template v-for="(worker, index) in workers">
                                    <div class="l-owner--body__tr" v-bind:key="index">
                                        <div class="l-owner--body__tr__inner l-flex">
                                            <div class="l-owner--body__td u-w150">
                                                <a href="/manager/worker/edit">{{ worker.name }}</a>
                                            </div>
                                            <div class="l-owner--body__td u-w100">
                                                {{ worker.id }}
                                            </div>
                                            <div class="l-owner--body__td u-w150">
                                                {{ worker.email }}
                                            </div>
                                            <div class="l-owner--body__td u-wflex1">
                                                <textarea v-model="worker.manager_remark" @blur="updateManagerRemarks(worker.id, index)"></textarea>
                                            </div>
                                            <div class="l-owner--body__td u-w160 l-flex">
                                                <div class="td-button"><a :href="'/manager/worker/edit/'+worker.id" class="edit">編集</a></div>
                                                <div v-if="worker.status === WORKER_ACTIVE" class="td-button" @click.prevent.stop="haltWorker(worker.id, index)">
                                                    <a href="" class="stop">停止</a>
                                                </div>
                                                <div v-if="worker.status === WORKER_HALTING" class="td-button" @click.prevent.stop="restoreWorker(worker.id,  index)">
                                                    <a href="" class="start">再開</a>
                                                </div>
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
    import { mapGetters } from "vuex";

    export default {
        data() {
            return {
                workers: [],
                status: [0, 1],
                isDeleted: null,
                freeWord: '',
                selectedStatus: '',
                WORKER_ACTIVE: 0,
                WORKER_HALTING: 1,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.fetchWorkers();
        },
        computed: {
        },
        methods: {
            // ワーカー一覧を取得
            fetchWorkers: function() {
                this.calcParams();
                const params = {
                    status: this.status,
                    is_deleted: this.isDeleted,
                    free_word: this.freeWord
                };
                axios.get('/api/manager/workers', {params})
                .then(result => {
                    this.workers = result.data.data;
                    console.log(this.workers);
                })
                .catch(error => {
                    alert('ワーカー一覧取得エラー');
                });
            },
            // 選択肢に応じて、ワーカーのステータス・削除済みフラグをセット
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
            updateManagerRemarks: function(workerId, index) {
                const params = this.workers[index];
                axios.put('/api/manager/workers/' + workerId, params)
                .then(result => {
                })
                .catch(error => {
                    alert('ワーカー管理者備考更新エラー');
                });
            },
            // アカウントを停止する
            haltWorker: function(workerId, index) {
                if (confirm('ワーカーのアカウントを停止します。よろしいですか？')) {
                    axios.post('/api/manager/workers/' + workerId + '/halt', {})
                    .then(result => {
                        alert('ワーカーのアカウントを停止しました。');
                        this.workers[index].status = this.WORKER_HALTING;
                    })
                    .catch(error => {
                        alert('ワーカー停止処理エラー');
                    });
                }
            },
            // アカウントを再開する
            restoreWorker: function(workerId, index) {
                if (confirm('ワーカーのアカウントを再開します。よろしいですか？')) {
                    axios.post('/api/manager/workers/' + workerId + '/restore', {})
                    .then(result => {
                        alert('ワーカーのアカウントを再開しました。');
                        this.workers[index].status = this.WORKER_ACTIVE;
                    })
                    .catch(error => {
                        alert('ワーカー再開処理エラー');
                    });
                }
            },
        },
	}
</script>
