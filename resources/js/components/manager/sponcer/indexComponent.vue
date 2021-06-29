<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <h1 class="l-wrap--header__title u-w100per">オススメ業社</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__list">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__list__block">
                    <ul class="noLink">
                        <template v-for="(advertising, index) in advertisings">
                        <li>
                            <div class="l-select__detail">
                                <p class="u-color--grayNavy u-mb10">{{ advertising.company }}</p>
                                <div class="img">
                                    <a target="_blank" v-bind:href="advertising.img_url"><img v-bind:src="advertising.img_url"></a>
                                </div>
                            </div>
                        </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var moment = require('moment');
    export default {
        props: ['advertise_id'],
        data() {
            return {
                advertisings: [],
            }
        },
        created() {
            this.loadData();
        },
        methods: {
            loadData: function() {
                let now = moment().format('YYYY-MM-DD HH:mm:ss');
                let params = {
                    status: 0,
                    manager_id: this.managerId,
                    ended_at: now,
                };
                axios.get('/api/manager/advertisings')
                    .then(result => {
                        this.advertisings = result.data.data;
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
        },
        computed: {
        }
    }
</script>
