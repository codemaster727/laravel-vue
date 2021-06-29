<template>
    <div class="l-login__wrap">
        <div class="l-login__title l-user__header">
            <div class="l-user__header__inner">
                <div class="l-user__header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1>新規現場作成</h1>
            </div>
        </div>
        <div class="l-form__area">
            <div class="c-checkbox--confirm">
                <label>
                    <input type="checkbox" @click="toggleWorkStatus">
                    <span class="color-navyGray">現場が未確定の場合はチェックしてください</span>
                </label>
            </div>
            <div
                class="l-hidden l-inputLabel u-inputBox"
                :class="{'open': !isUnavailableWork}"
            >
                <label>現場日程</label>
                <div class="c-input__supplement__wrap l-flex">
                    <div class="c-input__supplement__box">
                        <span>開始日</span>
                        <vuejs-datepicker
                            v-model="periodStartDate"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        />
                    </div>
                    <div class="c-input__supplement__box vue-right">
                        <span>終了日</span>
                        <vuejs-datepicker
                            v-model="periodFinishDate"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        />
                    </div>
                </div>
            </div>
            <div class="l-hidden l-inputLabel u-inputBox" :class="{'open': isUnavailableWork}">
                <label>仮押さえ日</label>
                <div class="c-input__supplement__wrap l-flex">
                    <div class="c-input__supplement__box">
                        <span>開始日</span>
                        <vuejs-datepicker
                            v-model="temporaryStartDate"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        />
                    </div>
                    <div class="c-input__supplement__box">
                        <span>終了日</span>
                        <vuejs-datepicker
                            v-model="temporaryFinishDate"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        />
                    </div>
                </div>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>現場名</label>
                <input
                    v-model="name"
                    class="c-input--white"
                    type="text"
                    placeholder="現場名を入力してください。"
                >
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>お客様名<span>（現場名ではありません）</span></label>
                <div class="c-selectBox" v-if="clientId">
                    <select
                        class="c-input--white"
                        v-model="clientId"
                    >
                        <option
                            v-for="client in clients"
                            :key="client.id"
                            :value="client.id"
                        >
                            {{ client.name }}
                        </option>
                    </select>
                </div>
                <div class="c-input--white" v-else style="padding: 12px 10px;">
                    <span class="u-color--red">お客様の新規追加を行ってください。</span>
                </div>
                <div class="textRight">
                    <a href="/user/client-register" class="c-sublink textLink">お客様の新規追加はコチラ</a>
                </div>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>営業担当名</label>
                <div class="c-selectBox" v-if="memberId">
                    <select
                        class="c-input--white"
                        v-model="memberId"
                    >
                        <option
                            v-for="member in members"
                            :key="member.id"
                            :value="member.id"
                        >
                            {{ member.name }}
                        </option>
                    </select>
                </div>
                <div class="c-input--white" v-else style="padding: 12px 10px;">
                    <span class="u-color--red">営業担当の新規追加を行ってください。</span>
                </div>
                <div class="textRight">
                    <a href="/user/member-register" class="c-sublink textLink">営業担当の新規追加はコチラ</a>
                </div>
            </div>
            <div class="l-button--submit">
                <button
                    class="c-button--yellowRounded"
                    type="button"
                    :disabled="!form_all"
                    :class="{'notSubmit':!form_all}"
                    @click="storeWork"
                >
                    作成する
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import vuejsDatepicker from 'vuejs-datepicker'
    import {ja} from 'vuejs-datepicker/dist/locale' // 日本語化

    export default {
        props: ['userid'],
        components: {
            'vuejs-datepicker':vuejsDatepicker,
        },
        data() {
            return {
                // datepicker
                DatePickerFormat: 'yyyy-MM-dd',
                // 新規仮設の現場未確定かどうか
                isUnavailableWork: false,
                // 日本語化
                ja:ja,
                // 現場入力フォーム
                periodStartDate: Date.now(),
                periodFinishDate: Date.now(),
                temporaryStartDate: Date.now(),
                temporaryFinishDate: Date.now(),
                name: '',
                memberId: '',
                clientId: '',
                members: [], // 担当者リスト
                clients: [], // お客様リスト
            }
        },
        created: function() {
            this.loadMembers();
            this.loadClients();
        },
        computed: {
            // 現場の必須項目を全て入力するとsubmitできる
            form_all: function() {
                let required_fields = [
                    this.name,
                    this.clientId,
                    this.memberId,
                ]
                if ((this.isUnavailableWork && this.temporaryStartDate && this.temporaryFinishDate) ||
                    (!this.isUnavailableWork && this.periodStartDate && this.periodFinishDate)) {
                    return required_fields.indexOf('') === -1;
                }
            },
        },
        methods: {
            // 担当者リストのローディング
            loadMembers: function() {
                this.members = [];
                axios
                    .get('/api/user/members/')
                    .then((response) => {
                        this.members = response.data.data;
                        if(this.members[0]) {
                            this.memberId = this.members[0]['id'];
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            },

            // お客様リストのローディング
            loadClients: function() {
                this.clients = [];
                axios.get('/api/clients/')
                    .then((response) => {
                        this.clients = response.data.data;
                        if(this.clients[0]) {
                            this.clientId = this.clients[0]['id'];
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            },

            toggleWorkStatus: function() {
                this.isUnavailableWork = !this.isUnavailableWork;
            },

            // 現場保存
            storeWork: function() {
                axios
                    .post('/api/works', {
                        user_id: this.userid,
                        status: this.isUnavailableWork ? 0 : 1,
                        name: this.name,
                        client_id: this.clientId,
                        member_id: this.memberId,
                        period_start_date: this.formatDate(this.periodStartDate),
                        period_finish_date: this.formatDate(this.periodFinishDate),
                        temporary_start_date: this.formatDate(this.temporaryStartDate),
                        temporary_finish_date: this.formatDate(this.temporaryFinishDate),
                    })
                    .then(res => {
                        window.history.back();
                    })
                    .catch(err => {
                        console.log("Insert: "+ err);
                    });
            },

            formatDate: function(date) {
                if (!date) return '';

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
        watch: {},
    }

</script>
