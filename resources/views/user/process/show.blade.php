<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <body>
        @include("../components/nav")

        <div id="app">
            @include("../components/header-user")
            <main>
                <div class="l-main">
                    <div class="allWrapper">
                        <div class="l-main__wrap">
                            <user-process-show-component :id="{{ $id }}" />
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @include("../components/footer")
    </body>
    </html>
