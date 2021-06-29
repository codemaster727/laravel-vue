<template>


	<div class="l-wrap--inner">
        <!-- 工程のモーダル -->
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>工程の削除に成功しました。</p>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>工程の削除に失敗しました。</p>
        </div>

        <!-- 現場のモーダル -->
        <div class="l-alart successAlart" v-if="completeSuccess">
            <p>現場が完了しました。</p>
        </div>
        <div class="l-alart errorAlart" v-if="copmleteError">
            <p>現場の完了に失敗しました。</p>
        </div>

		<!-- modal：削除 -->
		<div class="l-modal" :class="{'open': isModalTrash}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalTrush">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">本当に削除しても<br>よろしいでしょうか？</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalTrush">いいえ</a></li>
                            <li><a href="">はい</a></li>
                        </ul>
                    </div>
                </div>
            </div>
		</div>
		<!-- fin modal：削除 -->

        <!-- 工程内容モーダル -->
        <div class="l-modal" :class="{'open': isProcessEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleProcessEdit">
            <!-- <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleClientEdit(client.id)"> -->
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a :href="`/user/process/edit/${modalProcessId}`">編集する</a></div>
                    <div class="l-modak__list"><a @click="deleteProcess(id, index)">削除する</a></div>
                </div>
            </div>
        </div>

		<!-- case1：現場のステータスが未確定の場合 -->
		<!-- modal：現場確定 -->
		<div class="l-modal" :class="{'open': isModalConfirm}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalConfirm">
                <div class="l-modal--area__input">
                    <div class="l-modal--area__input__box">
                        <p class="c-sentence">現場を確定します。<br>現場開始日と終了日を入力してください。</p>
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>現場開始日</label>
                        <vuejs-datepicker
                            v-model="work.period_start_date"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        />
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>現場終了日</label>
                        <vuejs-datepicker
                            v-model="work.period_finish_date"
                            :language="ja"
                            :format="DatePickerFormat"
                            calendar-class="c-input--white"
                        />
                    </div>
                    <div class="l-modal--area__input__submit l-button--submit">
                        <button
                            class="c-button--yellowRounded"
                            type="submit"
                            :disabled="!proccess_all"
                            :class="{'notSubmit':!proccess_all}"
                            @click="confirmWork"
                        >
                            登録
                        </button>
                        <!-- <input class="c-button--yellowRounded" type="submit" name="" value="登録" :disabled="!proccess_all" :class="{'notSubmit':!proccess_all}" @click="confirmWork"> -->
                    </div>
                </div>
            </div>
		</div>
		<!-- fin modal：現場確定 -->
		<!-- fin case1：現場のステータスが未確定の場合 -->


        <!-- modal：電話番号 -->
		<!-- <div class="l-modal" :class="{'open': isModalInputTel}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalInputTel">
                <div class="l-modal--area__input">
                    <div class="l-modal--area__input__box">
                        <label>お客様電話番号</label>
                        <input v-model="work.client.tel">
                    </div>
                    <div class="l-modal--area__input__submit l-button--submit">
                        <button
                            class="c-button--yellowRounded"
                            type="submit"
                            name=""
                            value="登録"
                            :disabled="!work.client.tel"
                            :class="{'notSubmit':!work.client.tel}"
                            @click="updateClientTel"
                        >
                            登録
                        </button>
                    </div>
                </div>
            </div>
		</div> -->
		<!-- fin modal：電話番号 -->


		<!-- case3：現場のステータスが確定の場合 -->
		<!-- modal：現場完了 -->
		<div class="l-modal" :class="{'open': isModalComplete}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalComplete">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">現場完了後、<br>全ての編集が不可となります。<br>よろしいでしょうか？</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalComplete">いいえ</a></li>
                            <li><a @click="completeWork">はい</a></li>
                        </ul>
                    </div>
                </div>
            </div>
		</div>
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">現場詳細</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li><a href="/user/process">工程表</a></li>
                        <li><a @click.prevent="toggleModalSms">お客様へSMS送信</a></li>
                        <!-- case1：現場のステータスが未確定の場合 -->
                        <li v-if="work.status==0">
                            <a @click.prevent="toggleModalConfirm">現場確定</a>
                        </li>
                        <!-- case2：現場のステータスが確定の場合 -->
                        <li v-if="work.status==1">
                            <a @click.prevent="toggleModalComplete">現場完了</a>
                        </li>
                        <li v-if="work.status<2">
                            <a :href="`/user/work/edit/${work.id}`">編集する</a>
                        </li>
                        <li class="icon">
                            <a @click="toggleModalTrush"><img src="/img/icon-dust-navygray.png"></a>
                        </li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a @click.prevent="toggleModalTrush">
                                <img src="/img/icon-dust-black.png">
                                <span>削除</span>
                            </a>
                        </li>
                        <li class="icon">
                            <a href="/user/process">
                                <img src="/img/icon-chart-black.png">
                                <span>工程表</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
		<!-- fin modal：現場完了 -->
		<!-- fin case3：現場のステータスが確定の場合 -->

		<!-- modal：SMS -->
        <div class="l-modal" :class="{'open': isModalSms}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalSms">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">案件情報の詳細URLを、お客様へSMSで送信します。</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalComplete">いいえ</a></li>
                            <li><a @click="sendShortMessage">はい</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
		<!-- fin modal：SMS -->
        <div class="l-wrap--tab">
            <ul class="l-wrap--tab__list" :class="{'tab-four': work.status > 0, 'tab-two': work.status < 0}">
                <li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">現場情報</a></li>
                <li :class="{'selected': panelActive === '2'}" v-if="work.status>0"><a @click.prevent="changePanel('2')">工程内容</a></li>
                <li :class="{'selected': panelActive === '3'}" v-if="work.status>0"><a @click.prevent="changePanel('3')">撮影項目</a></li>
                <li :class="{'selected': panelActive === '4'}"><a @click.prevent="changePanel('4')">各種書類</a></li>
            </ul>
        </div>

        <!-- panel1：現場情報 -->
        <div class="l-wrap--body l-wrap--body__detail" v-if="panelActive === '1'">
            <div class="l-wrap--button sp-only">
                <ul class="l-wrap--button__list" :class="{'button-three': work.status < 2, 'button-one': work.status == 2}">
					<li><a @click.prevent="toggleModalSms">SMS送信</a></li>
					<!-- case1：現場のステータスが未確定の場合 -->
					<li v-if="work.status==0"><a @click.prevent="toggleModalConfirm">現場確定</a></li>
					<!-- case2：現場のステータスが確定の場合 -->
					<li v-if="work.status==1"><a @click.prevent="toggleModalComplete">現場完了</a></li>
					<li v-if="work.status<2"><a :href="`/user/work/edit/${work.id}`">編集する</a></li>
                </ul>
            </div>
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__detail__box box-left">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">現場情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>ステータス</th>
                                <td>{{ getStatus(work.status) }}</td>
                            </tr>
                            <tr v-if="work.status == 0">
                                <th>仮押さえ日</th>
                                <td>開始：{{ work.temporary_start_date }}<br>終了：{{ work.temporary_finish_date }}</td>
                            </tr>
                            <tr v-else-if="work.status !== 0">
                                <th>現場日程</th>
                                <td>開始：{{ work.period_start_date }}<br>終了：{{ work.period_finish_date }}</td>
                            </tr>
                            <tr>
                                <th>現場名</th>
                                <td><span v-if="work">{{ work.name }}</span></td>
                            </tr>
                            <tr>
                                <th>郵便番号</th>
                                <td><span :class="{'u-color--gray' : !work.postal}">{{ work.postal ? work.postal : '未設定' }}</span></td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td><span :class="{'u-color--gray' : !work.address}">{{ work.address ? work.address : '未設定' }}</span></td>
                            </tr>
                            <tr>
                                <th>お客様名</th>
                                <td>
                                    <span v-if="work.client" :class="{'u-color--gray' : !work.client}">{{ work.client.name ? work.client.name : '未設定' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>営業担当名</th>
                                <td>
                                    <span v-if="work.member" :class="{'u-color--gray' : !work.member}">{{ work.member.name ? work.member.name : '未設定' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>電話番号</th>
                                <!-- <td><a @click="toggleModalInputTel"><span :class="{'u-color--red' : !work.client.tel}">{{ work.client.tel ? work.client.tel : '登録してください。' }}</span></a></td> -->
                                <td>
                                    <span v-if="work.client" :class="{'u-color--red' : !work.client.tel}">{{ work.client.tel ? work.client.tel : '登録してください。' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>職人</th>
                                <td v-if="work.charge_worker">
                                    <span
                                        class="u-display--block"
                                        v-for="worker in work.charge_worker"
                                        :key="worker.id"
                                    >
                                        {{ worker.worker.name }}
                                    </span>
                                </td>
                                <!-- <td v-if="this.chargeWorker">
                                    <span
                                        class="u-display--block"
                                        v-for="worker in this.chargeWorker"
                                        :key="worker.id"
                                    >
                                        {{ worker.worker_name }}
                                    </span>
                                </td> -->
                                <td v-else><span class="u-color--gray">未設定</span></td>
                            </tr>
                            <tr>
                                <th>社内メモ</th>
                                <td><span :class="{'u-color--gray' : !work.memo}">{{ work.memo ? work.memo : '未設定' }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="l-wrap--body__detail__box box-right" v-if="work.status>0">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">現場開始及び終了履歴</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th class="u-text--center">開始時間</th>
                                    <th class="u-text--center">終了時間</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, key) in work.history" :key="key">
                                    <td>{{ key }}</td>
                                    <td>
                                        <span class="u-display--block" v-for="item in value" :key="item.id">
                                            {{ item.charge_worker.worker.name }}
                                        </span>
                                    </td>
                                    <td class="u-text--center">
                                        <span class="u-display--block u-color--grayNavy" v-for="item in value" :key="item.id">
                                            {{ item.work_start_on | '-' }}
                                        </span>
                                    </td>
                                    <td class="u-text--center">
                                        <span class="u-display--block u-color--grayNavy" v-for="item in value" :key="item.id">
                                            {{ item.work_finish_on | '-' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin panel1：現場情報 -->

        <!-- panel2：工程内容 -->
        <div class="l-wrap--body l-wrap--body__table" v-if="panelActive === '2'">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div
                        v-if="work.status<2"
                        class="l-wrap--body__table__button"
                    >
                        <a :href="`/user/process/register/${work.id}`" class="c-button--addGreen">工程内容を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w80_pc">カラー</div>
                                <div class="l-wrap--body__table__th u-w240_pc">工程内容名</div>
                                <div class="l-wrap--body__table__th u-w200_pc">工程期間（開始 - 終了）</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">備考</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <div
                            class="l-wrap--body__table__tr"
                            v-for="item in work.process"
                            :key="item.id"
                        >
                            <a class="c-link--edit" @click.prevent="toggleProcessEdit(item.id)">
                            <!-- <a :href="`/user/process/detail/${item.id}`"> -->
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w60_sp u-w80_pc">
                                        <span
                                            class="c-box--color"
                                            :class="'color' + item.process_color.id"
                                        />
                                    </div>
                                    <div class="l-wrap--body__table__tr__inner u-wflex1">
                                        <div class="l-wrap--body__table__td u-w240_pc c-text--main_sp">
                                            <span
                                                v-if="item.name"
                                            >
                                                {{ item.name }}
                                            </span>
                                        </div>
                                        <div class="l-wrap--body__table__td u-w200_pc c-text--sub_sp">
                                            <span
                                                v-for="period in item.process_period"
                                                :key="period.id"
                                                style="display: block; white-space: nowrap;"
                                            >
                                                {{ period.start_date }} - {{ period.finish_date }}
                                            </span>
                                        </div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub_sp">
                                            {{ item.memo }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin panel2：工程内容 -->


        <!-- panel3：撮影項目 -->
        <div class="l-wrap--body l-wrap--body__table" v-if="panelActive === '3'">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__download">
                        <a>撮影項目をダウンロードする</a>
                    </div>
                    <div
                        v-if="work.status<2"
                        class="l-wrap--body__table__button"
                    >
                        <a :href="`/user/diagnose-report/register-item/${this.id}`" class="c-button--addGreen">撮影項目を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__td u-w100_pc u-w80_sp">写真</div>
                                <div class="l-wrap--body__table__tr__inner u-wflex1">
                                    <div class="l-wrap--body__table__td u-w240_pc c-text--main_sp">撮影項目</div>
                                    <div class="l-wrap--body__table__td u-w120_pc c-text--sub_sp">撮影日<br>撮影者</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub_sp">備考</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <div
                            class="l-wrap--body__table__tr"
                            v-for="item in work.work_report_item"
                            :key="item.id"
                        >
                            <a href="/user/diagnose-report/edit-item">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w100_pc u-w80_sp">
                                        <div class="c-detail--img">
                                            <img :src="item.photo">
                                        </div>
                                    </div>
                                    <div class="l-wrap--body__table__tr__inner u-wflex1">
                                        <div class="l-wrap--body__table__td u-w240_pc c-text--main"><span v-if="item.name">{{ item.name }}</span></div>
                                        <div class="l-wrap--body__table__td u-w120_pc c-text--sub">{{ item.work_date}} / {{ item.photographer }}</div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc c-text--sub">{{ item.remark }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin panel3：撮影項目 -->


        <!-- panel4：各種書類 -->
        <div class="l-wrap--body l-wrap--body__link" v-if="panelActive === '4'">
            <div class="l-wrap--body__inner">
                <ul class="l-wrap--body__link__list">
                    <li><a href="">「見積書」を作成する</a></li>
                    <li v-if="work.status>0"><a href="">「請求書」を作成する</a></li>
                    <li><a :href="`/user/diagnose-report/register-cover/${this.id}`">「診断報告書」を作成する</a></li>
                    <li v-if="work.status>0"><a href="">「現場報告書」を作成する</a></li>
                </ul>
            </div>
        </div>
        <!-- fin panel4：各種書類 -->
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
                isProcessEdit: false,
				ja: vdp_translation_ja.js,
                DatePickerFormat: 'yyyy-MM-dd', // datepicker
				panelActive: '1', // タブ切り替え
				isModalSms: false, // SMSモーダル
				isModalTrash: false, // 削除モーダル
				isModalConfirm: false, // 現場確定モーダル
                isModalComplete: false, // 現場完了モーダル
                isModalInputTel: false, // 電話番号モーダル
                work: '',
                chargeWorker: [],
                // モーダル
                modalProcessId: '',
                hasError: false,
                hasSuccess: false,
                completeSuccess: false,
                copmleteError: false,
			}
		},
		created: function() {
            this.loadWorkDetail();
		},
		computed: {
            // 現場項目の必須項目を全て入力するとsubmitできる
            proccess_all: function() {
                return this.work.period_start_date && this.work.period_finish_date;
            },
        },
		methods: {
			// パネルの切り替え
			changePanel: function(num) {
				this.panelActive = num
			},
			// SMSモーダル
			toggleModalSms: function() {
				this.isModalSms = !this.isModalSms
			},
			// 削除モーダル
			toggleModalTrush: function() {
				this.isModalTrash = !this.isModalTrash
			},
			// 現場確定モーダル
			toggleModalConfirm: function() {
                this.isModalConfirm = !this.isModalConfirm
			},
			// 現場完了モーダル
			toggleModalComplete: function() {
				this.isModalComplete = !this.isModalComplete
            },
            // 電話番号モーダル
            toggleModalInputTel: function() {
                this.isModalInputTel = !this.isModalInputTel
            },
            // 工程編集モーダル
            toggleProcessEdit: function(id, index) {
                this.isProcessEdit = !this.isProcessEdit
                this.modalProcessId = id
            },

            /**
             * ローディング
             */
            // 現場詳細のローディング
            loadWorkDetail: function() {
                this.process = undefined;
                axios.get(`/api/works/${this.id}`)
                    .then(response => {
                        this.work = response.data.data;
                        console.log(this.work);
                        _.sortBy(this.work.history, function(x) {
                            return x.work_dateSort;
                        });
                        this.work.history = _.groupBy(this.work.history, 'work_date')
                    })
                    .catch(response => {
                        alert('取得時にエラーが発生しました。')
                    })
                // .then(
                //     (response) => {
                //         this.work = response.data.data;
                //         _.sortBy(this.work.history, function(x) {
                //             return x.work_dateSort;
                //         });
                //         this.work.history = _.groupBy(this.work.history, 'work_date');
                //     }
                // );
            },

            /**
             *
             * 現場処理記述
             *
             */
            // 現場確定
            confirmWork: function() {
                let params = {
                    'status'             : 1,
                    'period_start_date'  : this.work.period_start_date,
                    'period_finish_date' : this.work.period_finish_date,
                }
                axios
                    .post(`/api/works/confirmWork/${this.id}`, params)
                    .then(res => {
                        console.log(res)
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },

            // 現場完了
            completeWork: function() {
                axios
                    .post(`/api/works/completeWork/${this.id}`)
                    .then(res => {
                        console.log(res)
                        this.isModalComplete = false
                        this.completeSuccess = true
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .catch(err => {
                        console.log(err)
                        this.isModalComplete = false
                        this.completeError = true
                    })
            },

            // 電話番号更新
            updateClientTel: function() {
                axios
                    .put(`/api/clients/${this.work.client.id}`, {
                        user_id: this.work.client.user_id,
                        name: this.work.client.name,
                        tel: this.work.client.tel,
                        memo: this.work.client.memo,
                    })
                    .then(response => {
                        console.log(response);
                        this.isModalInputTel = false;
                    })
                    .catch(error => {
                        console.log("Edit: " + error);
                        this.isModalInputTel = false;
                    });
            },


            // 現場変更
            updateWork: function() {
                axios
                    .put(`/api/works/${this.id}`, {
                        name: this.work.name,
                        temporary_start_date: this.work.temporary_start_date,
                        temporary_finish_date: this.work.temporary_finish_date,
                        period_start_date: this.work.period_start_date,
                        period_finish_date: this.work.period_finish_date,
                        postal: this.work.postal,
                        address: this.work.address,
                        client_id: this.work.client_id,
                        member_id: this.work.member_id,
                        remark: this.work.remark,
                        memo: this.work.memo,
                        status: this.work.status,
                    })
                    .then(res => {
                        console.log(res);
                        this.isModalConfirm = false;
                        this.isModalComplete = false;
                    })
                    .catch(err => {
                        console.log("Edit: " + err);
                        this.isModalConfirm = false;
                        this.isModalComplete = false;
                    });
            },

            // お客様へSMS送信
            sendShortMessage: function() {
                axios
                    .post('/api/user/shortmessages', {
                        client_id: this.work.client_id,
                        type: 1,
                        work_id: this.work.id,
                    })
                    .then(res => {
                        console.log(res);
                    })
                    .catch(err => {
                        console.log("SendSMS: " + err);
                    })
            },

            getStatus: function(v) {
                if (v == 0) {
                    return '未確定';
                } else if (v == 1) {
                    return '進行中';
                } else if (v == 2) {
                    return '完了済み';
                }
            },

            /**
             * 担当者処理
             */
            // 工程を削除するAPI
            deleteProcess: function() {
                this.hasError = false
                this.hasSuccess = false
                this.isProcessEdit = false
                this.work.process[this.modalProcessId].slice()
                axios.delete(`/api/processes/${this.modalProcessId}`)
                    .then(result => {
                        this.hasSuccess = true
                        console.log(result)
                        setTimeout(function() {
                            location.href = `/user/work/detail/${this.id}`;
                        }, 1000);
                    })
                    .catch(error => {
                        this.hasError = true
                        console.log(error)
                    })
            },

		},
		watch: {},
	}
</script>
