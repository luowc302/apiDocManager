$(document).ready(function () {
    editProjectName();
    requestList();
    addMember();
    updatePrivate();
});
/**
 * 编辑项目名称
 * @returns {undefined}
 */
function editProjectName() {
    $('#save_name').click(function () {
        var project_name = $('#projetc_name').val();
        var _token = $('#_token').val();
        var project_di = $('#project_id').val();
        $.ajax({
            cache: true,
            type: "POST",
            url: "project-doEdit",
            data: {
                'project_name': project_name,
                '_token': _token,
                'projetcId': project_di,
            },
            async: true,
            success: function (res) {
                    var msg = "success";
                    if (res.code == 0) {
                        msg = "warning";
                    }
                    var info = '</br><div class="alert alert-' + msg + '">' + res.msg + '</div>';
                    $('#project_div_edit').empty();
                    $("#project_div_edit").append(info);
                    requestList();
            }
        });
    });
}
/**
 * 添加成员
 * @returns {undefined}
 */
function addMember() {
    $('#memberSubmit').click(function () {
        $.ajax({
            cache: true,
            type: "POST",
            url: "add-member",
            data: $('#memberForm').serialize(),
            async: true,
            success: function (res) {
                if (res.code = 1) {
                    var msg = "success";
                    if (res.code == 0) {
                        msg = "warning";
                    }
                    var info = '</br><div class="alert alert-' + msg + '">' + res.msg + '</div>';
                    $('#form_div_add').empty();
                    $("#form_div_add").append(info);
                    requestList();
                }
            }
        });
    });
}

/**
 * 请求列表
 * @author luowencai 2017/5/4
 * @param {type} pageSend
 * @returns {undefined}
 */
function requestList(pageSend) {
    if(typeof(pageSend) == "undefined" || pageSend == "" || pageSend == null){
        pageSend = 1;
    }
    var project_id = $('#project_id').val();
    $.ajax({
        cache: true,
        type: "GET",
        url: "member-list?page="+ pageSend + "&project_id=" + project_id,
        success: function (res) {
            if (res.code == 1) {
                $('#J-body').empty();
                $("#J-body").append(createMemberList(res));
                $('#J-pagination').empty();
                $("#J-pagination").append(createPaginateList(res));
                pageClick();//请求成功后重新绑定事件
                member_op();//异步成功后才能绑定点击事件
                delPrivalidge();
            }
        }
    });
}

/**
 * 成员列表构建
 * @param {type} res
 * @returns {undefined}
 */
function createMemberList(res) {
    var memberList = '<tr><th>姓名</th><th>权限</th><th>操作</th></tr>';
    for (var i = 0; i < res.data.data.length; i++) {
        memberList += '<tr><th scope="row">' + res.data.data[i].user_name + '</th><td>' + res.data.data[i].indentifyName + '</td><td><a class="member_edit" data-toggle="modal" data-target="#membe-private" data-id=' + res.data.data[i].id + ' style="cursor:pointer">编辑</a><a class="member_delete" data-id=' + res.data.data[i].id + '  style="cursor:pointer">删除</a></td></tr>';
    }
    return memberList;
}
/**
 * 绑定id到模态框
 * @returns {undefined}
 */
function member_op() {
    $('.member_edit').click(function () {
        var privateData = $(this).attr('data-id');
        $('#private_id').val(privateData);
    });
//    $('.member_delete').click(function(){
//        var thisdata = $(this).attr('data-id');
//    });
}

/**
 * 编辑成员权限
 * @author luowencai 2017/5/5
 * @returns {undefined}
 */
function updatePrivate() {
    $('#memberUpdate').click(function () {
        $.ajax({
            cache: true,
            type: "POST",
            url: "edit_Private",
            data: $('#editMemberForm').serialize(),
            async: true,
            success: function (res) {
                if (res.code = 1) {
                    var msg = "success";
                    if (res.code == 0) {
                        msg = "warning";
                    }
                    var info = '</br><div class="alert alert-' + msg + '">' + res.msg + '</div>';
                    $('#form_div_edit').empty();
                    $("#form_div_edit").append(info);
                    requestList();
                }
            }
        });
    });
}

/**
 * 删除项目成员
 * @returns {undefined}
 */
function delPrivalidge(){
    $('.member_delete').click(function () {
        var prvId = $(this).attr('data-id');
        $.ajax({
            cache: true,
            type: "GET",
            url: "delete-privalidge?private_id=" + prvId,
            success: function (res) {
                if (res.code === 1) {
                   requestList();
                }
                else{
                    alert(res.msg);
                }
            }
        });
    });
}


