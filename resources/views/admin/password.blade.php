@extends('layouts.admin.master')
@section('page_head')
<script src="{{asset('js/plugin/admin/updatePsw.js')}}"></script>
@stop
@section('title', '修改密码')
@section('nav')
@include('layouts.admin.nav')
@stop
@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h3>修改密码</h3>   
            </div>
        </div>              
        <!-- /. ROW  -->
        <hr />
        <form role="form" id="updatePasswordForm">
            <div class="form-group col-lg-4 col-md-4">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="old_password">旧密码</label>
                <input type="password" class="form-control" name="old_password" placeholder="旧密码">
                <label for="new_password">新密码</label>
                <input type="password" class="form-control" name="new_password" placeholder="新密码">
                <label for="repeat_password">确认密码</label>
                <input type="password" class="form-control" name="repeat_password" placeholder="确认密码">
                <div id="form_password_update"></div>
                </br>
                <a href="#" class="btn btn-primary" id="passwordUpdate">保存</a>
            </div>
        </form>
        <!-- /. ROW  -->           
    </div>
    <!-- /. PAGE INNER  -->
</div>
@stop