{{-- layouts --}}

<body>
  <div id="app">
    {{-- <?php if (is_mobile()) { ?>
      @include("../components/nav")
    <?php } ?> --}}

    <div class="wrap flex__wrap f__start manage">
      @include("../components/manage-sidebar")
      <div class="wrap__right">
        <?php if (is_mobile()) { ?>
        @include("../components/manage-header")
        <?php } ?>
        <div class="allWrapper">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
  @include("../components/footer")
</body>
</html>　