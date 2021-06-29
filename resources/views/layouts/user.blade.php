{{-- layouts --}}
@include("../components/head")
<body>
    <div id="app">
        @include("../components/nav")
        <div class="wrap flex__wrap f__start">
            @include("../components/sidebar")
            <div class="wrap__right">
            @include("../components/header")
            @yield('content')
            </div>
        </div>
    </div>
    @include("../components/footer")
</body>
</html>　
