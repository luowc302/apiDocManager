@extends('layouts.home.master')
@section('page_head')
<script src="{{asset('js/plugin/paginate.js')}}"></script>
<script src="{{asset('js/plugin/home/project.js')}}"></script>
@stop
@section('title', '工作台')
@section('nav')
@include('layouts.home.nav')
@stop
@section('content')
<ul id="myTab" class="nav nav-tabs">
	<li class="active">
            <a href="#mine" data-toggle="tab">已创建项目</a>
	</li>
	<li>
            <a href="#join" data-toggle="tab" id="join-project">加入的项目</a>
        </li>
</ul>
<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade in active" id="mine">
            <table class="table">
                <tbody id="J-body">

                </tbody>
            </table>
            <nav style="text-align: center">
            <ul class="pagination" id="J-pagination">

            </ul>
            </nav>
        </div>
	<div class="tab-pane fade" id="join">
            <table class="table">
                <tbody id="J-body-join">

                </tbody>
            </table>
            <nav style="text-align: center">
            <ul class="pagination" id="J-pagination-join">

            </ul>
            </nav>
	</div>
</div>
@stop
@section('other_layout')
@include('layouts.home.modal_project')
{{--@include('layouts.home.modal_folder')--}}
@stop

@section('other_js')

@stop
