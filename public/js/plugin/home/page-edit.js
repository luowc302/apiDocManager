$(document).ready(function () {
    editorConfig();
    pageEdit();
});

function pageEdit() {
    $("#submit-textarea").click(function () {
        $.ajax({
            cache: true,
            type: "POST",
            url: "edit-page",
            data: $('#textearea-form').serialize(), // 你的formid
            error: function (request) {
                var info = '连接出错';
                alert(info);
            },
            success: function (data) {
                alert(data.msg);
                var project_id = $('#project_id').val();
                window.location.href = "page-show?id=" + project_id;
            }
        });
    });
}
