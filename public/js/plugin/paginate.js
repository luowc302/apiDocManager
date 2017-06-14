//分页操作
/**
 * 页面点击操作
 * @author luowencai 2017/5/4
 * @returns {undefined}
 */
function pageClick() {
    $('.pageNumber').click(function () {
        var page = parseInt($(this).text());
        requestList(page);
    });
    $('.prev_page').click(function () {
        var current = parseInt($('#current').val());
        page = current - 1;
        if (page <= 0) {
            page = 1;
        }
        requestList(page);
    });
    $('.next_page').click(function () {
        var current = parseInt($('#current').val());
        var per_page = parseInt($('#per_page').val());
        page = current + 1;
        if (page > per_page) {
            page = per_page;
        }
        requestList(page);
    });
}
/**
 * 构建分页列表
 * @author luowencai 2017/5/4
 * @param {type} res
 * @returns {undefined}
 */
function createPaginateList(res) {
    var current = res.data.current_page;
    var per_page = res.data.last_page;
    var paginateSize = 4;
    var paginateList = '';
    var start = 1;
    if (per_page === 0) {

    } else {
        paginateList = '<li><a href="javascript:;" class="prev_page">&laquo;</a></li>';
    }
    if (per_page < paginateSize) {
        paginateSize = per_page;
        for (var i = 0; i < paginateSize; i++) {
            paginateList += '<li><a href="javascript:;" class="pageNumber">' + start + '</a></li>';
            start++;
        }
    } else {
        var first = current;
        var next = first + 1;
        var end = paginateSize + first;
        if (next > per_page) {
            start = per_page;
            end = per_page + 1;
        } else {
            start = current;
        }
        if (end > per_page) {
            end = per_page + 1;
        }
        for (var i = start; i < end; i++) {
            paginateList += '<li><a href="javascript:;" class="pageNumber">' + start + '</a></li>';
            start++;
        }
    }
    if (per_page === 0) {

    } else {
        paginateList += '<li><a href="javascript:;" class="next_page">&raquo;</a></li>';
        paginateList += '<li><a>共' + per_page + '页</a></li>';
    }
    paginateList += '<input type="hidden" id="current" value = "' + current + '"></input>';
    paginateList += '<input type="hidden" id="per_page" value = "' + per_page + '"></input>';
    return paginateList;
}