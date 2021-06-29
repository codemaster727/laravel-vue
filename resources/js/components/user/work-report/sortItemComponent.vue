<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">PDF用写真を並び替える</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__list">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__list__block">
                    <ul class="noLink">
                        <li v-for="i in 6">
                            <label class="l-order__wrap l-flex">
                                <div class="l-order__detail l-flex">
                                    <div class="c-detail--img">
                                        <img src="/img/384597_s.png">
                                    </div>
                                    <div class="c-detail--text">
                                        <p class="c-detail--text__headline">足場</p>
                                        <p class="c-detail--text__other">
                                            <span>2020-12-10</span>
                                            <span>撮影者名前</span>
                                        </p>
                                        <p class="c-detail--text__other">撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容</p>
                                    </div>
                                </div>
                                <div class="l-order__area">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </label>
                        </li>
                    </ul>
                </div>
                
            </div>
            <div class="l-button--submit">
                <input class="c-button--yellowRounded" type="submit" name="" value="変更内容を保存する">
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
        },
        computed: {},
        methods: {
        },
        watch: {},
    }
</script>