$(document).ready(function () {
    memberList();
});


/**
 * 需要绑定的动作集合
 * @returns {undefined}
 */
function actionList(){
    pageClick();//分页点击事件
    submitOption();
    reset();
}

/**
 * 提交对用户的操作
 * @returns {undefined}
 */
function submitOption(){
    $('.user_toggle').click(function(){
        var id = $(this).attr('data-id');
        var url = 'toggle?id=' + id;
        requestSetting(url);
    });
}

/**
 * 用户密码重置
 * @returns {undefined}
 */
function reset(){
    $('.user_reset').click(function(){
        var id = $(this).attr('data-id');
        var url = 'reset?id=' + id;
        reqReset(url);
    });
}

/**
 * 请求密码重置
 * @param {type} url
 * @returns {undefined}
 */
function reqReset(url){
    $.ajax({
        cache:true,
        type: 'GET',
        url: url,
        success:function(res){
          if(res.code === 0){
              alert(res.msg);
          }
          else{
              alert(res.msg + '' + res.data['password']);
              memberList();
          }
        }
    });
}

/**
 * 请求操作
 * @param {type} url
 * @returns {undefined}
 */
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
              memberList();
          }
        }
    });
}

/**
 * 成员列表
 * @returns {undefined}
 */
function memberList() {
    var url = 'user-list';
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
    var url = 'user-list';
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
                actionList();//请求成功后重新绑定事件
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
    var memberList = '<tr><th>姓名</th><th>邮箱</th><th>创建时间</th><th>最后一次登陆</th><th>状态</th><th>操作</th></tr>';
    for (var i = 0; i < res.data.data.length; i++) {
        memberList += '<tr>';
        memberList += '<th scope="row">' + res.data.data[i].user_name + '</th><td>' + res.data.data[i].email + '</td><td>' + res.data.data[i].created_at + '</td><td>' + res.data.data[i].updated_at + '</td><td>' + res.data.data[i].used_name + '</td>';
        memberList += '<td><a class="user_reset" data-id=' + res.data.data[i].id + ' style="cursor:pointer">重置密码</a>&nbsp;<a class="user_toggle" data-id=' + res.data.data[i].id + '  style="cursor:pointer">' + res.data.data[i].show_name + '</a></td>';
        memberList += '</tr>';
    }
    return memberList;
}