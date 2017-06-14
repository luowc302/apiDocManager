<div class="modal fade" id="project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">新建项目</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form role="form" id="projectForm">
                    <div class="form-group">
                        <label for="name">项目名称</label>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" class="form-control" name="project_name" placeholder="项目名称">
                        <div  id="form_div"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">    
                <a href="#" data-dismiss="modal" class="btn">关闭</a>
                <a href="#" class="btn btn-primary" id="projectSubmit">保存</a>
            </div>
        </div>
    </div>
</div>