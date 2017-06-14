<ul class="nav navbar-nav navbar-right">
    <li ><a href="#home">首页</a></li>
    @if (empty(Session::get('user_name')) && empty(Cookie::get('user_info')['name']))
    <li><a href="{{url('login')}}">登陆</a></li>
    @else
    <li><a href="{{url('home/paner')}}">进入工作台</a></li>
    @endif
    <li><a href="{{url('admin/paner')}}">管理员</a></li>
</ul>