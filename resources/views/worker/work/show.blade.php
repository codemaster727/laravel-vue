<!DOCTYPE html>
<html>
@include("../components/head-worker")
<body>
    <div id="app">
        <main>
            <div class="l-worker">
                <div class="l-worker--wrap">
                    <worker-detail-index-component v-bind:work_id = "{{ $work_id }}"></worker-detail-index-component>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>