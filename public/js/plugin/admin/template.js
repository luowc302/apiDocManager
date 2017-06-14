$(document).ready(function () {
    tplList();
});

/**
 * 需要绑定的动作集合
 * @returns {undefined}
 */
function actionList(){
    pageClick();//分页点击事件
    tplDelete();
}

/**
 * 删除模板
 * @returns {undefined}
 */
function tplDelete(){
    $('.tpl-delete').click(function(){
        var id = $(this).attr('data-id');
        var url = 'del-tpl?id=' + id;
        requestAction(url);
    });
}

/**
 * 请求删除
 * @param {type} url
 * @returns {undefined}
 */
function requestAction(url){
    $.ajax({
        cache:true,
        type: 'GET',
        url: url,
        success:function(res){
          if(res.code === 0){
              alert(res.msg);
          }
          else{
              tplList();
          }
        }
    });
}

/**
 * 统一请求接口
 * @returns {undefined}
 */
function redirectRequest(){
    tplList();
}


/**
 * 模板列表
 * @returns {undefined}
 */
function tplList() {
    var url = 'tpl-list';
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
    var url = 'tpl-list';
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
    console.log(res);
    var tplList = '<tr><th>模板名</th><th>创建时间</th><th>操作</th></tr>';
    for (var i = 0; i < res.data.data.length; i++) {
        tplList += '<tr>';
        tplList += '<th scope="row">' + res.data.data[i].title + '</th><td>' + res.data.data[i].add_time + '</td><td><a class="tpl-delete" data-id=' + res.data.data[i].id + ' style="cursor:pointer">删除</a>&nbsp;<a class="tpl_edit"  href="tpl-edit?id=' + res.data.data[i].id + '" style="cursor:pointer">编辑</a></td>';
        tplList += '</tr>';
    }
    return tplList;
}