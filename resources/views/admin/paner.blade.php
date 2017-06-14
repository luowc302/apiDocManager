@extends('layouts.admin.master')
@section('page_head')
<script src="{{asset('js/plugin/paginate.js')}}"></script>
<script src="{{asset('js/plugin/admin/user.js')}}"></script>
@stop
@section('title', '管理员面板')
@section('nav')
@include('layouts.admin.nav')
@stop
@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h3>用户列表</h3>   
            </div>
        </div>              
        <!-- /. ROW  -->
        <hr />
        <table class="table table-condensed">
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