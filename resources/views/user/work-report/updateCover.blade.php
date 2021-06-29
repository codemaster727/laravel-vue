<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <user-work-report-update-cover-component
                :id="{{ $id }}"
                :title="'{{ $title }}'"
                :logo="'{{ $logo }}'"
            ></user-work-report-update-cover-component>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
