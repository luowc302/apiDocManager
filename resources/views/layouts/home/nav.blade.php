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
        @if(empty($navShow) || ($navShow != 3 && $navShow != 1))
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                选项 
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation" class="dropdown-header" data-toggle="modal" data-target="#project" style="cursor:pointer">新建项目</li>
            </ul>
        </li>
        @endif
        @if (!empty($private) && $private == 1)
        @if (!empty($navShow) && $navShow == 1)
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                文档
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation" class="dropdown-header" style="cursor:pointer" id="J-newPage">新建文档</li>
                <li role="presentation" class="dropdown-header" style="cursor:pointer" id="J-editPage">编辑文档</li>
                <input type="hidden" id="add_url" value="{{url('home/page-add')}}"/>
                <input type="hidden" id="edit-url" value="{{url('/home/page-edit?id=')}}"/>
                <input type="hidden" id="delete_url" value="{{url('/home/delete-page?id=')}}"/>
            </ul>
        </li>
        @endif
        @if (!empty($navShow) && $navShow == 1)
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                目录
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                {{--下菜单只有在进入项目后才能显示--}}
                <li role="presentation" class="dropdown-header" data-toggle="modal" data-target="#folder" style="cursor:pointer">新建目录</li>
                <li role="presentation" class="dropdown-header" data-toggle="modal" data-target="#folder-edit" style="cursor:pointer">编辑目录</li>
                <li role="presentation" class="dropdown-header" data-toggle="modal" data-target="#folder-delete" style="cursor:pointer">删除目录</li>
            </ul>
        </li>
        @endif
        @endif
        @if(!empty($page_show) && $page_show == 1)
        <!--<li><a  data-toggle="modal" data-target="#apiTest" style="cursor:pointer">测试接口</a></li>-->
        <li><a href="{{url('home/showApiTest')}}" target="_blank">测试接口</a></li>
        <li><a href="{{url('home/export-word?id='.$project_id.'')}}"style="cursor:pointer">导出项目</a></li>
        @endif
        <li><a href="{{url('/home/logout')}}">退出</a></li>
    </ul>
</nav>