<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
    <title>@yield('title','Dashboard')</title>
</head>

<body>
    <div class="page-wrapper"
        id="main-wrapper"
        data-layout="vertical"
        data-navbarbg="skin6"
        data-sidebartype="full"
        data-sidebar-position="fixed"
        data-header-position="fixed">

       @include('partials.toltip')

        @include('partials.sidebar')

        <div class="body-wrapper">

            @include('partials.header')

            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    
                        @yield('content')
                </div>
            </div>

            @include('partials.footer')
        </div>
    </div>
</body>

</html>