@extends('layouts.home.master')
@section('page_head')
{{-- 页面上的需要引入 --}}
<script src="{{asset('js/plugin/paginate.js')}}"></script>
<script src="{{asset('js/plugin/home/project-edit.js')}}"></script>
@stop
@section('title', '编辑项目')
@section('nav')
@include('layouts.home.nav')
@stop
@section('content')
{{-- 页面上的具体内容--}}
<div class="form-group">
    <label for="name">项目名称</label>
    <input type="hidden" id="project_id" value="{{ $project_id }}">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="text" class="form-control" id="projetc_name" value="{{$project_name}}">
    <div id="project_div_edit"></div>
</div> 
<button type="button" class="btn btn-default" id="save_name">保存</button>
<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=3>
<div class="form-group">
    <label for="name">成员管理</label>
    <table class="table">
        <tbody  id="J-body">
            
        </tbody>
    </table>
    <nav style="text-align: center">
    <ul class="pagination" id="J-pagination">

    </ul>
</nav>
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#member">添加成员</button>
</div>

@stop
@section('other_layout')
@include('layouts.home.modal_project')
@include('layouts.home.modal_member')
@include('layouts.home.modal_member_edit')
{{--@include('layouts.home.modal_folder')--}}
@stop

@section('other_js')
{{-- 页面上的脚本--}}

@stop

