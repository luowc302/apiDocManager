/**
 * 前后台公用部分js
 */
/**
 * 登入操作
 * @param {type} url
 * @param {type} formId
 * @param {type} redirectUrl
 * @returns {undefined}
 */
function login(url, formId, redirectUrl) {
    $.ajax({
        cache: true,
        type: "POST",
        url: url,
        data: $(formId).serialize(), // 你的formid
        async: false,
        error: function () {
            var info = '连接出错';
            $('#info').empty();
            $("#info").append(info);
        },
        success: function (data) {
            var info = data.msg;
            $('#info').empty();
            $("#info").append(info);
            if (data.code === 1) {
                window.location.href = redirectUrl;
            }
        }
    });
}

