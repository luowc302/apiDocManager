$(document).ready(function () {
    //页面数据加载
    folderList();
    //绑定无关动作集合
    actionList();
});

/**
 * 动作集合
 * @returns {undefined}
 */
function actionList() {
    searchOp();
    addFolder();
    addPageOp();
    editFolder();
    deleteFolder();
    editPageOp();
    deletePageOp();
}

/**
 * 导出md文档
 * @returns {undefined}
 */
function importMd() {
    $('#J-md-generate').click(function () {
        var page_id = $('.page_id').val();
        var url = "page-detail?id=" + page_id + '&type=1';
        window.location.href = url;
    });
}

/**
 * 到处word文档
 * @returns {undefined}
 */
function importDoc() {
    $('#J-word-generate').click(function () {
        var page_id = $('.page_id').val();
        var url = "page-detail?id=" + page_id + '&type=2';
        window.location.href = url;
    });
}

/**
 * 添加动作
 * @returns {undefined}
 */
function addPageOp() {
    $('#J-newPage').click(function () {
        var add_url = $('#add_url').val();
        var project_id = $('#project_id').val();
        window.location.href = add_url + "?project_id=" + project_id;
    });
}

/**
 * 编辑动作
 * @returns {undefined}
 */
function editPageOp() {
    $('#J-editPage').click(function () {
        var edit_url = $('#edit-url').val();
        var page_id = $('.page_id').val();
        window.location.href = edit_url  + page_id;
    });
}

/**
 * 删除动作
 * @returns {undefined}
 */
function deletePageOp() {
    $('#J-deletePage').click(function () {
        var delete_url = $('#delete_url').val();
        var page_id = $('.page_id').val();
        var url = delete_url + page_id;
        $.ajax({
            cache: true,
            type: "GET",
            url: url,
            success: function (res) {
                if (res.code === 1) {
                    folderList();
                }
                else {
                    alert(res.msg);
                }
            }
        });
    });
}

/**
 * 查找动作
 * @returns {undefined}
 */
function searchOp() {
    $('.search').click(function () {
        var title = $('.search-title').val();
        var project_id = $('#project_id').val();
        var url = 'search-page?title=' + title + '&project_id=' + project_id;
        requestSearch(url);
    });
}

/**
 * 查找文章
 * @param {type} url
 * @returns {undefined}
 */
function requestSearch(url) {
    $.ajax({
        cache: true,
        type: "GET",
        url: url,
        success: function (res) {
            if (res.code === 1) {
                $('#J-title-list').empty();
                $("#J-title-list").append(createSearchList(res));
                pageDetail();
            } else {
                 var msg = '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a>' + res.msg + '</div>';
                $('#J-title-list').empty();
                $("#J-title-list").append(msg);
            }
        }
    });
}

/**
 * 创建搜索列表
 * @param {type} res
 * @returns {String}
 */
function createSearchList(res){
    var titleList = '<ul class="special">';
    for (var i = 0; i < res.data.length; i++) {
        titleList += '<a class="list-group-item page" data-page_id="' + res.data[i]['id'] + '"">' + res.data[i]['title'] + '</a>';
    }
    titleList += '</ul>';
    return titleList;
}
/**
 * 默认页面
 * @returns {undefined}
 */
function pageDefault() {
    var project_id = $('#project_id').val();
    var url = "page-detail?project_id=" + project_id;
    $.ajax({
        cache: true,
        type: "GET",
        url: url,
        success: function (res) {
            if (res.code === 1) {
                $('.list-group-item').removeClass('active');
                $('[data-page_id="' + res.data.id + '"]').addClass('active');
                $('#option').empty();
                $('#option').append('<a class="btn btn-default btn-sm"id="J-md-generate">生成MarkDown文档</a>');
                $('#test-editormd-view2').empty();
                $('#test-editormd-view2').append('<textarea>' + res.data.content + '</textarea>');
                $('.page_id').val(res.data.id);
                markDownTohtm();
                importMd();
                importDoc();
            } else {
                $('.layout').empty();
                $('#J-delete').empty();
            }
        }
    });
}

/**
 * 请求页面
 * @returns {undefined}
 */
function pageDetail(){
    $('.list-group-item.page').click(function(){
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
        pageDetailMethod(this);
    });
}

/**
 * 顶级文章请求
 * @returns {undefined}
 */
function topPageDetail(){
    $('.list-group-item.TopPage').click(function(){
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
        pageDetailMethod(this);
    });
}

/**
 * 次级文章请求
 * @returns {undefined}
 */
function scPageDetail(){
    $('.list-group-item.scPage').click(function(){
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
        pageDetailMethod(this);
    });
}

/**
 * 请求页面方法
 * @param {type} object
 * @returns {undefined}
 */
function pageDetailMethod(object){
    var page_id = $(object).attr('data-page_id');
    var url = "page-detail?id=" + page_id;
    requestPageDetail(url);
}

/**
 * 请求文章详情
 * @param {type} url
 * @returns {undefined}
 */
function requestPageDetail(url){
    $.ajax({
        cache: true,
        type: "GET",
        url: url,
        success: function (res) {
            if (res.code === 1) {
                $('#option').empty();
                $('#option').append('<a class="btn btn-default btn-sm"id="J-md-generate">生成MarkDown文档</a>');
                $('#test-editormd-view2').empty();
                $('.page_id').val(res.data.id);
                $('#test-editormd-view2').append('<textarea>'+res.data.content+'</textarea>');
                markDownTohtm();
                importMd();
            }
            else{
                $('.layout').empty();
                $('#J-delete').empty();
            }
        }
    });
}
/**
 * 添加文件夹
 * @author luowencai 2017/5/6
 * @returns {undefined}
 */
function addFolder(){
    $("#modal_floder_save").click(function () {
        var url = 'folder-add';
        var formId = '#folder_add';
        var insertId = '#form_div_folder';
        requestFolder(url, formId, insertId);
    });
}

/**
 * 编辑目录
 * @returns {undefined}
 */
function editFolder() {
    $('#modal_floder_edit').click(function () {
        var url = 'folder-edit';
        var formId = '#folder_edit_form';
        var insertId = '#form_edit_folder';
        requestFolder(url, formId, insertId);
    });
}

/**
 * 删除目录
 * @returns {undefined}
 */
function deleteFolder(){
     $('#modal_floder_delete').click(function () {
        var url = 'folder-delete';
        var formId = '#folder_delete_form';
        var insertId = '#form_delete_folder';
        requestFolder(url, formId, insertId);
    });
}

/**
 * 统一模态框请求表单数据处理
 * @param {type} url
 * @param {type} formId
 * @param {type} insertId
 * @returns {undefined}
 */
function requestFolder(url, formId, insertId) {
    $.ajax({
        cache: true,
        type: "POST",
        url: url,
        data: $(formId).serialize(), // 你的formid
        error: function (request) {
            var info = '</br><div class="alert alert-danger">连接出错</div>';
            $(insertId).empty();
            $(insertId).append(info);
        },
        success: function (res) {
            var msg = "success";
            if (res.code === 0) {
                msg = "warning";
            }
            info = '</br><div class="alert alert-' + msg + '">' + res.msg + '</div>';
            $(insertId).empty();
            $(insertId).append(info);
            folderList();
        }
    });
}

/**
 * 请求文件夹列表
 * @returns {undefined}
 */
function folderList(){
    var project_id = $('#project_id').val();
    $.ajax({
        cache: true,
        type: "GET",
        url: "folder-list?project_id=" + project_id,
        success: function (res) {
            if (res.code === 1) {
                $('#J-title-list').empty();
                $("#J-title-list").append(createFolderList(res));
                $('.top-folder').empty();
                $('.top-folder').append(createToplist(res));
                $('.select-folder').empty();
                $('.select-folder').append(createSelectList(res));
            }
            else{
                $('#J-title-list').empty();
                $("#J-title-list").append(res.msg);
            }
            pageDefault();
            changeSelect();
            scPageDetail();
            topPageDetail();
            pageDetail();
        }
    });
}

/**
 * 菜单点击效果
 * @returns {undefined}
 */
function changeSelect(){
    $('.open').click(function(){
        var className = $(this).children().attr('class');
        var attendClass = 'glyphicon glyphicon-chevron-right';
        if(className === attendClass){
            attendClass = 'glyphicon glyphicon-chevron-down';
        }
        $(this).children().removeClass();
        $(this).children().addClass(attendClass);
    });
}

/**
 * 创建顶级目录
 * @param {type} res
 * @returns {String}
 */
function createToplist(res){
    var selectList = '<option value="0" style="font-weight:bold">根目录</option>';
    for (var i = 0; i < res.data.length; i++) {
        if (res.data[i]['pid'] === 0) {
            selectList += '<option value="' + res.data[i]['id'] + '">|-' + res.data[i]['folder_name'] + '</option>';
        }
    }
    return selectList;
}

/**
 * 创建目录
 * @param {type} res
 * @returns {String}
 */
function createSelectList(res) {
    var selectList = '';
    for (var i = 0; i < res.data.length; i++) {
        if (res.data[i]['pid'] === 0) {
            selectList += '<option value="' + res.data[i]['id'] + '" style="font-weight:bold">' + res.data[i]['folder_name'] + '</option>';
            for (var j = 0; j < res.data[i]['follow'].length; j++) {
                selectList += '<option value="' + res.data[i]['follow'][j]['id'] 
                + '" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-' 
                + res.data[i]['follow'][j]['folder_name'] + '</option>';
            } 
        }
    }
    return selectList;
}

/**
 * 构建文件夹列表
 * @param {type} res
 * @returns {String}
 */
function createFolderList(res) {
    var folderList = '';
    var special = 'in';
    for (var i = 0; i < res.data.length; i++) {
        if (res.data[i]['pid'] === 0) {
            var length = res.data[i]['follow'].length;
            var pageLength = res.data[i]['pages'].length;
            i !== 0 ? special = 'on':null;
            if (length === 0) {
                //点击异步实现第二级显示标题列表
                folderList += '<a class="list-group-item root open" data-toggle="collapse" data-parent="#accordion" href="#collapseOne' + i + '" data-fid="' + res.data[i]['id'] + '"><span class="glyphicon glyphicon-chevron-right"></span>' + res.data[i]['folder_name'] + '</a>';
                if(pageLength !== 0){
                    folderList += '<ul id="collapseOne' + i + '"class="nav collapse">';
                    for (var j = 0; j < pageLength; j++) {
                        //显示标题
                        folderList += '<a class="list-group-item TopPage" data-page_id="' + res.data[i]['pages'][j]['id'] + '"">' + res.data[i]['pages'][j]['title'] + '</a>';
                    }
                    folderList += '</ul>';
                }
            } else {
                folderList += '<a class="list-group-item open"  data-toggle="collapse" data-parent="#accordion" href="#collapseOne' + i + '"><span class="glyphicon glyphicon-chevron-right"></span>' + res.data[i]['folder_name'] + '</a>';
                folderList += '<ul id="collapseOne' + i + '" class="collapse ' + special + '">';
                for (var k = 0; k < length; k++) {
                    //显示目录
                    folderList += '<a class="list-group-item follow open" data-fid="' + res.data[i]['follow'][k]['id'] + '"" data-toggle="collapse" data-parent="#accordion" href="#collapse_' + i + '_Follow' + k + '"><span class="glyphicon glyphicon-chevron-right"></span>' + res.data[i]['follow'][k]['folder_name'] + '</a>';
                    
                    var followPageLt = res.data[i]['follow'][k]['pages'].length;
                    if (followPageLt !== 0) {
                        var followPage = res.data[i]['follow'][k]['pages'];
                        folderList += '<ul id="collapse_' + i + '_Follow' + k + '" class="collapse ' + special + '">';
                        for (var j = 0; j < followPageLt; j++) {
                            folderList += '<a class="list-group-item page" data-page_id="' + followPage[j]['id'] + '"">' + followPage[j]['title'] + '</a>';
                        }
                        folderList += '</ul>';
                    }
                }
                if (pageLength !== 0) {
                    for (var j = 0; j < pageLength; j++) {
                        //显示标题
                        folderList += '<a class="list-group-item scPage" data-page_id="' + res.data[i]['pages'][j]['id'] + '"">' + res.data[i]['pages'][j]['title'] + '</a>';
                    }
                }
                folderList += '</ul>';
            }
        }
        else{
            folderList += '<a class="list-group-item TopPage" data-page_id="' + res.data[i]['id'] + '"">' + res.data[i]['title'] + '</a>';
        }
    }
    return folderList;
}