<template>
	<div class="l-login">
		<div class="l-login__wrap">
			<div class="l-login__title">
				<h1>新規登録完了</h1>
			</div>
			<div class="l-login__body">
				<p class="c-sentence textCenter">新規登録が完了しました！<br>早速、ログインしてみましょう。</p>
				<div class="l-input--copy">
					<div class="l-input--copy__inner">
						<input type="" name="" v-model="workerId" readonly>
						<button
							v-clipboard:copy="workerId"
							v-clipboard:success="onCopy"
							v-clipboard:error="onError"
						></button>
						<span>コピー</span>
					</div>
				</div>
				<div class="l-button--submit">
					<a href="/worker/login" class="c-button--yellowRounded">ログイン画面へ</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ["worker_id"],
		data: function () {
			return {
				workerId: ''
			}
		},
		created: function() {
			console.log(this.worker_id);
			this.loadWorkerID();
		},
		methods: {
			loadWorkerID: function() {
				this.workerId = this.worker_id;
			},
			onCopy: function (e) {
				alert('コピーしました。: ' + e.text)
			},
			onError: function (e) {
				alert('失敗しました。')
			}
		}
	}
</script>