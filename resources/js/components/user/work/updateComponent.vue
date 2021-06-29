<template>
    <div class="l-login__wrap">
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>現場の更新に成功しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasError">
            <p>現場の更新に失敗しました。</p>
        </div>
        <div class="l-login__title l-user__header">
            <div class="l-user__header__inner">
                <div class="l-user__header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1>現場を編集</h1>
            </div>
        </div>
        <!-- Cannot read property '~~~~' of undefined 対策でv-if="work"を設定 -->
        <div v-if="work" class="l-form__area">
            <!-- case1：現場のステータスが未確定の場合 -->
            <div class="l-inputLabel u-inputBox">
                <label>{{ work.status == 0 ? '仮押さえ日' : '現場日程' }}</label>
                <div class="c-input__supplement__wrap l-flex">
                    <div class="c-input__supplement__box">
                        <span>開始日</span>
                        <vuejs-datepicker
                            v-if="work.status == 0"
                            v-model="work.temporary_start_date"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        >
                        </vuejs-datepicker>
                        <vuejs-datepicker
                            v-if="work.status > 0"
                            v-model="work.period_start_date"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        >
                        </vuejs-datepicker>
                    </div>
                    <div class="c-input__supplement__box">
                        <span>終了日</span>
                        <vuejs-datepicker
                            v-if="work.status == 0"
                            v-model="work.temporary_finish_date"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        >
                        </vuejs-datepicker>
                        <vuejs-datepicker
                            v-if="work.status > 0"
                            v-model="work.period_finish_date"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        >
                        </vuejs-datepicker>
                    </div>
                </div>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>現場名</label>
                <input v-model="work.name" class="c-input--white" type="text" name="" placeholder="現場名を入力してください。">
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>郵便番号</label>
                <input v-model="postal1" class="c-input--white c-input--post__one u-mr10" type="" name="" placeholder="000">
                <input v-model="postal2" class="c-input--white c-input--post__two" type="" name="" placeholder="0000">
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>住所</label>
                <input v-model="work.address" class="c-input--white" type="text" name="" placeholder="住所を入力してください。">
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>お客様名<span>（現場名ではありません）</span></label>
                <div class="c-selectBox">
                    <select class="c-input--white" v-model="work.client_id">
                        <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
                    </select>
                </div>
                <div class="textRight">
                    <a href="/user/menu/client-register" class="c-sublink textLink">お客様の新規追加はコチラ</a>
                </div>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>営業担当名</label>
                <div class="c-selectBox">
                    <select class="c-input--white" v-model="work.member_id">
                        <option v-for="member in members" :key="member.id" :value="member.id">{{ member.name }}</option>
                    </select>
                </div>
                <div class="textRight">
                    <a href="/user/menu/member-register" class="c-sublink textLink">営業担当の新規追加はコチラ</a>
                </div>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>職人</label>
                <div class="c-add--block u-mt3" v-for="(area, index) in workerArea" :key="index">
                    <!-- <select class="c-input--white" v-model="work.worker_id">
                        <option v-for="worker in workers" :key="worker.id" :value="worker.id">{{ worker.name }}</option>
                    </select> -->
                    <select class="c-input--white" v-model="area.worker_id">
                        <option v-for="worker in workers" :key="worker.id" :value="worker.id">{{ worker.name }}</option>
                    </select>
                    <span
                        @click.prevent="deleteWorker(index)"
                        :class="{ 'is-hidden': !workerArea[index].idDel }"
                    >
                        <img src="/img/icon-minus.png">
                    </span>
                </div>
                <!-- <div class="c-add--block u-mt3" v-for="(work, index) in workers" :key="index">
                    <input class="c-input--white" type="text" v-model="workers[index].val" placeholder="職人名を入力してください。">
                    <span @click.prevent="deleteWorker(index)" :class="{ 'is-hidden': !workers[index].idDel }"><img src="/img/icon-minus.png"></span>
                </div> -->
                <div class="l-main__body__add">
                    <a
                        class="c-button--addGreen"
                        @click.prevent="addWorker"
                    >
                        職人を追加する
                    </a>
                </div>
            </div>
            <div class="l-button--submit">
                <!-- <input class="c-button--yellowRounded" type="submit" name="" value="変更内容を登録する" :disabled="!form_all" :class="{'notSubmit':!form_all}" @click="updateWork"> -->
                <button
                    class="c-button--yellowRounded"
                    type="button"
                    :disabled="!form_all"
                    :class="{'notSubmit':!form_all}"
                    @click="updateWork"
                >
                    変更内容を登録する
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import vuejsDatepicker from 'vuejs-datepicker'
    import {ja} from 'vuejs-datepicker/dist/locale' // 日本語化

    export default {
        props: ['id'],
        components: {
            'vuejs-datepicker':vuejsDatepicker,
        },
        data() {
            return {
                DatePickerFormat: 'yyyy-MM-dd', // datepicker
                ja:ja, // 日本語化
                // 入力フォーム
                postal1: '',
                postal2: '',
                workerArea: [],
                work: undefined,
                // 配列
                clients: '',
                members: '',
                workers: [],
                workerId: '',
                // バリデーション
                hasSuccess: false,
                hasError: false,
            }
        },
        created: function() {
            // ローディングの初期設定
            this.loadWorkDetail();
            this.loadMembers();
            this.loadClients();
            this.loadWorkers();
            this.loadChargeWorkers();
        },
        computed: {
            // 入力状況でsubmitができる
            form_all: function() {
                let required_fields = [
                    this.work.name,
                    // this.postal1,
                    // this.postal2,
                    // this.work.address,
                    this.work.client_id,
                    this.work.member_id,
                ]
                if (this.work.status == 0) {
                    required_fields.push(this.work.temporary_start_date, this.work.temporary_finish_date);
                } else {
                    required_fields.push(this.work.period_start_date, this.work.period_finish_date);
                }
                return required_fields.indexOf('') === -1
            },
        },
        methods: {
            /**
             * ローディング
             */
            // 現場詳細のローディング
            loadWorkDetail: function() {
                this.process = undefined;
                axios.get(`/api/works/${this.id}`)
                .then(
                    (response) => {
                        this.work = response.data.data;
                        _.sortBy(this.work.history, function(x) {
                            return x.work_dateSort;
                        });
                        this.work.history = _.groupBy(this.work.history, 'work_date');

                        if (this.work.postal && this.work.postal.length > 3) {
                            this.postal1 = this.work.postal.substring(0, 3);
                            this.postal2 = this.work.postal.substring(4);
                        }
                        this.work.member_id = this.work.member.id;
                        this.work.client_id = this.work.client.id;
                    }
                );
            },

            // 担当者リストのローディング
            loadMembers: function() {
                this.members = [];
                axios.get('/api/user/members/')
                    .then((response) => {
                        this.members = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error)
                        alert('担当者のローディングに失敗しました。')
                    })
            },

            // お客様リストのローディング
            loadClients: function() {
                this.clients = [];
                axios.get('/api/clients/')
                    .then((response) => {
                        this.clients = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error)
                        alert('お客様のローディングに失敗しました。')
                    })
            },

            // 職人のローディング
            loadWorkers: function() {
                this.workers = [];
                axios.get('/api/user/charge-users/')
                    .then((response) => {
                        this.workers = response.data;
                        this.workerId = this.workers[0]['id'];
                    })
                    .catch((error) => {
                        console.log(error)
                        alert('職人のローディングに失敗しました。')
                    })
            },

            // 案件担当者のローディング
            loadChargeWorkers: function() {
                this.workerArea = [];
                axios
                    .get(`/api/user/charge-workers/${this.id}`)
                    .then((response) => {
                        let elements = response.data
                        let elementArea = []
                        elements.forEach(function(element, index) {
                            // elementArea[index].push({
                            //     worker_id: element['worker_id'],
                            //     idDel: true
                            // });
                            elementArea[index] = {
                                worker_id: element['worker_id'],
                                idDel: true
                            }
                        })
                        this.workerArea = elementArea
                    })
                    .catch((error) => {
                        console.log(error)
                        alert('案件担当者のローディングに失敗しました。')
                    })
            },

            // 工程変更
            updateWork: function() {
                this.hasSuccess = false
                this.hasError = false
                // １．パラメーターを設定
                let params = {
                    name: this.work.name,
                    temporary_start_date: this.formatDate(this.work.temporary_start_date),
                    temporary_finish_date: this.formatDate(this.work.temporary_finish_date),
                    period_start_date: this.formatDate(this.work.period_start_date),
                    period_finish_date: this.formatDate(this.work.period_finish_date),
                    postal: this.work.postal,
                    address: this.work.address,
                    client_id: this.work.client_id,
                    member_id: this.work.member_id,
                    remark: this.work.remark,
                    memo: this.work.memo,
                    status: this.work.status,
                    workers: this.workerArea,
                }

                // １．職人情報を追加
                // 現場を更新
                axios.put(`/api/works/${this.id}`, params)
                    .then(response => {
                        console.log(response)
                        this.hasSuccess = true
                        let workId = this.work.id
                        setTimeout(function() {
                            document.location.href = `/user/work/detail/${workId}`
                        }, 1000);
                    })
                    .catch(error => {
                        console.log(error)
                        this.hasError = true
                    });

            },

            // 職人追加
            addWorker: function() {
                this.workerArea.push({
                    worker_id: this.workerId,
                    idDel: true,
                });
            },
            // 職人削除
            deleteWorker: function(index) {
                this.workerArea.splice(index, 1);
            },

            formatDate: function(date) {
                if (!date) return '';

                if (typeof(date) == 'String') return date.substring(0, 10);

                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }
        },
        watch: {
            postal1: function (val) {
                this.work.postal = val + this.postal2
            },
            postal2: function (val) {
                this.work.postal = this.postal1 + val
            }
        },
    }
</script>



