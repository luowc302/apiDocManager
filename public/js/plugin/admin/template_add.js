$(document).ready(function () {
    actionList();
    $('#J-tpl-add').click(function () {
        tplAdd();
    });
});

/**
 * 需要绑定的动作集合
 * @returns {undefined}
 */
function actionList() {
    editorConfig();
}

/**
 * 添加模板
 * @returns {undefined}
 */
function tplAdd() {
    $.ajax({
        cache: true,
        type: "POST",
        url: "add-tpl",
        data: $('#tpl_add_form').serialize(), // 你的formid
        error: function (request) {
            var info = '连接出错';
            alert(info);
        },
        success: function (data) {
            alert(data.msg);
            if (data.code === 1) {
                window.location.href = "template-list";
            }
        }
    });
}