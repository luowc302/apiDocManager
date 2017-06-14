@extends('layouts.home.master')
@section('page_head')
{{-- 页面上的需要引入 --}}
<script src="{{asset('js/plugin/markDown.js')}}"></script>
<script src="{{asset('js/plugin/home/xml_format.js')}}"></script>
<script src="{{asset('js/plugin/home/json_format.js')}}"></script>
<script src="{{asset('js/plugin/home/page-show.js')}}"></script>
<script src="{{asset('js/plugin/home/api-test.js')}}"></script>
<script src="{{asset('editor.md-master/lib/marked.min.js')}}"></script>
<script src="{{asset('editor.md-master/lib/prettify.min.js')}}"></script>
<script src="{{asset('editor.md-master/lib/raphael.min.js')}}"></script>
<script src="{{asset('editor.md-master/lib/underscore.min.js')}}"></script>
<script src="{{asset('editor.md-master/lib/sequence-diagram.min.js')}}"></script>
<script src="{{asset('editor.md-master/lib/flowchart.min.js')}}"></script>
<script src="{{asset('editor.md-master/lib/jquery.flowchart.min.js')}}"></script>
<script src="{{asset('editor.md-master/editormd.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/style.css')}}" />
<link rel="stylesheet" href="{{asset('editor.md-master/css/editormd.preview.css')}}" />
<style>            
    .editormd-html-preview {
        width: 90%;
        margin: 0 auto;
    }
    .follow{
        text-indent:1em;
    }
    .scPage{
        text-indent:1em;
    }
    .page{
        text-indent:2em;
    }
    a{
        cursor: pointer;
    }
    #api_test_info{
        border-radius:5px;
        box-shadow: 0px 1px 2px rgba(34, 25, 25, 0.2);
        overflow:hidden;
        word-wrap:break-word;word-break:break-all; overflow: hidden;
    }
    #text_area{
        width:100%;
        overflow:visible;
        height:200px
    }
    a{
        cursor:pointer;
    }
</style>
@stop
@section('title', $project_name)
@section('nav')
@include('layouts.home.nav')
@stop
@section('content')
{{-- 页面上的具体内容--}}
<div class="row">
    <div class="col-md-3">
        <div class="panel-body">
            <div class="list-group">
                <div class="input-group">
                    <input type="text" class="form-control search-title" placeholder="标题关键字">
                    <span class="input-group-addon"><a class="search"><span class="glyphicon glyphicon-search"></span></a></span>
                </div>
                <div id="J-title-list">

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        @if (!empty($private) && $private == 1)
        <span id="J-delete"><a class="btn btn-default btn-sm"id="J-deletePage">删除文档</a></span>
        <!--<a class="btn btn-default btn-sm"id="J-word-generate">生成word文档</a>-->
        @endif
        <span id="option"></span>
        <div id="layout" class="page-detailShow">
            <div id="test-editormd-view2"></div>
            <input type="hidden" class="page_id" value=""/>
        </div>
    </div>
</div>
@stop
@section('other_layout')
@include('layouts.home.modal_project')
@include('layouts.home.modal_folder')
@include('layouts.home.modal_folder_edit')
@include('layouts.home.modal_folder_delete')
@include('layouts.home.modal_apiTest')
@stop

@section('other_js')
{{-- 页面上的脚本--}}
 <!--<script src="js/zepto.min.js"></script>-->
{{-- <script>
var jQuery = Zepto;  // 为了避免修改flowChart.js和sequence-diagram.js的源码，所以使用Zepto.js时想支持flowChart/sequenceDiagram就得加上这一句
</script> --}}
@stop

