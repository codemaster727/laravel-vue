<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <user-diagnose-report-update-item-component
                :id="{{ $id }}"
                {{--  :name="{{ $name }}"
                :content="{{ $content }}"
                :photo="{{ $photo }}"  --}}
            />
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
