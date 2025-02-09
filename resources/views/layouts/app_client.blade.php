<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="R3 Alliance">
    <meta name="keywords" content="R3 Alliance">
    <meta name="author" content="r3alliance">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'R3 Alliance') }}</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/calendar.css') }}">
    <!-- Plugins css Ends-->

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icomoon/style.css') }}">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">

    @yield('css')

</head>

<body>
    <div class="loader-wrapper">
        <div class="loader loader-1">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>
            <div class="loader-inner-1"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Body Start-->
        <div class="page-body-wrapper horizontal-menu">
            <!-- Page Sidebar Start-->
            {{-- @yield('sidebar_content') --}}
           
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="page-header row">
                                    
                                    <div class="col-2 col-xl-2 page-title">
                                        <a href="#"><img class="img-fluid for-light"
                                                    src="{{ asset('assets/images/logo/logo_light.png') }}"
                                                    alt="" /><img class="img-fluid for-dark"
                                                    src="{{ asset('assets/images/logo/logo_light.png') }}"
                                                    alt="" /></a>
                                    </div>
                                    <!-- Page Header Start-->
                                    <div class="header-wrapper col m-0">
                                        <div class="row">
                                            <form class="form-inline search-full col" action="#" method="get">
                                                <div class="form-group w-100">
                                                    <div class="Typeahead Typeahead--twitterUsers">
                                                        <div class="u-posRelative">
                                                            <input
                                                                class="demo-input Typeahead-input form-control-plaintext w-100"
                                                                type="text" placeholder="Search Mofi .."
                                                                name="q" title="" autofocus>
                                                            <div class="spinner-border Typeahead-spinner"
                                                                role="status"><span class="sr-only">Loading...</span>
                                                            </div><i class="close-search" data-feather="x"></i>
                                                        </div>
                                                        <div class="Typeahead-menu"></div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="header-logo-wrapper col-auto p-0">
                                                <div class="logo-wrapper"><a href="index.html"><img class="img-fluid"
                                                            src="{{ asset('assets/images/nav_toggle_icon.png') }}"
                                                            alt=""></a>
                                                </div>
                                                <div class="toggle-sidebar">
                                                    <img src="{{ asset('assets/images/nav_toggle_icon.png') }}"
                                                        alt="Wallet" width="24">
                                                </div>
                                            </div>
                                            <div
                                                class="nav-right col-xxl-8 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                                                <ul class="nav-menus">
                                                    <li> <span class="header-search">
                                                            <svg>
                                                                <use
                                                                    href="{{ asset('assets/svg/icon-sprite.svg#search') }}">
                                                                </use>
                                                            </svg></span></li>

                                                  


                                                    <li class="profile-nav onhover-dropdown px-0 py-0">
                                                        <div class="d-flex profile-media align-items-center"><img
                                                                class="img-30"
                                                                src="{{ asset('assets/images/dashboard/profile.png') }}"
                                                                alt="">
                                                            <div class="flex-grow-1">
                                                                <span>{{ Auth::user()->name }}</span>
                                                                {{-- <p class="mb-0 font-outfit">Admin<i class="fa fa-angle-down"></i></p> --}}
                                                            </div>
                                                        </div>
                                                        <ul class="profile-dropdown onhover-show-div">
                                                            <li>
                                                                <a href="#">
                                                                    <i data-feather="user"></i>
                                                                    <span>Account</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('logout') }}"
                                                                    onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                                                                    <i data-feather="log-in"> </i>
                                                                    <span>Logout</span>
                                                                </a>
                                                                <form id="logout-form" action="{{ route('logout') }}"
                                                                    method="POST" class="d-none">
                                                                    @csrf
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>

                                            <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
                                        </div>
                                    </div>
                                    <!-- Page Header Ends  -->
                                </div>
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row starter-main">

                        <div class="card card-top">
                      
                                

                                @yield('content')
                       
                        </div>

                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
        </div>
    </div>

    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/sidebar-pin.js') }}"></script> --}}

    <script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick/slick.js') }}"></script>
    <script src="{{ asset('assets/js/header-slick.js') }}"></script>
    <script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>

    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
    <!-- Plugin used-->

    <!-- calendar js-->
    <!-- Plugins JS Ends-->

    <style>
        
        .page-wrapper .page-header{background: #2C1259;padding: 0px 50px 10px;}
         body{ background-color:#fff}
        .page-wrapper.compact-wrapper .page-body-wrapper .page-body{ background-color:#fff}
        .page-wrapper.compact-wrapper .page-body-wrapper .page-body {
            min-height: calc(100vh - 80px);
            margin-top: 0px;
            margin-left: 0px;
            border-radius: 30px;
            background:#fff;
            padding: 0px;
        }
        .right-header{margin-top:30px;}
        .page-wrapper .page-header .header-wrapper .nav-right .profile-dropdown{top:33px;}
        .profile-nav{background:transparent !important;}
        .nav-right.right-header ul li .profile-media .flex-grow-1 span{color:#fff}
        .card-top{background:#fff !important;}
        .page-wrapper .page-body-wrapper .page-title{padding:10px 15px 0 15px;}
        .page-body .card{padding-top:15px;}
    </style>
    @yield('script')

</body>

</html>
