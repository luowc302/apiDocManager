@extends('layouts.home.master')
@section('page_head')
{{-- 页面上的需要引入 --}}
<script src="{{asset('editor.md-master/editormd.min.js')}}"></script>
<script src="{{asset('js/plugin/markDown.js')}}"></script>
<script src="{{asset('js/plugin/home/page-add.js')}}"></script>
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
@section('title', '添加文档')
@section('nav')
@include('layouts.home.nav')
@stop
@section('content')
{{-- 页面上的具体内容--}}<div id="layout">
    <header>
        <form class="form-inline" role="form" id="textearea-form">
            <div class="form-group">
                <label class="sr-only" for="name">文档标题</label>
                <input type="text" class="form-control" name="title" placeholder="文档标题">
                <input type="text" class="form-control" name="sort" placeholder="排序(可选)">
                <input type="hidden" name="project_id" id="project_id" value="{{ $project_id }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
            <div class="form-group">
                <select class="form-control" name="fid">
                    <option value="0">根目录</option>
                    @foreach ($folderInfo as $key => $folder)
                    <option value="{{$folder['id']}}">&nbsp;|-{{$folder['folder_name']}}</option>
                    @if(!empty($folder['follow']))
                    @foreach ($folder['follow'] as $key => $follow)
                    <option value="{{$follow['id']}}">&nbsp;&nbsp;|--{{$follow['folder_name']}}</option>
                    @endforeach
                    @endif
                    @endforeach
                </select>
                <select class="form-control" id="template_select" name="template">
                    @foreach ($templateInfo as $key => $template)
                    <option value="{{$template['id']}}">{{$template['title']}}</option>
                    @endforeach
                </select>
                <a class="btn btn-default btn-sm"  role="button" id="submit-textarea">提交</a>
                <a class="btn btn-default btn-sm" href="#" onClick="javascript :history.back(-1);" role="button">返回</a>
            </div>

    </header>
    <div id="page-editormd">
        <textarea style="display:none;" name='textarea-content' id="tpl-content">{{$templateInfo[0]['content']}}</textarea>
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
@include('layouts.home.modal_project')
@stop

@section('other_js')
{{-- 页面上的脚本--}}
@stop