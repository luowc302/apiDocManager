<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
        <!-- FONTAWESOME STYLES-->
        <link href="{{asset('css/plugin/admin/font-awesome.css')}}" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="{{asset('css/plugin/admin/custom.css')}}" rel="stylesheet" />
        <script src="{{asset('js/jquery-3.2.0.js')}}"></script>
        <script src="{{asset('js/bootstrap.js')}}"></script>
        <script src="{{asset('js/plugin/admin/custom.js')}}"></script>
        <script src="{{asset('js/plugin/admin/common.js')}}"></script>
        <script src="{{asset('js/plugin/all_common.js')}}"></script>
        <style>
            .log{
                 color:#fff;
            }
            .exit{
                margin-top: 20px;
            }
            .exit-font{
                color:#fff;
            }
            .navbar-inverse{
                min-height: 67px;
            }
            .exit-font{
                font-size:18px;
            }
            .navbar-fixed-top{
                border-bottom-width: 0px;
            }
        </style>
        @yield('page_head')
    </head>