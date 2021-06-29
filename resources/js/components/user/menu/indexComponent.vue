<template>
    <div class="l-wrap--inner">
        <div class="l-alart successAlart" v-if="hasUrlCopied">
            <p>職人用URLをコピーされました。</p>
        </div>

        <!-- 営業担当修正 -->
        <div class="l-modal" :class="{'open': isMemberEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleMemberEdit">
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a :href="editMemberUrl()">編集する</a></div>
                    <div class="l-modak__list"><a @click="deleteMember">削除する</a></div>
                </div>
            </div>
        </div>

        <!-- お客様修正 -->
        <div class="l-modal" :class="{'open': isClientEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleClientEdit">
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a :href="editClientUrl()">編集する</a></div>
                    <div class="l-modak__list"><a @click="deleteClient">削除する</a></div>
                </div>
            </div>
        </div>

        <!-- 職人修正 -->
        <div class="l-modal" :class="{'open': isWorkerEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleWorkerEdit">
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a :href="editWorkerUrl()">編集する</a></div>
                    <div class="l-modak__list"><a @click="deleteWorker">削除する</a></div>
                </div>
            </div>
        </div>
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/public/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">メニュー</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li><a href="/user/menu/profile-edit">プロフィールを編集する</a></li>
                        <li><a v-bind:href="lineMsg()">職人へLINEを送る</a></li>
                        <li><a @click="copyUrl()">職人用URLをコピーする</a></li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a href="/user/process">
                                <img src="/public/img/icon-chart-black.png">
                                <span>工程表</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="l-wrap--tab sp-only">
            <ul class="l-wrap--tab__list tab-four">
                <li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">プロフィール</a></li>
                <li :class="{'selected': panelActive === '2'}"><a @click.prevent="changePanel('2')">営業担当者</a></li>
                <li :class="{'selected': panelActive === '3'}"><a @click.prevent="changePanel('3')">お客様</a></li>
                <li :class="{'selected': panelActive === '4'}"><a @click.prevent="changePanel('4')">職人</a></li>
            </ul>
        </div>

        <div class="l-wrap--body l-wrap--body__detail" v-if="panelActive === '1'">
            <div class="l-wrap--button sp-only">
                <p class="l-wrap--button__title">職人がログインURLを忘れた場合</p>
                <ul class="l-wrap--button__list button-two">
                    <li class="c-button--line"><a href="">LINEで送る</a></li>
                    <li><a href="">URLをコピー</a></li>
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
                                <th>会社名</th>
                                <td>{{ profile.company }}</td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>{{ profile.email }}</td>
                            </tr>
                            <tr>
                                <th>電話番号</th>
                                <td>{{ profile.tel }}</td>
                            </tr>
                            <tr>
                                <th>郵便番号</th>
                                <td>{{ profile.postal }}</td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td>{{ profile.address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="l-wrap--body__detail__box box-right">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">その他登録情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>パスワード</th>
                                <td class="u-text--right"><a href="/user/menu/password-edit" class="u-color--blue">変更する</a></td>
                            </tr>
                            <tr>
                                <th>銀行情報</th>
                                <td class="u-text--right"><a href="/user/bank" class="u-color--blue">変更する</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="l-wrap--body__detail__body u-mt14_sp">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>工程名マスター</th>
                                <td class="u-text--right"><a href="/user/menu/photo-item" class="u-color--blue">変更する</a></td>
                            </tr>
                            <tr>
                                <th>撮影項目名マスター</th>
                                <td class="u-text--right"><a href="/user/menu/process-item" class="u-color--blue">変更する</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="l-wrap--body__detail__body u-mt14_sp u-mt20_pc">
                        <ul class="l-wrap--body__detail__list">
                            <li><a href="mailto:chankan77@gmail.com">運営にお問い合わせ</a></li>
                            <li><a @click.prevent.stop="logout">ログアウト</a></li>
                            <li><a href="">退会</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__table sp-only" v-else-if="panelActive === '2'">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__button">
                        <a class="c-button--addGreen" href="/user/menu/member-register">営業担当を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w200_pc">営業担当名</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">社内メモ</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(member, index) in members">
                            <div class="l-wrap--body__table__tr">
                                <a class="c-link--edit" @click="toggleMemberEdit(index)">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--main_sp">
                                            {{ member.name }}
                                        </div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ member.memo }}</div>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search sp-only" v-else-if="panelActive === '3'">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__button">
                        <a class="c-button--addGreen" href="/user/menu/client-register">お客様を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w200_pc">お客様名</div>
                                <div class="l-wrap--body__table__th u-w200_pc">電話番号</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">社内メモ</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(client, index) in clients">
                        <div class="l-wrap--body__table__tr">
                            <a class="c-link--edit" @click="toggleClientEdit(index)">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--main_sp">{{ client.name }}</div>
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--sub_sp">{{ client.tel }}</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ client.memo }}</div>
                                </div>
                            </a>
                        </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search sp-only" v-else-if="panelActive === '4'">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__button">
                        <a class="c-button--addGreen" href="/user/worker-register">職人を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w200_pc">職人名</div>
                                <div class="l-wrap--body__table__th u-w200_pc">メールアドレス</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">社内メモ</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(worker, index) in workers">
                            <div class="l-wrap--body__table__tr">
                                <a class="c-link--edit" @click="toggleWorkerEdit(index)">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--main_sp">{{ worker.name }}</div>
                                        <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--sub_sp">{{ worker.email }}</div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ worker.manager_remark}}</div>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var numeral = require('numeral');

    Vue.filter("formatNumber", function (value) {
        return numeral(value).format("0,0");
    });

	export default {
        props: ['user_id'],
		data() {
			return {
                panelActive: '1',
                isMemberEdit: false,
                isClientEdit: false,
                isWorkerEdit: false,
                hasUrlCopied: false,
                profile: [],
                members: [],
                clients: [],
                workers: [],
                selectedMember: 0,
                selectedClient: 0,
                selectedWorker: 0,
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadProfile();
            this.loadMembers();
            this.loadClients();
            this.loadWorkers();
		},
		computed: {},
		methods: {
		    changePanel: function(panel) {
		        this.panelActive = panel;
            },
            toggleMemberEdit: function(index) {
		        this.isMemberEdit = !this.isMemberEdit;
		        this.selectedMember = this.members[index].id;
            },
            toggleClientEdit: function(index) {
		        this.isClientEdit = !this.isClientEdit;
		        this.selectedClient = this.clients[index].id;
            },
            toggleWorkerEdit: function(index) {
		        this.isWorkerEdit = !this.isWorkerEdit;
		        this.selectedWorker = this.workers[index].id;
            },
            loadProfile: function() {
                axios.get('/api/users/' + this.user_id)
                    .then(result => {
                        let data = result.data.data;
                        if (data) {
                            this.profile = data;
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
            loadClients: function() {
                axios.get('/api/clients')
                    .then(result => {
                        let data = result.data.data;
                        if (data) {
                            this.clients = data;
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            loadWorkers: function() {
                axios.get('/api/user/workers')
                    .then(result => {
                        let data = result.data.data;
                        if (data) {
                            this.workers = data;
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            logout: function() {
                axios.post('/api/users/logout')
                    .then(result => {
                        location.href = '/login';
                    })
                    .catch(error => {
                        console.log('err', error.response);
                    });
            },
            copyUrl: function() {
		        this.hasUrlCopied = false;
		        let url = 'https://nuriemon56.com/worker/login/';
                let el = document.createElement('textarea');
                el.value = url;
                el.setAttribute('readonly', '');
                el.style = {position: 'absolute', left: '-9999px'};
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                this.hasUrlCopied = true;
            },
            lineMsg: function() {
                let lineBreak = "%0D%0A";
                let msg = "「nuriemon」のログイン画面です。" + lineBreak +
                            "以下URLより、ログインしてください。" + lineBreak + lineBreak +
                            "https://nuriemon56.com/worker/login";
                return 'line://msg/text/' + msg;
            },
            editMemberUrl: function() {
                return '/user/menu/member-edit?id=' + this.selectedMember;
            },
            deleteMember: function() {
                axios.delete('/api/user/members/' + this.selectedMember)
                    .then(result => {
                        this.isMemberEdit = false;
                        this.loadMembers();
                    })
                    .catch(error => {
                        console.log('err', error.response);
                    });
            },
            editClientUrl: function() {
                return '/user/menu/client-edit?id=' + this.selectedClient;
            },
            deleteClient: function() {
                axios.delete('/api/clients/' + this.selectedClient)
                    .then(result => {
                        this.isClientEdit = false;
                        this.loadClients();
                    })
                    .catch(error => {
                        console.log('err', error.response);
                    });
            },
            editWorkerUrl: function() {
                return '/user/menu/worker-edit?id=' + this.selectedWorker;
            },
            deleteWorker: function() {
                axios.delete('/api/user/workers/' + this.selectedWorker)
                    .then(result => {
                        this.isWorkerEdit = false;
                        this.loadWorkers();
                    })
                    .catch(error => {
                        console.log('err', error.response);
                    });
            }
        },
		watch: {},
	}
</script>
