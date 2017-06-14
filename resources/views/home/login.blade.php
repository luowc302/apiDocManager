@extends('layouts.home.master')
@section('page_head')
<link rel="stylesheet" href="{{asset('css/plugin/login.css')}}" />
<script src="{{asset('js/plugin/home/login.js')}}"></script>
@stop
@section('title', '用户登陆')
@section('content')
<form method="post" id="documentForm">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="mycenter">
        <div class="mysign">
            <div class="col-lg-11 text-center text-info">
                <h3>用户登陆</h3>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="user_name" placeholder="请输入账户名或邮箱" required autofocus/>
            </div>
            <div class="col-lg-10"></div>
            <div class="col-lg-10">
                <input type="password" class="form-control" name="password" placeholder="请输入密码" required autofocus/>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="vrCode" placeholder="请输入验证码" required autofocus/>
            </div>
            <div class="col-lg-10 mycheckbox">
                <image src="{{url('vrcode')}}"  onclick="this.src ='{{url('vrcode')}}?'+Math.random()"/>
                <a href="{{url('/auth/regist')}}">注册</a>
            </div>
            <div class="col-lg-10">
                <button type="button" class="btn btn-success col-lg-12" id="login">登录</button>
            </div>
        </div>
        <div class="col-lg-11 alert text-center text-danger" id="info"></div>
    </div>
</form>
@stop