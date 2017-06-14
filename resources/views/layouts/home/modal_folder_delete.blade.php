<div class="modal fade rotate" id="folder-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">删除目录</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
               <form role="form" id="folder_delete_form">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="project_id" id="project_id" value="{{ $project_id }}">
                        <label for="folder_id">目录</label>
                         <select class="form-control select-folder" name="id">
                         </select>
                        <div id="form_delete_folder"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">    
                <a href="#" data-dismiss="modal" class="btn">关闭</a>
                <a href="#" class="btn btn-primary" id="modal_floder_delete">保存</a>
            </div>
        </div>
    </div>
</div>