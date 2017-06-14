@extends('layouts.home.master')
@section('page_head')
<link rel="stylesheet" href="{{asset('css/plugin/login.css')}}" />
<script src="{{asset('js/plugin/home/regist.js')}}"></script>
@stop
@section('title', '用户注册')
@section('content')
<form method="post" id="documentForm">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="mycenter">
        <div class="mysign">
            <div class="col-lg-11 text-center text-info">
                <h3>注册信息</h3>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="user_name" placeholder="请输入账户名" required autofocus/>
            </div>
            <div class="col-lg-10">
                <input type="email" class="form-control" name="email" placeholder="邮箱" required autofocus/>
            </div>
            <div class="col-lg-10">
                <input type="password" class="form-control" name="password" placeholder="请输入密码" required autofocus/>
            </div>
            <div class="col-lg-10">
                <input type="password" class="form-control" name="confirmPass" placeholder="重复密码" required autofocus/>
            </div>
            <!--                        <div class="col-lg-10">
                                        <select class="form-control" name="identify">
                                            <option value=""></option>
                                        </select>
                                    </div>-->
        </div>
        <div class="col-lg-10">
            <button type="button" class="btn btn-success col-lg-12" id="regist">提交</button>
        </div>
            <div class="col-lg-11 alert text-center text-danger" id="info"></div>
    </div>
</div>
</form>
@stop