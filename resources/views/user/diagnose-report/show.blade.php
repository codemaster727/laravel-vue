<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")
    <div id="app">
        @include("../components/header-user")
        {{-- <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/views/common/modal.php'); ?> --}}
        <main>
            <div class="l-main">
                <div class="allWrapper">
                    <user-diagnose-report-show-component :report-id="{{ $id }}"/>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
