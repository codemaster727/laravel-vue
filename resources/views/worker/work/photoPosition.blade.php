<!DOCTYPE html>
<html>
@include("../components/head-worker")
<body>
    <div id="app">
        <main>
            <!-- 固定された黒板のサイズを入力 -->
            <worker-request-blackboard-store-component
                v-bind:work_id="{{ $work_id }}"
                v-bind:charger="'{{ $name }}'"
                v-bind:content="'{{ $content }}'"
                v-bind:worker_name="'{{ Auth::guard('worker')->user()->name }}'"
                v-bind:blackboard_width="200"
                v-bind:blackboard_height="120">
            </worker-request-blackboard-store-component>
        </main>
    </div>
    @include("../components/nav-worker")
    @include("../components/footer")
</body>
</html>
