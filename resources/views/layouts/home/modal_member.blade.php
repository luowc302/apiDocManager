<div class="modal fade" id="member">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">添加成员</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form role="form" id="memberForm">
                    <div class="form-group">
                        <label for="name">成员名称</label>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                        <input type="text" class="form-control" name="member_name" placeholder="成员名称">
                        <label for="identify">权限</label>
                         <select class="form-control" name="identify">
                               @foreach ($identifys as $key => $identify)
                                <option value="{{$key}}">{{$identify}}</option>
                                @endforeach
                         </select>
                        <div id="form_div_add"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">    
                <a href="#" data-dismiss="modal" class="btn">关闭</a>
                <a href="#" class="btn btn-primary" id="memberSubmit">保存</a>
            </div>
        </div>
    </div>
</div>