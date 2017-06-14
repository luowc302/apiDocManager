@extends('layouts.home.master')
@section('page_head')
{{-- 页面上的需要引入 --}}
<script src="{{asset('js/plugin/markDown.js')}}"></script>
<script src="{{asset('editor.md-master/editormd.min.js')}}"></script>
<script src="{{asset('js/plugin/home/page-edit.js')}}"></script>
<script src="{{asset('js/plugin/home/template-operate.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/style.css')}}" />
<link rel="stylesheet" href="{{asset('editor.md-master/css/editormd.css')}}" />
<style>            
    .editormd-html-preview {
        width: 90%;
        margin: 0 auto;
    }
</style>
@stop
@section('title', '文档编辑')
@section('nav')
@include('layouts.home.nav')
@stop
@section('content')
{{-- 页面上的具体内容--}}
<div id="layout">
    <header>
        <form class="form-inline" role="form" id="textearea-form">
            <div class="form-group">
                <label class="sr-only" for="name">文章标题</label>
                <input type="text" class="form-control" name="title" placeholder="文章标题" value="{{$pageInfo['title']}}">
                <input type="text" class="form-control" name="sort" placeholder="排序(可选)" value="{{$pageInfo['sort'] == 255 ? '' : $pageInfo['sort']}}">
            </div>
            <div class="form-group">
                <select class="form-control" name="fid">
                    <option value="0" @if($pageInfo['fid'] == 0) selected = "selected" @endif>根目录</option>
                    @foreach ($folderInfo as $key => $folder)
                    <option value="{{$folder['id']}}" @if($pageInfo['fid'] == $folder['id']) selected = "selected" @endif >&nbsp;|-{{$folder['folder_name']}}</option>
                    @if(!empty($folder['follow']))
                    @foreach ($folder['follow'] as $key => $follow)
                    <option value="{{$follow['id']}}" @if($pageInfo['fid'] == $follow['id']) selected = "selected" @endif>&nbsp;&nbsp;|--{{$follow['folder_name']}}</option>
                    @endforeach
                    @endif
                    @endforeach
                </select>
                <select class="form-control" id="template_select" name="template">
                    @foreach ($templateInfo as $key => $template)
                    <option value="{{$template['id']}}">{{$template['title']}}</option>
                    @endforeach
                </select>
                <a class="btn btn-default btn-sm" href="#" role="button" id="submit-textarea">提交</a>
                <a class="btn btn-default btn-sm" href="#" onClick="javascript :history.back(-1);"role="button">返回</a>
            </div>
    </header>

    <div id="page-editormd">
        <textarea style="display:none;" name='textarea-content' id="tpl-content">{{$pageInfo['content']}}</textarea>
        <input type="hidden" name="id" id="page_id" value="{{$page_id}}"/>
        <input type="hidden" id="project_id" value="{{$project_id}}"/>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>
</form>
</div>

</div>
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">		

    </div>
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=3>
</div>
@stop
@section('other_layout')
{{-- @include('layouts.home.modal_project') --}}
@stop
@section('other_js')
{{-- 页面上的脚本--}}
@stop

