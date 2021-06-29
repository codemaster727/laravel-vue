<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <h1 class="l-wrap--header__title u-w100per">広告出稿確認画面</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__list">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__list__block">
                    <ul class="noLink">
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">会社名</div>
                                <div class="u-w100per u-pl10">{{ advertising.company }}</div>
                            </div>
                        </li>
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">URL</div>
                                <div class="u-w100per u-pl10">{{ advertising.url }}</div>
                            </div>
                        </li>
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">電話番号</div>
                                <div class="u-w100per u-pl10">{{ advertising.phone }}</div>
                            </div>
                        </li>
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">担当者名</div>
                                <div class="u-w100per u-pl10">{{ advertising.charge }}</div>
                            </div>
                        </li>
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">メールアドレス</div>
                                <div class="u-w100per u-pl10">{{ advertising.email }}</div>
                            </div>
                        </li>
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">携帯電話</div>
                                <div class="u-w100per u-pl10">{{ advertising.mobile }}</div>
                            </div>
                        </li>
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">郵便番号</div>
                                <div class="u-w100per u-pl10">{{ advertising.zip }}</div>
                            </div>
                        </li>
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">契約期間</div>
                                <div class="u-w100per u-pl10">{{ advertising.advertising_terms[0].period }}ヶ月</div>
                            </div>
                        </li>
                        <li>
                            <div class="l-select__detail l-flex">
                                <div class="u-w100per u-textSize--small u-color--grayNavy u-mb10">契約金額</div>
                                <div class="u-w100per u-pl10">{{ advertising.advertising_terms[0].price }}</div>
                            </div>
                        </li>
                        <li>
                            <label class="l-select__wrap l-flex">
                                <div class="l-select__area">
                                    <div class="c-checkbox--select">
                                        <input type="checkbox" name="" v-model="agree">
                                        <div class="c-checkbox--color"></div>
                                    </div>
                                </div>
                                <div class="l-select__detail">
                                    <a class="u-color--blue">利用規約</a>に同意する
                                </div>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="l-button--submit u-pr10 u-pl10" @click.prevent.stop="confirmAdvertise">
                <input class="c-button--yellowRounded" type="submit" name="" value="確定する">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['advertise_id'],
        data() {
            return {
                advertising: {
                    advertising_terms: [{
                        period: 0,
                        price: 0,
                    }],
                },
                agree: false,
            }
        },
        created() {
            this.loadData();
        },
        methods: {
            loadData: function() {
                axios.get('/api/manager/advertisings/' + this.advertise_id)
                    .then(result => {
                        this.advertising = result.data.data;
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            confirmAdvertise: function() {
                let params = {
                    advertise_id: this.advertise_id,
                    agree: this.agree ? 1 : 0,
                };
                axios.post('/api/manager/advertisings/confirm', params)
                    .then(result => {
                        if (result.data == 0) {
                            // 成功
                            setTimeout(function() {
                                location.href = '/sponcer/complete';
                            }, 1000);
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            }
        },
        computed: {
        }
    }
</script>
