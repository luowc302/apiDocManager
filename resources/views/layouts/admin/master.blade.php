@include('layouts.admin.head')
<body>
        @yield('nav') {{--根据需要是否引入导航栏--}}
            <div id="wrapper">
               @yield('content') 
            </div>
            @include('layouts.admin.footer')
        @yield('other_layout'){{--引入页面上的其他内容--}}
    @yield('other_js'){{--引入页面上的其他js内容--}}
</body>
</html>