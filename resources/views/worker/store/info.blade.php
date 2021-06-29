<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header")
        <main>
            <div class="l-login">
                <div class="l-login__wrap">
                    <worker-request-register-component></worker-request-register-component>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>