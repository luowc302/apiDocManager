@extends('layouts.home.master')
@section('page_head')
<link rel="stylesheet" href="{{asset('css/plugin/install.css')}}" />
@stop
@section('title', '配置环境')
@section('content')
<form action="{{url('setEnv')}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="mycenter">
        <div class="mysign">
            <div class="col-lg-11 text-center text-info">
                <h3>配置环境</h3>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="DB_HOST" placeholder="HOST地址" required autofocus/>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="DB_DATABASE" placeholder="数据库名称(预先创建)" required autofocus/>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="DB_USERNAME" placeholder="数据库用户名" required autofocus/>
            </div>
            <div class="col-lg-10">
                <input type="password" class="form-control" name="DB_PASSWORD" placeholder="数据库密码" required autofocus/>
            </div>
            <div class="col-lg-10">
                <button type="submit" class="btn btn-success col-lg-12">下一步</button>
            </div>
        </div>
    </div>
</form>
@stop