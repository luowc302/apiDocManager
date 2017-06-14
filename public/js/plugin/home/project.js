$(document).ready(function () {//文档初始化
    var defaultPage = 1;
    requestList(defaultPage);
    addProject();
    joinList();
});
/**
 * 请求列表
 * @author luowencai 2017/5/4
 * @param {type} pageSend
 * @returns {undefined}
 */
function requestList(pageSend) {
    $.ajax({
        cache: true,
        type: "GET",
        url: "project-list?page=" + pageSend,
        success: function (res) {
            if (res.code == 1) {
                $('#J-body').empty();
                $("#J-body").append(createProjectList(res));
                $('#J-pagination').empty();
                $("#J-pagination").append(createPaginateList(res));
                pageClick();//请求成功后重新绑定事件
            }
        }
    });
}
/**
 * 添加项目
 * @author luowencai 2017/5/4
 * @returns {undefined}
 */
function addProject() {
    //添加项目名
    $("#projectSubmit").click(function () {
        $.ajax({
            cache: true,
            type: "POST",
            url: "addProject",
            data: $('#projectForm').serialize(), // 你的formid
            error: function (request) {
                var info = '</br><div class="alert alert-danger">连接出错</div>';
                $('#form_div').empty();
                $("#form_div").append(info);
            },
            success: function (data) {
                var msg = "success";
                if (data.code == 0) {
                    msg = "warning";
                }
                var info = '</br><div class="alert alert-' + msg + '">' + data.msg + '</div>';
                $('#form_div').empty();
                $("#form_div").append(info);
                //加载项目列表分页
//                    $("#commonLayout_appcreshi").parent().html(data);
            }
        });
    });
}

/**
 * 已参与列表
 * @param {type} pageSend
 * @returns {undefined}
 */
function joinList() {
    var pageSend = 1;
    $('#join-project').click(function () {
        $.ajax({
            cache: true,
            type: "GET",
            url: "join-list?page=" + pageSend,
            success: function (res) {
                if (res.code == 1) {
                    $('#J-body-join').empty();
                    $("#J-body-join").append(createJoinList(res));
                    $('#J-pagination-join').empty();
                    $("#J-pagination-join").append(createPaginateList(res));
                    pageClick();//请求成功后重新绑定事件
                }
            }
        });
    });
}

function createJoinList(res) {
    var memberList = '<tr><th>项目</th><th>权限</th><th>操作</th></tr>';
    for (var i = 0; i < res.data.total; i++) {
        memberList += '<tr><td scope="row"><a href="page-show?id=' + res.data.data[i]['project_id'] + '">' + res.data.data[i]['project_name'] + '</a></td><td>' + res.data.data[i]['private_name'] + '</td><td><a href=page-show?id=' + res.data.data[i]['project_id'] + ' style="cursor:pointer">进入项目</a></td></tr>';
    }
    return memberList;
}
/**
 * 创建项目列表
 * @author luowencai 2017/5/4
 * @param {type} res
 * @returns {undefined}
 */
function createProjectList(res) {
    var projectList = '<tr><th scope="row">ID</th><td>项目名</td><td>创建时间</td><td>操作</td></tr>';
    for (var i = 0; i < res.data.data.length; i++) {
        projectList += '<tr><th scope="row">' + res.data.data[i]['id'] + '</th><td><a href=page-show?id=' + res.data.data[i]['id'] + '>' + res.data.data[i]['project_name'] + '</a></td><td>' + res.data.data[i]['add_time'] + '</td><td><a href=page-show?id=' + res.data.data[i]['id'] + ' style="cursor:pointer">进入项目</a>&nbsp;<a href=project-edit?id=' + res.data.data[i]['id'] + ' style="cursor:pointer">设置</a></td></tr>';
    }
    return projectList;
}