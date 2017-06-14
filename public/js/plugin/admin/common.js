/**
 * 统一GET请求
 * @param {type} url
 * @returns {undefined}
 */
function commonRequest(url) {
    $.ajax({
        cache: true,
        type: "GET",
        url: url,
        success: function (res) {
            if (res.code === 1) {
                $('#J-body').empty();
                $("#J-body").append(createList(res));
                $('#J-pagination').empty();
                $("#J-pagination").append(createPaginateList(res));
                actionList();//统一动作集合
            }
        }
    });
}

/**
 * 统一POST表单提交
 * @param {type} url
 * @param {type} formId
 * @param {type} infoId
 * @returns {undefined}
 */
function formRequest(url, formId, infoId) {
    var msg = '';
    $.ajax({
        cache: true,
        type: "POST",
        url: url,
        data: $('#' + formId).serialize(),
        async: true,
        success: function (res) {
            if (res.code === 1) {
                msg = "success";
                var info = '</br><div class="alert alert-' + msg + '">' + res.msg + '</div>';
                $('#' + infoId).empty();
                $('#' + infoId).append(info);
                redirectRequest();
            } else {
                msg = "warning";
                var info = '</br><div class="alert alert-' + msg + '">' + res.msg + '</div>';
                $('#' + infoId).empty();
                $('#' + infoId).append(info);
            }
        }
    });
}
