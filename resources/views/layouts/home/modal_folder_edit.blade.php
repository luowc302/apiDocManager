<div class="modal fade rotate" id="folder-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">修改目录</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
               <form role="form" id="folder_edit_form">
                    <div class="form-group">
                        <label for="name">目录名称</label>
                        <input type="text" class="form-control" name="folder_name" placeholder="键入目录名称">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="project_id" id="project_id" value="{{ $project_id }}">
                        <label for="name">目录</label>
                         <select class="form-control select-folder" name="id">
                                
                         </select>
                        <label for="sort">排序</label>
                        <input type="text" class="form-control" name="sort" placeholder="排序(可选)">
                        <div id="form_edit_folder"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">    
                <a href="#" data-dismiss="modal" class="btn">关闭</a>
                <a href="#" class="btn btn-primary" id="modal_floder_edit">保存</a>
            </div>
        </div>
    </div>
</div>