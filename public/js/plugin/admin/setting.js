$(document).ready(function () {
    settingList();
});

/**
 * 成员列表
 * @returns {undefined}
 */
function settingList() {
    var url = 'show-function';
    commonRequest(url);
}

/**
 * 需要绑定的动作集合
 * @returns {undefined}
 */
function actionList(){
    pageClick();//分页点击事件
    submitSetting();//提交设置
}

/**
 * 提交设置
 * @returns {undefined}
 */
function submitSetting(){
    $('.submit-setting').click(function(){
        var id = $(this).attr('data-id');
        var url = 'set-function?configId=' + id;
        requestSetting(url);
    });
}

function requestSetting(url){
    $.ajax({
        cache:true,
        type: 'GET',
        url: url,
        success:function(res){
          if(res.code === 0){
              alert(res.msg);
          }
          else{
              settingList();
          }
        }
    });
}

/**
 * 请求操作
 * @param {type} pageSend
 * @returns {undefined}
 */
function requestList(pageSend) {
    if(typeof(pageSend) == "undefined" || pageSend == "" || pageSend == null){
        pageSend = 1;
    }
    var url = 'show-function';
    $.ajax({
        cache: true,
        type: "GET",
        url: url + "?page="+ pageSend,
        success: function (res) {
            if (res.code == 1) {
                $('#J-body').empty();
                $("#J-body").append(createList(res));
                $('#J-pagination').empty();
                $("#J-pagination").append(createPaginateList(res));
                actionList();
            }
        }
    });
}

/**
 * 创建用户列表
 * @param {type} res
 * @returns {String}
 */
function createList(res) {
    var settingList = '';
    for (var i = 0; i < res.data.data.length; i++) {
        settingList += '<tr><th scope="row">' + res.data.data[i].name + '</th><td>' + res.data.data[i].use_info + '</td>';
        settingList += '<td><a class="btn btn-primary submit-setting input-sm" data-id=' + res.data.data[i].id + ' style="cursor:pointer">' + res.data.data[i].show_name + '</a></td>';
        settingList += '</tr>';
    }
    return settingList;
}