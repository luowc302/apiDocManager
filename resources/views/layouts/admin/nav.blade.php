<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="adjust-nav" >
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="{{url('admin/paner')}}">
                <img src="{{asset('img/Home.png')}}" />
            </a>
        </div>
        <span class="logout-spn exit">
            <a href="{{url('/admin/logout')}}" class="exit-font">退出</a>  
        </span>
    </div>
</div>
<!-- /. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <a href="{{url('admin/paner')}}" ><span class="glyphicon glyphicon-user"></span>用户列表</a>
            </li>
            <li>
                <a href="{{url('admin/sys-setting')}}"><span class="glyphicon glyphicon-cog"></span>系统设置</a>
            </li>
            <li>
                <a href="{{url('admin/psw-edit')}}"><span class="glyphicon glyphicon-pencil"></span>修改密码</a>
            </li>
            <li>
                <a href="{{url('admin/project-list')}}"><span class="glyphicon glyphicon-ok"></span>项目列表</a>
            </li>
            <li>
                <a href="{{url('admin/template-list')}}"><span class="glyphicon glyphicon-inbox"></span>文档模板</a>
            </li>
<!--            <li>
                <a href="{{url('admin/email-config')}}"><span class="glyphicon glyphicon-asterisk"></span>邮箱服务配置</a>
            </li>-->
        </ul>
    </div>
</nav>
<!-- /. NAV SIDE  -->