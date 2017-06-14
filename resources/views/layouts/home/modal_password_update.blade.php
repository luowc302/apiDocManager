<div class="modal fade" id="password-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form role="form" id="updatePasswordForm">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label for="old_password">旧密码</label>
                        <input type="password" class="form-control" name="old_password" placeholder="旧密码">
                        <label for="new_password">新密码</label>
                        <input type="password" class="form-control" name="new_password" placeholder="新密码">
                        <label for="repeat_password">确认密码</label>
                        <input type="password" class="form-control" name="repeat_password" placeholder="确认密码">
                        <div id="form_password_update"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">    
                <a href="#" data-dismiss="modal" class="btn">关闭</a>
                <a href="#" class="btn btn-primary" id="passwordUpdate">保存</a>
            </div>
        </div>
    </div>
</div>