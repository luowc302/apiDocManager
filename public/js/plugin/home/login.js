$(document).ready(function () {
    //登入操作
    $("#login").click(function () {
        var url = 'auth/doLogin';
        var formId = '#documentForm';
        var redirectUrl = "/home/paner";
        login(url, formId, redirectUrl);
    });
});