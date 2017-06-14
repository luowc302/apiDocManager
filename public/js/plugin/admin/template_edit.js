$(document).ready(function () {
    actionList();
    $('#J-tpl-edit').click(function(){
        tplEdit();
    });
});

/**
 * 需要绑定的动作集合
 * @returns {undefined}
 */
function actionList(){
    editorConfig();
}

/**
 * 修改模板
 * @returns {undefined}
 */
function tplEdit(){
    $.ajax({
            cache: true,
            type: "POST",
            url: "edit-tpl",
            data: $('#tpl_edit_form').serialize(), // 你的formid
            error: function (request) {
                var info = '连接出错';
                alert(info);
            },
            success: function (data) {
                alert(data.msg);
                if(data.code === 1){
                    window.location.href = "template-list";
                }
            }
        });
}