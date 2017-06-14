@extends('layouts.admin.master')
@section('page_head')
<script src="{{asset('js/plugin/paginate.js')}}"></script>
<script src="{{asset('js/plugin/admin/template_add.js')}}"></script>
<script src="{{asset('editor.md-master/editormd.min.js')}}"></script>
<script src="{{asset('js/plugin/markDown.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/style.css')}}" />
<link rel="stylesheet" href="{{asset('editor.md-master/css/editormd.css')}}" />
<style>            
    .editormd-html-preview {
        width: 100%;
        margin: 0 auto;
    }
</style>
@stop
@section('title', '添加模板')
@section('nav')
@include('layouts.admin.nav')
@stop
@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <a href="#" class="btn btn-primary" id="J-tpl-add">保存</a>
                <a href="#" class="btn" onclick="javascript :history.back(-1);">后退</a> 
            </div>
        </div>              
        <!-- /. ROW  -->
        <hr />
        <form role="form" id="tpl_add_form">
            <div class="form-group">
                <label for="title">标题</label>
                <input type="text" class="form-control" name="title" placeholder="请输入标题">
                <label for="content">内容</label>
                <div id="page-editormd">
                    <textarea style="display:none;" name="content"></textarea>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div  id="form_div_tpl"></div>
            </div>
        </form>
    </div>
    <!-- /. PAGE INNER  -->
</div>
@stop