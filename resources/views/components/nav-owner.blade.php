<nav id="nav-owner">
	<div class="l-nav--logo">
		<p>ロゴ</p>
	</div>
	<div class="l-nav--box">
		<div class="l-nav--box__head">ユーザー</div>
		<ul class="l-nav--box__list">
			<li class="selected"><a href="{{ route('manager.user.index') }}">ユーザー一覧</a></li>
			<li><a href="{{ route('manager.user.store') }}">ユーザー新規追加</a></li>
		</ul>
	</div>
	<div class="l-nav--box">
		<div class="l-nav--box__head">職人</div>
		<ul class="l-nav--box__list">
			<li><a href="{{ route('manager.worker.index') }}">職人一覧</a></li>
		</ul>
	</div>
	<div class="l-nav--box">
		<div class="l-nav--box__head">管理者</div>
		<ul class="l-nav--box__list">
			<li><a href="{{ route('manager.manager.index') }}">管理者一覧</a></li>
			<li><a href="{{ route('manager.manager.store') }}">管理者新規追加</a></li>
		</ul>
	</div>
	<div class="l-nav--box">
		<div class="l-nav--box__head">広告出稿</div>
		<ul class="l-nav--box__list">
			<li><a href="{{ route('manager.advertising.index') }}">広告出稿一覧</a></li>
			<li><a href="{{ route('manager.advertising.store') }}">広告出稿新規追加</a></li>
		</ul>
	</div>
	<div class="l-nav--box">
		<div class="l-nav--box__head">その他</div>
		<ul class="l-nav--box__list">
			<li><a href="{{ route('manager.sms.index') }}">SMS利用状況</a></li>
			<li><a href="{{ route('manager.logout') }}">ログアウト</a></li>
		</ul>
	</div>
</nav>
