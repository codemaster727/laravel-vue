<!DOCTYPE html>
<html>
@include("../components/head-worker")
<body>
    <div id="app">
        <main>
            <worker-request-blackboard-component v-bind:work_id = "'{{ $work_id }}'"></worker-request-blackboard-component>
        </main>
    </div>
    @include("../components/nav-worker")
    @include("../components/footer")
</body>
</html>