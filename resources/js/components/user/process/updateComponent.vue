<template>
    <div class="l-login__wrap">
        <div class="l-login__title l-user__header">
            <div class="l-user__header__inner">
                <div class="l-user__header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1>工程内容作成</h1>
            </div>
        </div>
        <div class="l-form__area">
            <div class="l-inputLabel u-inputBox">
                <label>工程内容</label>
                <input
                    v-model="process.name"
                    class="c-input--white"
                    type="text"
                    placeholder="工程内容を入力してください"
                >
            </div>
            <div class="l-hidden l-inputLabel u-inputBox open">
                <label>工程日程</label>
                <div class="c-input__supplement__wrap l-flex">
                    <div class="c-input__supplement__box">
                        <span>開始日</span>
                    </div>
                    <div class="c-input__supplement__box vue-right">
                        <span>終了日</span>
                    </div>
                </div>
                <div
                    class="c-input__supplement__wrap"
                    v-for="(period, index) in process.process_period"
                    :key="index"
                >
                    <div class="l-flex" v-if="!period.deleted_at">
                        <div class="c-input__supplement__box">
                            <vuejs-datepicker
                                v-model="period.start_date"
                                :language="ja"
                                :format="DatePickerFormat"
                                calendar-class="c-input--white"
                            />
                        </div>
                        <div class="c-input__supplement__box vue-right">
                            <vuejs-datepicker
                                v-model="period.finish_date"
                                :language="ja"
                                :format="DatePickerFormat"
                                calendar-class="c-input--white"
                            />
                        </div>
                        <div class="c-add--block">
                            <span @click.prevent="deletePeriod(index)"><img src="/img/icon-minus.png"></span>
                        </div>
                    </div>
                </div>

                <div class="l-main__body__add">
                    <a class="c-button--addGreen" @click="addPeriod">日程を追加する</a>
                </div>
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>備考<span> - 任意</span></label>
                <textarea class="c-input--white" v-model="process.memo" />
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>カラーを選択</label>

                <ul class="l-flex selectColor">
                    <li class="colorBox one"><input type="radio" ref="color1" v-model="processColorId" value="1" name="colorGroup" @click="radioDeselection(1)"><label></label></li>
                    <li class="colorBox two"><input type="radio" ref="color2" v-model="processColorId" value="2" name="colorGroup" @click="radioDeselection(2)"><label></label></li>
                    <li class="colorBox three"><input type="radio" ref="color3" v-model="processColorId" value="3" name="colorGroup" @click="radioDeselection(3)"><label></label></li>
                    <li class="colorBox four"><input type="radio" ref="color4" v-model="processColorId" value="4" name="colorGroup" @click="radioDeselection(4)"><label></label></li>
                    <li class="colorBox five"><input type="radio" ref="color5" v-model="processColorId" value="5" name="colorGroup" @click="radioDeselection(5)"><label></label></li>
                    <li class="colorBox six"><input type="radio" ref="color6" v-model="processColorId" value="6" name="colorGroup" @click="radioDeselection(6)"><label></label></li>
                    <li class="colorBox seven"><input type="radio" ref="color7" v-model="processColorId" value="7" name="colorGroup" @click="radioDeselection(7)"><label></label></li>
                    <li class="colorBox eight"><input type="radio" ref="color8" v-model="processColorId" value="8" name="colorGroup" @click="radioDeselection(8)"><label></label></li>
                    <li class="colorBox nine"><input type="radio" ref="color9" v-model="processColorId" value="9" name="colorGroup" @click="radioDeselection(9)"><label></label></li>
                    <li class="colorBox ten"><input type="radio" ref="color10" v-model="processColorId" value="10" name="colorGroup" @click="radioDeselection(10)"><label></label></li>
                </ul>
                <!-- <ul class="color__list l-flex">
                    <li
                        v-for="processColor in processColors"
                        :key="processColor.id"
                        @click="selectProcessColor(processColor.id)"
                    >
                        <input
                            type="radio"
                            :checked="processColor.id==process.process_color_id"
                            name="color"
                        >
                        <label
                            class="color__box"
                            :class="'color' + processColor.color"
                        />
                    </li>
                </ul> -->
            </div>
            <div class="l-button--submit">
                <button
                    class="c-button--yellowRounded"
                    type="button"
                    :disabled="!proccess_all"
                    :class="{'notSubmit':!proccess_all}"
                    @click="updateProcess"
                >
                    更新する
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import vuejsDatepicker from 'vuejs-datepicker'
    import {ja} from 'vuejs-datepicker/dist/locale' // 日本語化

    export default {
        components: {
            'vuejs-datepicker':vuejsDatepicker,
        },
        props: ['id'],
        data() {
            return {
                ja: vdp_translation_ja.js, // vuejsDatepickerを日本語にする
                DatePickerFormat: 'yyyy年MM月dd日', // vuejsDatepickerを表示フォーマット
                // 工程の色
                processColorId: '',
                process: undefined,
                processColors: [],
            }
        },
        created: function() {
            this.loadProcessColors();
            this.loadProcessDetail();
        },
        computed: {
            // 工程項目の必須項目を全て入力するとsubmitできる
            proccess_all: function() {
                let required_fields = [
                    this.name,
                ]
                this.process.process_period.forEach(period => {
                    required_fields.push(period.start_date);
                    required_fields.push(period.finish_date);
                });
                return (required_fields.indexOf('') === -1) && (this.process.process_color_id != -1)
            },
        },
        methods: {
            // 工程カラーリストのローディング
            loadProcessColors: function() {
                this.processColors = [];
                axios.get('/api/process-colors/')
                    .then((response) => {
                        this.processColors = response.data.data;
                    })
            },

            // ラジオボタンのcheckedを外す
            radioDeselection: function(e) {
                // console.log(this.$refs['color' + e].checked);
                if(this.checkRadio == this.$refs['color' + e]) {
                    this.$refs['color' + e].checked = false
                    this.checkRadio = ''
                    this.processColorId = ''
                } else {
                    this.checkRadio = this.$refs['color' + e];
                }
            },

            // 工程詳細のローディング
            loadProcessDetail: function() {
                this.process = undefined;
                axios
                    .get(`/api/processes/${this.id}`)
                    .then((response) => {
                        this.process = response.data.data
                        this.processColorId = this.process.process_color_id
                    });
            },

            // 工程カラーを選択する
            selectProcessColor: function(v) {
                this.process.process_color_id = v;
            },

            // 工程変更
            updateProcess: function() {
                axios
                    .put(`/api/processes/${this.id}`, {
                        work_id: this.process.work_id,
                        process_color_id: this.processColorId,
                        name: this.process.name,
                        memo: this.process.memo,
                    })
                    .then(response => {
                        let processId = response.data.data.id;

                        this.process.process_period.forEach(period => {
                            if (period.id) {
                                if (period.deleted_at) {
                                    // Delete record
                                    axios
                                        .delete(`/api/process-periods/${period.id}`)
                                        .then(response => {
                                            console.log(response);
                                        })
                                        .catch(error => {
                                            console.log("Delete: " + error);
                                        });
                                } else {
                                    // Update record
                                    axios
                                        .put(`/api/process-periods/${period.id}`, {
                                            process_id: processId,
                                            start_date: this.formatDate(period.start_date),
                                            finish_date: this.formatDate(period.finish_date),
                                        })
                                        .then(response => {
                                            console.log(response);
                                        })
                                        .catch(error => {
                                            console.log("Edit: " + error);
                                        });
                                }
                            } else {
                                if (!period.deleted_at) {
                                    // Add record
                                    axios.post('/api/process-periods', {
                                        process_id: processId,
                                        start_date: this.formatDate(period.start_date),
                                        finish_date: this.formatDate(period.finish_date),
                                    }).then(response => {
                                        console.log(response);
                                    }).catch(error => {
                                        console.log("Insert: " + error);
                                    });
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.log("Edit: " + error);
                    });
            },

            // 日程追加
            addPeriod: function() {
                this.process.process_period.push({
                    start_date: '',
                    finish_date: '',
                });
            },

            // 日程削除
            deletePeriod: function(index) {
                if (this.process.process_period.length > 1) {
                    this.process.process_period[index].deleted_at = this.formatDate(new Date());
                }
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
