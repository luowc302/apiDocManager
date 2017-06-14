@include('layouts.home.head')
<body>
        @yield('nav') {{--根据需要是否引入导航栏--}}
        <div class="container">
            @yield('content')
        </div>
            @include('layouts.home.footer')
        @yield('other_layout'){{--引入页面上的其他内容--}}
    @yield('other_js'){{--引入页面上的其他js内容--}}
    @include('layouts.home.modal_password_update')
</body>
</html>