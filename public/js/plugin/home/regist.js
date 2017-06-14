$(document).ready(function () {
    //注册操作
    $("#regist").click(function () {
        $.ajax({
            cache: true,
            type: "POST",
            url: "doRegist",
            data: $('#documentForm').serialize(), // 你的formid
            async: false,
            error: function (request) {
                var info = '连接出错';
                $('#info').empty();
                $("#info").append(info);
            },
            success: function (data) {
                var msg = "warning";
                if (data.code == 1) {
                    msg = "success";
                }
//                var info = '<div class="alert alert-' + msg + '">' + data.msg + '</div>';
                var info = data.msg;
                $('#info').empty();
                $("#info").append(info);
                if (data.code == 1) {
                    window.location.href = "/";
                }
//                    $("#commonLayout_appcreshi").parent().html(data);
            }
        });
    });
});