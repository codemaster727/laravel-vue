<!DOCTYPE html>
<html>
@include("../components/head")
<body>

    <div id="app">
        <main>
            <!-- <div class="l-alart errorAlart">
            <p>未入力の項目があります。</p>
            </div> -->
            <div class="l-wrap l-wrap--form">
                <manager-sponcer-confirm-component v-bind:advertise_id="{{ $advertise_id }}"></manager-sponcer-confirm-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
