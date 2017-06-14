<div class="modal fade rotate" id="transfer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">转交项目</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
               <form role="form" id="transfer_act">
                    <div class="form-group">
                        <label for="name">用户名</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="键入转交的用户名">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="project_id" id="project_id" value="">
                        <div  id="form_div_transfer"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">    
                <a href="#" data-dismiss="modal" class="btn button_close">关闭</a>
                <a href="#" class="btn btn-primary" id="modal_transfer_save">保存</a>
            </div>
        </div>
    </div>
</div>