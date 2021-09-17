
/* main application */
Minitoring.App = {
    getUrl: function(){
        return window.location.origin + '/';
    },
    getNewRecoveryCaptcha: function(){
        document.getElementById('recovery_captcha_img').src = this.getUrl() + 'auth/recovery/captcha?' + Math.random();
    }
}