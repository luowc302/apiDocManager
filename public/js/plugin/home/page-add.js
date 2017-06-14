$(document).ready(function () {
    editorConfig();
    addPage();
});

/**
 * 添加文章
 * @returns {undefined}
 */
function addPage() {
    $("#submit-textarea").click(function () {
        $.ajax({
            cache: true,
            type: "POST",
            url: "add-page",
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
