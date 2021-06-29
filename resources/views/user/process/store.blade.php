<!DOCTYPE html>
<html>
@include("../components/head")
<body>

    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-login">
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
                    <user-process-create-component :work_id="{{ $workId }}"></user-process-create-component>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
