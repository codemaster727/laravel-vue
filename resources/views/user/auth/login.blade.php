@include("../components/head")
<body>
	<div id="app">
		@include("../components/header")
		<main>
            <!--　case1：パスワードの再登録が成功した場合 -->
            <!--
            <div class="l-alart successAlart">
                <p>パスワードの再登録が完了しました。<br>新しいパスワードで、ログインしてください。</p>
            </div>
            -->

            <!--　case2：ログアウト時 -->
            <!--
            <div class="l-alart successAlart">
                <p>ログアウトしました。</p>
            </div>
            -->

            <!-- case3：メールアドレス、パスワードが一致しなかった場合 -->
            <!--
            <div class="l-alart errorAlart">
                <p>メールアドレスとパスワードが一致しませんでした。<br>もう一度、入力をお願いいたします。</p>
            </div>
            -->

            <!--　case4；新規登録時に、URLの有効期限が切れた場合 -->
            <!--
            <div class="l-alart errorAlart">
                <p>1時間経過したため、新規登録用URLの有効期限が切れました。<br class="pc-only">お手数おかけしますが、営業担当へお問い合わせください。</p>
            </div>
            -->


            <!--　case5：管理画面で、ステータスを一時停止にされた場合 -->
            <!--
            <div class="l-alart errorAlart">
                <p>運営者により、強制的に一時停止中です。<br>営業担当へ、お問い合わせください。</p>
            </div>
            -->

            <!-- case6：未入力がある場合 -->
            <!--
            <div class="l-alart errorAlart">
                <p>未入力があります。</p>
            </div>
            -->

			<div class="l-wrap l-wrap--login">
				<user-auth-login-component />
			</div>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>
