var clickonce_flag = false;

$(function () {
    $('.clickonce').click(function () {
        if (clickonce_flag) {
//            console.log('disabled lock');
            return false;
        }
        clickonce_flag = true;
//        console.log('disabled start');
        setTimeout(function(){
            clickonce_flag = false;
//            console.log('disabled end');
        },1000);
        return true;
    });
});
