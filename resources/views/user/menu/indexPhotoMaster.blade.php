<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <!-- <div class="l-alart errorAlart">
            <p>未入力の項目があります。</p>
            </div> -->
            <div class="l-wrap l-wrap--form">
                <user-menu-photo-master-component></user-menu-photo-master-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
