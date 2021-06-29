<template>
	<div class="l-wrap--inner">
		<div class="l-search sp-only" v-if="isSearchActive" @click.self="toggleSearchActive">
			<div class="l-search__area">
				<div class="c-search--box left">
					<input class="c-input--gray" type="" name="" placeholder="テキストを入力してください。" v-model="searchKeyword">
				</div>
				asdasd
			</div>
		</div>
		<div class="l-wrap--header">
			<div class="l-wrap--header__inner">
				<h1 class="l-wrap--header__title">現場一覧</h1>
				<div class="l-wrap--header__inner__sub">
					<ul class="l-wrap--header__inner__list pc-only">
						<li class="select-charge">
							<div class="c-select--triangle">
								<select class="" v-model="member_id" v-on:change="loadWorks()">
									<option selected :key="0" :value="0">全ての担当者</option>
									<option v-for="member in members" :key="member.id" :value="member.id">{{ member.name }}</option>
								</select>
							</div>
						</li>
						<li class="add-list">
							<a class="c-button--addYellow" href="/user/work/new">新規現場作成</a>
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
		<div class="l-wrap--select sp-only">
			<div class="l-wrap--select__inner">
				<div class="c-select--triangle">
					<select class="" v-model="member_id" v-on:change="loadWorks()">
						<option selected :key="0" :value="0">全ての担当者</option>
                        <option v-for="member in members" :key="member.id" :value="member.id">{{ member.name }}</option>
					</select>
				</div>
			</div>
		</div>
		<div class="l-wrap--tab">
			<ul class="l-wrap--tab__list tab-three">
				<li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">進行中現場</a></li>
				<li :class="{'selected': panelActive === '0'}"><a @click.prevent="changePanel('0')">未確定現場</a></li>
				<li :class="{'selected': panelActive === '2'}"><a @click.prevent="changePanel('2')">完了済み現場</a></li>
			</ul>
		</div>

		<div class="l-wrap--body l-wrap--body__table">
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
						<div class="l-wrap--body__table__tr" v-for="work in works" v-bind:key="work.id">
							<a class="c-link--detail" :href="`/user/work/detail/${work.id}`">
								<div class="l-wrap--body__table__tr__inner">
									<div class="l-wrap--body__table__td u-wflex1">
										<p class="c-text--main">{{ work.name }}</p>
										<p class="c-text--sub_sp u-mb0">{{ work.address }}<span class="pc-only"> / </span><br class="sp-only">{{ work.client_id }}</p>
									</div>
									<div class="l-wrap--body__table__td u-w100_pc u-w60_sp">
										<!-- <span class="u-color--grayNavy" v-if="work.status!=0">{{ work.period_start_date }}</span> -->
                                        <span class="u-color--grayNavy" v-if="work.status!=0">{{ work.period_start_date | moment('M月D日') }}</span>
                                        <span class="u-color--grayNavy" v-if="work.status==0">{{ work.temporary_start_date | moment('M月D日') }}</span>
									</div>
									<div class="l-wrap--body__table__td u-w100_pc u-w60_sp">
										<span class="u-color--grayNavy" v-if="work.status!=0">{{ work.period_finish_date | moment('M月D日') }}</span>
                                        <span class="u-color--grayNavy" v-if="work.status==0">{{ work.temporary_finish_date | moment('M月D日') }}</span>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    import moment from 'moment';

	export default {
		data() {
			return {
				isSearchActive: true, // 検索のモーダル
                searchKeyword: '', // 検索キーワード
                panelActive: '1', // タブ切り替え
                member_id: '0', // 検索メンバー
                works: [], // 現場リスト
                members: [], // 担当者リスト

                workStart: '', // 現場開始時間
			}
        },
		props: ["mykeyword"],
		created: function() {
            this.loadMembers();
            this.loadWorks();
        },
        mounted: function () {
            // this.workStart = dayjs(this.work.period_start_date).month(5).format();
			$("#header-user > div.header-user__top > div > div > div.header-user__top__search.c-search--box.l-inputLabel > input").on('keyup', (e) => {
				if (e.key === 'Enter' || e.keyCode === 13) {
					this.searchKeyword = '';
					if(!e.target.value) return;
					this.searchKeyword = e.target.value;
					this.loadWorks();
				}
			});
        },
        filters: {
            moment(value, format) {
                return moment(value).format(format);
            }
        },
		computed: {

		},
		methods: {
            // 担当者リストのローディング
            loadMembers: function() {
                this.members = [];
                axios.get('/api/user/members/')
                .then(
                    (response) => {
                        this.members = response.data.data;
                    }
                );
            },

            // 現場リストのローディング
            loadWorks: function() {
                this.works = [];
                axios.post('/api/works/search', {
                    keyword: this.searchKeyword,
                    status: this.panelActive,
                    member_id: this.member_id,
                }).then(
                    (response) => {
                        console.log(response.data);
                        this.works = response.data.data;
                    }
                );
            },

			// 検索モーダルの切り替え
			toggleSearchActive: function() {
				this.isSearchActive = !this.isSearchActive;
			},

			// パネルの切り替え
			changePanel: function(num) {
				this.panelActive = num;
                this.loadWorks();
            },

            onMemberChange: function() {
                // console.log(this.member_id);
                this.loadWorks();
            }
		},
		watch: {
            searchKeyword: function() {
                this.loadWorks();
            },
			mydata: function() {
                this.works = []
            },
			window: function() {
                alert()
            },
        },
	}
</script>
