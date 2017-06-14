@extends('layouts.admin.master')
@section('page_head')
<script src="{{asset('js/plugin/admin/config_email.js')}}"></script>
@stop
@section('title', '邮箱配置')
@section('nav')
@include('layouts.admin.nav')
@stop
@section('content')
<div id="page-wrapper" >
    <div id="page-inner">              
        <!-- /. ROW  -->
        <form role="form" id="email_edit_form">
            <div class="form-group">
                <label for="title">驱动</label>
                <input type="text" class="form-control" name="MAIL_DRIVER" placeholder="邮箱驱动" value="{{env('MAIL_DRIVER')}}">
                <label for="title">邮箱服务器</label>
                <input type="text" class="form-control" name="MAIL_HOST" placeholder="邮箱服务器" value="{{env('MAIL_HOST')}}">
                <label for="title">端口</label>
                <input type="text" class="form-control" name="MAIL_PORT" placeholder="端口" value="{{env('MAIL_PORT')}}">
                <label for="title">身份验证用户名</label>
                <input type="text" class="form-control" name="MAIL_USERNAME" placeholder="身份验证用户名" value="{{env('MAIL_USERNAME')}}">
                <label for="title">身份验证密码</label>
                <input type="password" class="form-control" name="MAIL_PASSWORD" placeholder="身份验证密码" value="{{env('MAIL_PASSWORD')}}">
                <label for="title">邮箱加密方式</label>
                <input type="text" class="form-control" name="MAIL_ENCRYPTION" placeholder="邮箱加密方式" value="{{env('MAIL_ENCRYPTION')}}">
                <label for="title">发信人邮件地址</label>
                <input type="text" class="form-control" name="MAIL_ADDRESS" placeholder="发信人邮件地址" value="{{env('MAIL_ADDRESS')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div  id="form_email_tpl"></div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <a href="#" class="btn btn-primary" id="J-email">保存</a>
                <a href="#" class="btn" onclick="javascript :history.back(-1);">后退</a> 
            </div>
        </div>
        </form>
    </div>
    <!-- /. PAGE INNER  -->
</div>
@stop