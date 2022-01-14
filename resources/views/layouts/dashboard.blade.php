<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
          content="buy, sell, crypto, sell bitcoin, buy bitcoin, sell crypto">
    <meta name="description"
          content="GDG Enterprise">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GDG Enterpise</title>
    <link rel="canonical" href="https://gdgenterprise.com" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/favicon.png')}}">
    <!-- Custom CSS -->
    <link href="{{ asset('plugins/bower_components/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css')}}">
    <!-- Custom CSS -->

    <link href="{{ asset('css/amplestyle.min.css') }}" rel="stylesheet">
{{--        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">--}}

    <link href="{{ asset('css/extra.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.css') }}" defer></script>

    <style>
        .chat-list li.odd .chat-content {
            width: calc(100% - 2px);
        }


    </style>
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
     data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin6">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="/">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <!-- Dark Logo icon -->
                        <img src="{{ asset('img/logo2.png') }}" style="width: 50px; height: 50px; border-radius: 50%" alt="homepage" />
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                            <!-- dark Logo text -->
                        <span class="font-weight-bold">GDG</span><span>Enterprise</span>
{{--                            <img src="plugins/images/logo-text.png" alt="homepage" />--}}
                        </span>
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <a class="nav-toggler waves-effect waves-light text-white d-block d-md-none"
                   href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav ms-auto d-flex align-items-center">

                    <!-- ============================================================== -->

                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li>
                        <a class="profile-pic" href="#">
                            <img src="{{ asset('plugins/images/users/varun.jpg')}}" alt="user-img" width="36"
                                 class="img-circle"><span class="text-white font-medium">{{ auth()->user()->first_name }}</span></a>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <!-- User Profile-->
                    <li class="sidebar-item pt-2">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/home"
                           aria-expanded="false">
                            <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('index') }}"
                           aria-expanded="false">
                            <i class="fas fa-users" aria-hidden="true"></i>
                            <span class="hide-menu">Customers</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('create') }}"
                           aria-expanded="false">
                            <i class="fas fa-user-plus" aria-hidden="true"></i>
                            <span class="hide-menu">Add Customer</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('daily') }}"
                           aria-expanded="false">
                            <i class="fas fa-handshake" aria-hidden="true"></i>
                            <span class="hide-menu">Daily transactions</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('history') }}"
                           aria-expanded="false">
                            <i class="fas fa-history" aria-hidden="true"></i>
                            <span class="hide-menu">History</span>
                        </a>
                    </li>
{{--                    <li class="sidebar-item">--}}
{{--                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('withdraw') }}"--}}
{{--                           aria-expanded="false">--}}
{{--                            <i class="fa fa-headphones" aria-hidden="true"></i>--}}
{{--                            <span class="hide-menu">Withdraw</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('password') }}"
                           aria-expanded="false">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <span class="hide-menu">Change Password</span>
                        </a>
                    </li>


                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('logout') }}"
                           aria-expanded="false"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <span class="hide-menu">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>

            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">

        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center"> 2022 © GDG Enterprise

        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/app-style-switcher.js') }}"></script>
<script src="{{ asset('plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<!--Wave Effects -->
<script src="{{('js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('js/custom.js') }}"></script>
<!--This page JavaScript -->
<!--chartis chart-->

<script src="{{ asset('js/pages/dashboards/dashboard1.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/clipboard.min.js')}}"></script>
<script src="{{ asset('js/script.js')}}?v=1"></script>

<script>
    new ClipboardJS('.copy-btn');
</script>
</body>

</html>
