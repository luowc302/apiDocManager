$(document).ready(function () {
    projectList();
});

/**
 * 需要绑定的动作集合
 * @returns {undefined}
 */
function actionList(){
    pageClick();//分页点击事件
    projectDelete();
    transferOp();
    doTransfer();
    clearContent();
}

/**
 * 清空内容
 * @returns {undefined}
 */
function clearContent(){
    $('.close').click(function(){
        clearOp();
    });
    $('.button_close').click(function(){
        clearOp();
    });
}

/**
 * 清除动作
 * @returns {undefined}
 */
function clearOp() {
    $('#name').val('');
    $('#project_id').val('');
    $('#form_div_transfer').empty();
}

/**
 * 统一请求接口
 * @returns {undefined}
 */
function redirectRequest(){
    projectList();
}

/**
 * 删除动作
 * @returns {undefined}
 */
function projectDelete(){
    $('.project_delete').click(function(){
        var id = $(this).attr('data-id');
        var url = 'delete-project?id=' + id;
        requestProject(url);
    });
}

/**
 * 项目转让
 * @returns {undefined}
 */
function transferOp(){
    $('.project_transfer').click(function(){
        var id = $(this).attr('data-id');
        $('#project_id').val(id);
    });
}

/**
 * 操作转交项目
 * @returns {undefined}
 */
function doTransfer(){
    $('#modal_transfer_save').click(function(){
        var url = 'transfer-project';
        var formId = 'transfer_act';
        var infoId = 'form_div_transfer';
        formRequest(url, formId, infoId);
    });
}

/**
 * 删除请求
 * @param {type} url
 * @returns {undefined}
 */
function requestProject(url){
    $.ajax({
        cache:true,
        type: 'GET',
        url: url,
        success:function(res){
          if(res.code === 0){
              alert(res.msg);
          }
          else{
              projectList();
          }
        }
    });
}

/**
 * 成员列表
 * @returns {undefined}
 */
function projectList() {
    var url = 'project-listInf';
    commonRequest(url);
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
    var url = 'project-listInf';
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
    var projectList = '<tr><th>项目名</th><th>所有者</th><th>创建时间</th><th>操作</th></tr>';
    for (var i = 0; i < res.data.data.length; i++) {
        projectList += '<tr>';
        projectList += '<th scope="row">' + res.data.data[i].project_name + '</th><td>' + res.data.data[i].user_name + '</td><td>' + res.data.data[i].add_time + '</td><td><a class="project_delete" data-id=' + res.data.data[i].id + ' style="cursor:pointer">删除</a>&nbsp;<a class="project_transfer" data-toggle="modal" data-target="#transfer" data-id=' + res.data.data[i].id + '  style="cursor:pointer">转交</a></td>';
        projectList += '</tr>';
    }
    return projectList;
}