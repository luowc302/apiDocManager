@extends('layouts.admin.master')
@section('page_head')
<script src="{{asset('js/plugin/paginate.js')}}"></script>
<script src="{{asset('js/plugin/admin/setting.js')}}"></script>
<style type="text/css">
    .form-control { width: 20% ; }
</style>
@stop
@section('title', '系统设置')
@section('nav')
@include('layouts.admin.nav')
@stop
@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h3>系统设置</h3>   
            </div>
        </div>              
        <!-- /. ROW  -->
        <hr />
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>功能</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="J-body">

            </tbody>
        </table>
        <nav style="text-align: center">
            <ul class="pagination" id="J-pagination">

            </ul>
        </nav>
        <!-- /. ROW  -->           
    </div>
    <!-- /. PAGE INNER  -->
</div>
@stop