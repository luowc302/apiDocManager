$(document).ready(function () {
    $("#template_select").change(function(){
     var tplId = $("#template_select").val();
     var url = 'tpl-detail?id='+ tplId;
     requestTemplate(url);
});
});

/**
 * 请求模板
 * @param {type} url
 * @returns {undefined}
 */
function requestTemplate(url){
    $.ajax({
            cache: true,
            type: "GET",
            url: url,
            error: function (request) {
                var info = '连接出错';
                alert(info);
            },
            success: function (res) {
                $('#tpl-content').val(res.data['content']);
                editorConfig();
            }
        });
}