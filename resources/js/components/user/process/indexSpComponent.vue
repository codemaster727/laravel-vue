<template>
    <main>
        <div class="l-wrap l-wrap--table">
            <div class="l-wrap--inner">
                <div class="l-wrap--header">
                    <div class="l-wrap--header__inner">
                        <h1 class="l-wrap--header__title">カレンダー</h1>
                        <div class="l-wrap--header__inner__sub">

                            <ul class="l-wrap--header__inner__list pc-only">
                                <li class="select-charge">
                                    <div class="c-select--triangle">
                                        <select class="" v-model="selectedMember" v-on:change="loadProcesses">
                                            <option value="0">全ての担当</option>
                                            <template v-for="(member, index) in members">
                                                <option :value="member.index">{{ member.name }}</option>
                                            </template>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                            <ul class="l-wrap--header__inner__list sp-only">
                                <li class="icon">
                                    <a href="/user/work/new">
                                        <img src="/img/icon-add-black.png">
                                        <span>現場作成</span>
                                    </a>
                                </li>
                                <li class="icon">
                                    <a @click.prevent="toggleSearchActive">
                                        <img src="/img/icon-search-black.png">
                                        <span>検索</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="l-wrap--calendar">
                    <div class="l-wrap--calendar__inner">
                        <ul class="l-wrap--calendar__scroll" id="dates">
                            <!-- 1ヶ月前の1日〜6ヶ月後の末日まで表示。 -->
                            <template v-for="(date, index) in dates">
                                <li type="date" :class="{'today': date.date == selectedDate}" @click="setDate(date.date)">
                                    {{ date.date.substr(5) }}<br>{{ weekDays[date.weekday] }}
                                </li>
                            </template>
                        </ul>
                    </div>
                    <ul></ul>
                </div>
                <div class="l-wrap--select u-mt0 sp-only">
                    <div class="l-wrap--select__inner">
                        <div class="c-select--triangle">
                            <select class="" v-model="selectedMember" v-on:change="loadProcesses">
                                <option value="0">全ての担当</option>
                                <template v-for="(member, index) in members">
                                <option v-bind:value="member.id">{{ member.name }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="l-wrap--body l-wrap--body__table l-wrap--body__search">
                    <div class="l-wrap--button">
                        <ul class="l-wrap--button__list button-three select-tab">
                            <li :class="{'selected': this.selectedWorkStatus == 0}"><a @click="setWorkStatus(0)">進行中</a></li>
                            <li :class="{'selected': this.selectedWorkStatus == 1}"><a @click="setWorkStatus(1)">未確定</a></li>
                            <li :class="{'selected': this.selectedWorkStatus == 2}"><a @click="setWorkStatus(2)">完了済み</a></li>
                        </ul>
                    </div>
                    <div class="l-wrap--body__inner">
                        <div class="l-wrap--body__table__area">
                            <div class="l-wrap--body__table__thead">
                                <div class="l-wrap--body__table__tr">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__th u-wflex1_pc">現場名<br>住所 / お客様名</div>
                                        <div class="l-wrap--body__table__th u-w100_pc">開始日</div>
                                        <div class="l-wrap--body__table__th u-w100_pc">終了日</div>
                                    </div>
                                </div>
                            </div>
                            <div class="l-wrap--body__table__tbody">
                                <div class="l-wrap--body__table__tr">
                                    <template v-for="(process, index) in processes">
                                        <a
                                            class="c-link--detail"
                                            :href="workUrl(index)"
                                        >
                                            <div class="l-wrap--body__table__tr__inner">
                                                <div class="l-wrap--body__table__td u-wflex1">
                                                    <p class="c-text--main">{{ (process.work ? process.work.name : '') }}</p>
                                                    <p class="c-text--sub_sp u-mb0">{{ (process.work ? process.work.address : '') }}<span class="pc-only"> / </span><br class="sp-only">{{ (process.work && process.work.client) ? process.work.client.name : '' }}</p>
                                                </div>
                                                <div class="l-wrap--body__table__td u-w100_pc u-w60_sp">
                                                    <span class="u-color--grayNavy">{{ (process.work ? process.work.period_start_date : '') | moment('M月D日')}}</span>
                                                </div>
                                                <div class="l-wrap--body__table__td u-w100_pc u-w60_sp">
                                                    <span class="u-color--grayNavy">{{ (process.work ? process.work.period_finish_date : '') | moment('M月D日') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
    import moment from 'moment';

    export default {
        data() {
            return {
                today: '',
                weekDays: ['日', '月', '火', '水', '木', '金', '土'],
                dates: [],
                processes: [],
                members: [],
                selectedDate: moment().format('YYYY/MM/DD'),
                selectedMember: 0,
                selectedWorkStatus: 0,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadDates();
            this.loadMembers();
            this.loadProcesses();
        },
        mounted: function() {
            this.scrollToToday();
        },
        filters: {
            moment(value, format) {
                return moment(value).format(format);
            }
        },
        computed: {},
        methods: {
            workUrl: function(index) {
                if (this.processes[index].work) {
                    return '/user/work/detail/' + this.processes[index].work.id;
                }
                return '';
            },
            setDate: function(date) {
                this.selectedDate = date;
                this.loadProcesses();
            },
            setWorkStatus: function(status) {
                this.selectedWorkStatus = status;
                this.loadProcesses();
            },
            scrollToToday: function() {
                // scroll to today
                let todayObj = $('#dates').find('.today');
                let index = $('[type=date]').index(todayObj[0]);
                index = (index > 3) ? index - 3 : index;
                if (index < 0) return;
                $('#dates').animate({scrollLeft: $('[type=date]')[index].offsetLeft});
            },
            loadDates: function() {
                let today = moment();
                this.today = today.format('YYYY/MM/DD');
                let todayMonth = today.format('MM');
                let start = today.clone().subtract(1, 'month').startOf('month');
                let finish = today.clone().add(1, 'month').endOf('month');
                while (true) {
                    let date = start.format('YYYY/MM/DD');
                    this.dates.push({
                        date: date,
                        weekday: start.weekday(),
                    });
                    start = start.add(1, 'day');
                    if (start.format('YYYY-MM-DD') > finish.format('YYYY-MM-DD')) break;
                }
            },
            loadProcesses: function() {
                let params = {
                    date: this.selectedDate.replaceAll('/', '-'),
                    member: this.selectedMember,
                    work_status: this.selectedWorkStatus,
                }
                axios.post('/api/processes/search', params)
                    .then(result => {
                        let data = result.data;
                        if (data) {
                            this.processes = data;
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            loadMembers: function() {
                axios.get('/api/user/members')
                    .then(result => {
                        let data = result.data.data;
                        if (data) {
                            this.members = data;
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
        },
        watch: {
        },
    }
</script>
