<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            {{--  <user-diagnose-report-update-cover-component
                :id="{{ $id }}"
                :title="'{{ $title }}'"
                :logo="'{{ $logo }}'"
            ></user-diagnose-report-update-cover-component>  --}}
            <user-diagnose-report-update-cover-component
                :id="{{ $id }}"
            />
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
