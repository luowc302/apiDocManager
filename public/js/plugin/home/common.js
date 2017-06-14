$(document).ready(function () {
    modalZindex();
    paswUpdate();
});

function modalZindex() {
// 通过该方法来为每次弹出的模态框设置最新的zIndex值，从而使最新的modal显示在最前面
    $(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 2048 + (10 * ($('.modal:visible').length));
        $('.modal').css('z-index', zIndex);
    });
}

function paswUpdate(){
    $('#passwordUpdate').click(function(){
        $.ajax({
            cache: true,
            type: "POST",
            url: "update-password",
            data: $('#updatePasswordForm').serialize(), // 你的formid
            error: function (request) {
                var info = '</br><div class="alert alert-danger">连接出错</div>';
                $('#form_password_update').empty();
                $("#form_password_update").append(info);
            },
            success: function (data) {
                var msg = "success";
                if (data.code == 0) {
                    msg = "warning";
                }
                var info = '</br><div class="alert alert-' + msg + '">' + data.msg + '</div>';
                $('#form_password_update').empty();
                $("#form_password_update").append(info);
                //加载项目列表分页
//                    $("#commonLayout_appcreshi").parent().html(data);
            }
        });
    });
}

