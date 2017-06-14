<!DOCTYPE html>
<html>
    <head>
        <title>API测试工具</title>
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
        <script src="{{asset('js/jquery-3.2.0.js')}}"></script>
        <script src="{{asset('js/bootstrap.js')}}"></script>
        <script src="{{asset('js/plugin/home/common.js')}}"></script>
        <script src="{{asset('js/plugin/all_common.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/plugin/show.css')}}" />
        <script src="{{asset('js/plugin/home/xml_format.js')}}"></script>
        <script src="{{asset('js/plugin/home/json_format.js')}}"></script>
        <script src="{{asset('js/plugin/home/api-test.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/style.css')}}" />
        <style> 
            body {
                overflow: hidden;
            }           
            a{
                cursor: pointer;
            }
            #api_test_info{
                border-radius:5px;
               box-shadow: 2px 2px  1px #ddd,
                            -1px -1px 1px #ddd;
                overflow:hidden;
                word-wrap:break-word;word-break:break-all; overflow: hidden;
            }
            #text_area{
                width:100%;
                overflow:visible;
                height:450px;
            }
            .button-group {
                margin-left: -1px;
            }
            .button-group a{
                font-size: 13px;
                padding: 5px 10px !important;
                margin-top: 16px !important;
            }
            .wrap-left {
                margin-left: 30px;
                height: 497px;
                box-shadow: 2px 2px 1px #ddd,
                            -1px -1px 1px #ddd;
            }
            .wrap-right {
                margin-left: 20px;
            }
            .wrap-header {
                margin-bottom: 20px;
            }
            .topic {
                border-left: 6px #8686b9 solid;
                padding: 6px;
            }
            .button-wrap {
                float: right;
            }
            .text_area {
                outline: none;
                border:none;
                
            }

        </style>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-static-top">
            <ul class="nav navbar-nav navbar-left navnew">
                <li role="presentation" class="active"><a href="{{url('home/paner')}}">首页</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if (empty(Session::get('user_name')))
                        {{Cookie::get('user_info')['name']}}
                        @else
                        {{Session::get('user_name') }}
                        @endif
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a data-toggle="modal" data-target="#password-update" style="cursor:pointer">修改密码</a></li>
                    </ul>
                </li>
                <li><a href="{{url('/home/logout')}}">退出</a></li>
            </ul>
        </nav>
        <div class="row">
            <div class="col-md-5 wrap-left">
                <div class="panel-body">
                    <div class="list-group">
                        <div class="form-inline"> 
                            <form role="form" id="apiTest_form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <span class="glyphicon glyphicon-plus"></span>
                                <a class="btn btn-default click-select" style="border:none"><input type="hidden" class="select" value="0" />参数</a> 
                                <a class="btn btn-default click-select" style="border:none"><input type="hidden" class="select" value="1" />Cookies</a>
                                <a class="btn btn-default click-select" style="border:none"><input type="hidden" class="select" value="2" />Header</a> 

                        </div>
                        <br/>
                        <label for="name">提交方式</label> 
                        <label class="checkbox-inline">
                            <input type="radio" name="method" value="0" checked>POST
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="method" value="1">GET
                        </label>
                        <ul class="nav nav-pills button-group">
                            <li><a href="#" class="btn btn-default btn-sm" id="modal_api_test">提交</a></li>
                            <li><a href="#" class="btn btn-default btn-sm clear_content">清空</a></li>
                        </ul>
                        <br/>
                        <hr/>
                        <br/>
                        <label for="name">接口地址</label>
                        <br/>
                        <input type="text" class="form-control url" name="url" placeholder="键入完整接口地址">
                        <hr/>
                        <div id="InputsWrapper">
                            <div class="form-inline inputList"> 
                                <div id="field_1" class="form-group"></div> 
                                <div class="form-group removeOp"></div> 
                            </div> 
                        </div>
                        <br/>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 wrap-right">
                <div class='wrap-header'>
                    <span class="topic">返回结果</span>
                    <div class="button-wrap">
                        <a href="#" class="btn btn-default btn-sm" id="J-format-code">格式化Json</a>
                        <a href="#" class="btn btn-default btn-sm" id="J-format-xml">格式化Xml</a>
                    </div>   
                </div>
               
                <div id="api_test_info" id="layout" class="page-detailShow">
                    <textarea id="text_area" class="text_area" readonly>
                        
                    </textarea>
                </div>
            </div>
        </div>
        <div id="footer" class="container">
            <nav class="navbar navbar-static-bottom">
                <div class="navbar-inner navbar-content-center">
                    <p class="text-muted credit text-center" style="padding: 10px;">
                        &copy;   2017 apiDocument Manager All rights reserved | Power by luowencai
                    </p>
                </div>
            </nav>
    </body>
</html>
