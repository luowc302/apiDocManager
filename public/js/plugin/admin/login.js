$(document).ready(function () {
    //登入操作
    $("#login").click(function () {
        var url = 'auth/admin/doLogin';
        var formId = '#documentForm';
        var redirectUrl = "/admin/paner";
        login(url, formId, redirectUrl);
    });
});

