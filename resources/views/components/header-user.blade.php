<header id="header-user" class="pc-only">
	<div class="header-user__top">
		<div class="allWrapper">
			<div class="l-flex l-v__center">
				<div class="header-user__top__logo">
					<!-- <img src="/public/img/"> -->
					ぬりえもん
				</div>
				<div class="header-user__top__search c-search--box l-inputLabel">
                    <input
                        class="c-input--white"
                        type="text"
                        name=""
                        placeholder="キーワードを入力してください"
                    >
				</div>
			</div>
		</div>
	</div>
	<div class="header-user__bottom">
		<nav class="allWrapper">
			<ul class="l-flex l-start l-v__center">
				<li class="@if (\Route::is('user.work.*')) selected @endif"><a href="{{ route('user.work.index') }}">現場</a></li>
				<li class="@if (\Route::is('user.process.*')) selected @endif"><a href="{{ route('user.process.index') }}">カレンダー</a></li>
				<li class="@if (\Route::is('user.member.*')) selected @endif"><a href="{{ route('user.member.index') }}">営業担当</a></li>
				<li class="@if (\Route::is('user.client.*')) selected @endif"><a href="{{ route('user.client.index') }}">お客様</a></li>
				<li class="@if (\Route::is('user.worker.*')) selected @endif"><a href="{{ route('user.worker.index') }}">職人</a></li>
				<li class="@if (\Route::is('user.document.*')) selected @endif"><a href="{{ route('user.document.index') }}">見積・請求書</a></li>
				<li class="@if (\Route::is('user.memo.*')) selected @endif"><a href="{{ route('user.memo.index') }}">メモ</a></li>
				<li class="@if (\Route::is('user.menu.*')) selected @endif"><a href="{{ route('user.menu.index') }}">メニュー</a></li>
			</ul>
		</nav>
	</div>
	
</header>
