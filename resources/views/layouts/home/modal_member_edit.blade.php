<div class="modal fade" id="membe-private">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">权限编辑</h4>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <form role="form" id="editMemberForm">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="private_id" id="private_id" value=""/>
                        <label for="identify">权限</label>
                         <select class="form-control" name="identify">
                               @foreach ($identifys as $key => $identify)
                                <option value="{{$key}}">{{$identify}}</option>
                                @endforeach
                         </select>
                        <div id="form_div_edit"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">    
                <a href="#" data-dismiss="modal" class="btn">关闭</a>
                <a href="#" class="btn btn-primary" id="memberUpdate">保存</a>
            </div>
        </div>
    </div>
</div>