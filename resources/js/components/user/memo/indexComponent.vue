<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <h1 class="l-wrap--header__title">メモ一覧</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li class="select-charge">
                            <div class="c-select--triangle">
                                <select
                                    v-model="searchMember"
                                    @change="loadMemos"
                                >
                                    <!-- <template v-for="(member, index) in members">
                                        <option
                                            :value="member.id"
                                            :class="{'selected': member.id === searchMember}"
                                        >
                                            {{ member.name }}
                                        </option>
                                    </template> -->
                                    <!-- <template v-for="(member, index) in members"> -->
                                    <option
                                        v-for="(member, index) in members"
                                        :key="index"
                                        :value="member.id"
                                        :class="{'selected': member.id === searchMember}"
                                    >
                                        {{ member.name }}
                                    </option>
                                    <!-- </template> -->
                                </select>
                            </div>
                        </li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a @click.prevent="toggleSearchActive">
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
                    <select v-model="searchMember" @change="loadMemos">
                        <!-- <template v-for="(member, index) in members">
                            <option
                                :value="member.id"
                                :class="{'selected': member.id === searchMember}"
                            >
                                {{ member.name }}
                            </option>
                        </template> -->
                        <option
                            v-for="(member, index) in members"
                            :key="index"
                            :value="member.id"
                            :class="{'selected': member.id === searchMember}"
                        >
                            {{ member.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="l-wrap--tab">
            <ul class="l-wrap--tab__list tab-two">
                <li :class="{'selected': panelActive === 1}"><a @click.prevent="changePanel(1)">メモ</a></li>
                <li :class="{'selected': panelActive === 2}"><a @click.prevent="changePanel(2)">削除済みメモ</a></li>
            </ul>
        </div>

        <!-- 見積書 -->
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search" v-if="panelActive === 1">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__button">
                        <a
                            class="c-button--addGreen"
                            href="/user/memo/register"
                        >
                            メモを追加する
                        </a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w250_pc">タイトル</div>
                                <div class="l-wrap--body__table__th u-w200_pc">担当者 / 作成日</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">メモ内容</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <!-- <template v-for="(data, index) in memoResults"> -->
                        <div
                            v-for="(data, index) in memoResults"
                            :key="index"
                            class="l-wrap--body__table__tr"
                        >
                            <a class="c-link--detail" :href="`/user/memo/edit/${data.id}`">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w250_pc u-w100per_sp c-text--main_sp">{{ data.title }}</div>
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--sub_sp">{{ data.member }} / {{ data.date }}</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ data.text }}</div>
                                </div>
                            </a>
                        </div>
                        <!-- </template> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- 請求書 -->
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search" v-else-if="panelActive === 2">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w250_pc">タイトル</div>
                                <div class="l-wrap--body__table__th u-w200_pc">担当者 / 作成日</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">メモ内容</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <!-- <template v-for="(data, index) in deletedResults"> -->
                        <div
                            v-for="(data, index) in deletedResults"
                            :key="index"
                            class="l-wrap--body__table__tr"
                        >
                            <a class="c-link--detail" href="">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w250_pc u-w100per_sp c-text--main_sp">{{ data.title }}</div>
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--sub_sp">{{ data.member }} / {{ data.date }}</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ data.text }}</div>
                                </div>
                            </a>
                        </div>
                        <!-- </template> -->
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
                panelActive: 1,
                searchMember: 0,
                memoResults: [],
                deletedResults: [],
                members: [],
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadMembers();
            this.loadMemos();
        },
        computed: {},
        methods: {
            changePanel: function(panel) {
                this.panelActive = panel;
            },
            loadMembers: function() {
                this.members = [{
                    id: 0,
                    name: '全ての担当',
                }];
                axios
                    .get('/api/user/members')
                    .then(result => {
                        let datas = result.data.data;
                        if (datas) {
                            for (let index = 0; index < datas.length; index ++) {
                                let data = datas[index];
                                this.members.push({
                                    id: data.id,
                                    name: data.name,
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            loadMemos: function() {
                let params = {
                    member: this.searchMember,
                };
                axios
                    .post('/api/user/memos/search', params)
                    .then(result => {
                        let datas = result.data.data;
                        if (datas) {
                            this.memoResults.splice(0);
                            this.deletedResults.splice(0);
                            for (let index = 0; index < datas.length; index ++) {
                                let data = datas[index];
                                if (data.deleted_at != null) {
                                    this.deletedResults.push({
                                        title: data.title,
                                        member: data.member_name,
                                        text: data.text,
                                        date: data.deleted_at.substr(0, 10),
                                    });
                                }
                                else {
                                    this.memoResults.push({
                                        title: data.title,
                                        member: data.member_name,
                                        text: data.text,
                                        date: data.created_at.substr(0, 10),
                                    });
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            }
        },
        watch: {},
	}
</script>
