$(document).ready(function () {
    apiTestClick();
    clearContent();
    $('#modal_api_test').click(function () {
        requestTestApi();
    });
    formatXmlAction();
    formatCode();
});

function hightLight(){
    var editor = CodeMirror.fromTextArea(document.getElementById("text_area"), {
      lineNumbers: true,
      theme: "night",
      extraKeys: {
        "F11": function(cm) {
          cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        },
        "Esc": function(cm) {
          if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
        }
      }
    });
}

/**
 * 清空动作
 * @returns {undefined}
 */
function clearContent(){
    $('.clear_content').click(function(){
        $('#text_area').empty();
        $('.inputList').empty();
        $('.url').val("");
    });
}

/**
 * 请求api
 * @returns {undefined}
 */
function requestTestApi() {
    var url = 'run-test';
    var insertId = 'api_test_info';
    $.ajax({
        cache: true,
        type: "POST",
        url: url,
        data: $(':input').serialize(), // 你的formid
        error: function () {
            var info = '</br><div class="alert alert-danger">连接出错</div>';
            $('#' + insertId).empty();
            $('#' + insertId).append(info);
        },
        success: function (res) {
            var show = res.data;
            if (res.code === 0) {
                show = res.msg;
            }
            $('#' + insertId).empty();
            $('#' + insertId).append('<textarea id="text_area" class="text_area" readonly>' + show + '</textarea>');
        }
    });
}

/**
 * 格式化动作
 * @returns {undefined}
 */
function formatCode() {
    $('#J-format-code').click(function () {
        var code = formatJson($('#api_test_info').text());
        $('#text_area').empty();
        $('#text_area').append(code);
    });
}

/**
 * 格式化xml
 * @returns {undefined}
 */
function formatXmlAction() {
    $('#J-format-xml').click(function () {
        var code = '<textarea id="text_area">' + formatXml($('#api_test_info').text()) + '</textarea>';
        $('#api_test_info').empty();
        $('#api_test_info').append(code);
    });
}

/**
 * 接口测试点击
 * @returns {undefined}
 */
function apiTestClick() {

    var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID  

    var x = InputsWrapper.length; //initlal text box count  
    var FieldCount = 1; //to keep track of text box added  
    $(".click-select").click(function () {
        var data = parseInt($(this).children().val());
        var selectContent = '<div class="form-inline inputList"> ';

        FieldCount++; //text box added increment  				
        //add input box
        var inputContent = '';
        var name = 'keys';
        var values = 'values';
        var placeholder = '参数';
        var removeContent = '<a href="#" class="removeclass"><span class="glyphicon glyphicon-remove"></span></a> ';
        if (data === 1) {
            name = 'cookie_keys';
            values = 'cookie_values';
            placeholder = 'cookies';
        }
        if (data === 2) {
            name = 'header_keys';
            values = 'header_values';
            placeholder = 'header';
        }
        inputContent += '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="' + name + '[]" value="" class="form-control" placeholder="' + placeholder + '-键名" /> ';
        inputContent += '<input type="text" name="' + values + '[]" value="" class="form-control" placeholder="' + placeholder + '-键值" /> ';
        selectContent += '<div id="field_' + FieldCount + '" class="form-group">' + inputContent + '</div>&nbsp;';
        selectContent += '<div  class="form-group removeOp">' + removeContent + '</div>';
        selectContent += '</div>';
        $(InputsWrapper).append(selectContent);
        x++;

    });

    $("body").on("click", ".removeclass", function (e) { //user click on remove text  
        if (x > 1) {
            $(this).parent('div').parent('div').remove(); //remove text box  
            x--; //decrement textbox  
        }
        return false;
    });
}