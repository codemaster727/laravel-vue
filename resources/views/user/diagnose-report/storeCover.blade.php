<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <user-diagnose-report-register-cover-component :work_id="{{ $workId }}"></user-diagnose-report-register-cover-component>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
