<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>api Manage System</title>
        <!-- BOOTSTRAP CORE STYLE CSS -->
        <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" />
        <!-- BOOTSTRAP CORE STYLE CSS -->
        <!-- FONT AWESOME CSS -->
        <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />
        <!-- STYLE SWITCHER  CSS -->
        <link href="{{asset('css/styleSwitcher.css')}}" rel="stylesheet" />
        <!-- CUSTOM STYLE CSS -->
        <link href="{{asset('css/style-index.css')}}" rel="stylesheet" />  
        <!--GREEN STYLE VERSION IS BY DEFAULT, USE ANY ONE STYLESHEET FROM TWO STYLESHEETS (green or red) HERE-->
        <link href="{{asset('css/themes/green.css')}}" id="mainCSS" rel="stylesheet" />   
        <!-- Google	Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />

    <div class="switcher" style="left:-50px;">
        <a id="switch-panel" class="hide-panel">
            <i class="fa fa-recycle"></i>
        </a>
        <p style="font-size:10px">choose</p>
        <ul class="colors-list">
            <li><a title="Green" id="green" class="green" ></a></li>
            <li><a title="Red" id="red" class="red" ></a></li>
        </ul>
    </div>	
    <!--END STYLE SWITCHER-->
    <div class="navbar navbar-inverse navbar-fixed-top move-me" id="menu">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img class="logo-custom" src="{{asset('img/logo180-50.png')}}" alt=""  /></a>
            </div>
            <div class="navbar-collapse collapse">
              @include('layouts.home.index_nav')
            </div>

        </div>
    </div>
    <!--NAVBAR SECTION END-->
    <section class="header-sec" id="home" >
        <div class="overlay">
            <div class="container">
                <div class="row text-center" >
                    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <h2 data-scroll-reveal="enter from the bottom after 0.1s">
                            <strong>
                                合理管理你的API文档
                            </strong>
                        </h2>
                        </h2>
                        一个适合IT团队管理项目API接口文档的系统
                        </h2>
                        <br />
                    </div>

                </div>
            </div>
        </div>

    </section>
    <!--HEADER SECTION END-->
    <section class="features" id="features">
        <div class="container">
            <div class="row text-center" >
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <h3 data-scroll-reveal="enter from the bottom after 0.1s">
                        <strong>
                            功能介绍
                        </strong>
                    </h3>
                </div>
            </div>
            <div class="row " >
            </div>
            <div class="row text-center just-pad" >
                <div class="col-lg-4 col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.2s" >
                    <i class=" fa fa-database fa-5x "></i>
                    <h4 ><strong> 团队管理项目 </strong></h4>
                    <p>
                        采用权限系统合理的管理不同项目
                    </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.8s" >
                    <i class=" fa fa-send fa-5x "></i>
                    <h4 ><strong> 文档管理</strong></h4>
                    <p>
                        合理的项目文档管理
                    </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 1.4s" >
                    <i class=" fa fa-puzzle-piece fa-5x "></i>
                    <h4 ><strong> API测试 </strong></h4>
                    <p>
                        测试你的API接口
                    </p>
                </div>
            </div>
        </div>

    </section>
    <!--FEATURES SECTION END-->
    <section class="testi-sec" >
        <div class="overlay">
            <div class="container">
                <div class="row text-center" >
                    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <div class="row text-center " >
                            <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                                <h3 data-scroll-reveal="enter from the bottom after 0.1s">
                                    <strong>
                                        联系方式
                                    </strong>
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6" data-scroll-reveal="enter from the right after 0.2s">
                                <strong>邮箱 :</strong>
                                <p>
                                   {{config('options.contact.Email')}}
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6" data-scroll-reveal="enter from the left after 0.4s">
                                <strong>期待你的联系</strong>
                                <p>
                                    {{config('options.contact.words')}} 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="myfooter" >
        &copy;   2017 apiDocument Manager All rights reserved | Power by luowencai
    </div>
    <!--FOOTER SECTION END-->
    <!--  Jquery Core Script -->
    <script src="{{asset('js/jquery-3.2.0.min.js')}}"></script>
    <!--  Core Bootstrap Script -->
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <!--  Scrolling Reveal Script -->
    <script src="{{asset('js/scrollReveal.js')}}"></script>
    <!--  Scroll Scripts --> 
    <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <!--  Style Switcher Scripts -->
    <script src="{{asset('js/styleSwitcher.js')}}"></script>
    <!--  Custom Scripts -->    
    <script src="{{asset('js/custom.js')}}"></script>
