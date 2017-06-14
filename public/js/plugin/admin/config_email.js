$(document).ready(function () {
    $('#J-email').click(function () {
        emailEdit();
    });
});

function emailEdit(){
    $.ajax({
        cache: true,
        type: "POST",
        url: "update-email",
        data: $('#email_edit_form').serialize(), // 你的formid
        error: function (request) {
            var info = '连接出错';
            alert(info);
        },
        success: function (data) {
            alert(data.msg);
            if (data.code === 1) {
                window.location.href = "email-config";
            }
        }
    });
}