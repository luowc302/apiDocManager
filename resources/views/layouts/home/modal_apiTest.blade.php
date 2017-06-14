<div class="modal fade rotate" id="apiTest">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close clear_content" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">测试接口</h4>
                <br/>
                <div class="form-inline"> 
                    <form role="form" id="apiTest_form">
                        <span class="glyphicon glyphicon-plus"></span>
                        <a class="btn btn-default click-select" style="border:none"><input type="hidden" class="select" value="0" />参数</a> 
                        <a class="btn btn-default click-select" style="border:none"><input type="hidden" class="select" value="1" />Cookies</a>
                        <a class="btn btn-default click-select" style="border:none"><input type="hidden" class="select" value="2" />Header</a> 
                        <label for="name">提交方式</label> 
                        <label class="checkbox-inline">
                            <input type="radio" name="method" value="0" checked>POST
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="method" value="1">GET
                        </label>
                </div>
            </div>
            <ul class="nav nav-pills">
                <li><a href="#" class="btn" id="modal_api_test">提交</a></li>
                <li><a href="#" class="btn" id="J-format-code">格式化Json</a></li>
                <li><a href="#" class="btn" id="J-format-xml">格式化Xml</a></li>
                <li><a href="#" class="btn clear_content">清空</a></li>
            </ul>
            <hr/>
            <div id="InputsWrapper">
                <div class="form-inline inputList"> 
                    <div id="field_1" class="form-group"></div> 
                    <div class="form-group removeOp"></div> 
                </div> 
            </div>
            <br/>
            <hr/>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">接口地址</label>
                    <input type="text" class="form-control url" name="url" placeholder="键入完整接口地址">
                </div>
            </div>
            </form>
            <div class="modal-footer">    
                <div id="api_test_info"></div>
            </div>
        </div>
    </div>
</div>