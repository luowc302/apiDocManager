@extends('layouts.home.master')
@section('page_head')
<link rel="stylesheet" href="{{asset('css/plugin/install.css')}}" />
@stop
@section('title', '初始化管理员')
@section('content')
<form action="{{url('doInstall')}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="mycenter">
        <div class="mysign">
            <div class="col-lg-11 text-center text-info">
                <h3>初始化管理员</h3>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="user_name" placeholder="请输入管理员登入名" required autofocus/>
            </div>
            <div class="col-lg-10">
                <input type="password" class="form-control" name="password" placeholder="请输入密码" required autofocus/>
            </div>
            <div class="col-lg-10">
                <button type="submit" class="btn btn-success col-lg-12">安装</button>
            </div>
        </div>
    </div>
</form>
@stop