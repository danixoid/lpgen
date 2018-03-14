<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield("meta")

    <!-- TITLE OF SITE -->
    <title>B-Apps - Landing Page with Page Builder</title>

    <!-- FAVICON  -->
    <!-- Place your favicon.ico in the images directory -->
    <link rel="shortcut icon" href="/elements/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/elements/images/favicon.ico" type="image/x-icon">

    <!-- =========================
       STYLESHEETS
    ============================== -->
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="/elements/css/plugins/bootstrap.min.css">

    <!-- FONT ICONS -->
    <link rel="stylesheet" href="/elements/css/icons/iconfont.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Arsenal' rel='stylesheet' type='text/css'>

    <!-- PLUGINS STYLESHEET -->
    <link rel="stylesheet" href="/elements/css/plugins/magnific-popup.css">
    <link rel="stylesheet" href="/elements/css/plugins/owl.carousel.css">
    <link rel="stylesheet" href="/elements/css/plugins/loaders.css">
    <link rel="stylesheet" href="/elements/css/plugins/animate.css">
    <link rel="stylesheet" href="/elements/css/plugins/pickadate-default.css">
    <link rel="stylesheet" href="/elements/css/plugins/pickadate-default.date.css">


    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="/elements/css/style.css">

    <!-- RESPONSIVE FIXES -->
    <link rel="stylesheet" href="/elements/css/responsive.css">
    @yield("style")

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn''t work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body data-spy="scroll" data-target="#main-navbar">

<?php
    $_show_nav = preg_match('/!?(builder|page)/',request()->route()->getName()) === 0 &&
        preg_match('/^'. env('LPGEN_KZ','b-apps.kz') . '$/',request()->getHost()) > 0;
?>
@if($_show_nav)
    <!-- =========================
            HEADER
        ============================== -->
    <header id="nav1-2">

    <nav class="navbar bg-color" id="main-navbar">
    <!-- navbar fixed on top: -->
    {{--<nav class="navbar navbar-fixed-top bg-color" id="main-navbar" role="navigation" style="background-color: rgba(82,95,109,0.6)">--}}

    <!-- navbar static: -->
    {{--<nav class="navbar navbar-static-top bg-color" id="main-navbar" role="navigation">--}}

            <div class="container">

                <div class="navbar-header">
                    <!-- Menu Button for Mobile Devices -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Image Logo -->
                    <!--
                    recommended sizes
                        width: 150px;
                        height: 35px;
                    -->
                    <a href="{!! url('/') !!}" class="navbar-brand smooth-scroll"><img src="/elements/images/logo-white.png" alt="logo"></a>
                    <!-- Image Logo For Background Transparent -->
                    <!--
                        <a href="#" class="navbar-brand logo-black smooth-scroll"><img src="/elements/images/logo-black.png" alt="logo" /></a>
                        <a href="#" class="navbar-brand logo-white smooth-scroll"><img src="/elements/images/logo-white.png" alt="logo" /></a>
                    -->
                </div><!-- /End Navbar-Header -->

                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <!-- Menu Links -->
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li class="inverse smooth-scroll"><a href="{{ route('login') }}">Войти</a></li>
                            <li class="inverse smooth-scroll"><a href="{{ route('register') }}">Регистрация</a></li>
                        @else
                            <li class="inverse smooth-scroll"><a href="{{ route('home') }}">Сайты</a></li>
                            <li class="inverse smooth-scroll"><a href="{{ route('user.index') }}">Кабинет</a></li>
                            {{--<li class="inverse smooth-scroll"><a href="{{ route('builder.show') }}">Строитель</a></li>--}}
                            <li class="dropdown">
                                <a href="{{ route('logout') }}" class="dropdown-toggle btn-nav btn-green smooth-scroll"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ Auth::user()->name }} [ Выйти ]
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif

                    </ul><!-- /End Menu Links -->
                </div><!-- /End Navbar Collapse -->

            </div><!-- /End Container -->
        </nav><!-- /End Navbar -->
    </header>
@endif
    <div class="main-container" id="page">@yield('content')</div><!-- /End Main Container -->

@if($_show_nav)


    <!-- =========================
             FOOTER
        ============================== -->
    <footer id="footer1-2" class="p-y-md footer f1 bg-edit bg-dark">
        <div class="container">
            <div class="row">
                <!-- Copy -->
                <div class="col-sm-8 text-white">
                    <p>© {{ date('Y') }} Разработано в <a href="http://bapps.kz" class="f-w-900 inverse">B-Apps</a></p>
                </div>
                <!-- Social Links -->
                <div class="col-sm-4">
                    <ul class="footer-social inverse">
                        {{--<li><a href=""><i class="fa fa-facebook"></i></a></li>--}}
                        {{--<li><a href=""><i class="fa fa-twitter"></i></a></li>--}}
                        {{--<li><a href=""><i class="fa fa-instagram"></i></a></li>--}}
                    </ul>
                </div>
            </div><!-- /End Row -->
        </div><!-- /End Container -->
    </footer>



@endif
<!-- =========================
     SCRIPTS
============================== -->
<script src="/elements/js/plugins/jquery1.11.2.min.js"></script>
<script src="/elements/js/plugins/bootstrap.min.js"></script>
<script src="/elements/js/plugins/jquery.easing.1.3.min.js"></script>
<script src="/elements/js/plugins/jquery.countTo.js"></script>
<script src="/elements/js/plugins/jquery.formchimp.min.js"></script>
<script src="/elements/js/plugins/jquery.jCounter-0.1.4.js"></script>
<script src="/elements/js/plugins/jquery.magnific-popup.min.js"></script>
<script src="/elements/js/plugins/jquery.vide.min.js"></script>
<script src="/elements/js/plugins/owl.carousel.min.js"></script>
<script src="/elements/js/plugins/twitterFetcher_min.js"></script>
<script src="/elements/js/plugins/wow.min.js"></script>
<script src="/elements/js/plugins/picker.js"></script>
<script src="/elements/js/plugins/picker.date.js"></script>
@yield('javascript')

<!-- Custom Script -->
<script src="/elements/js/custom.js"></script>

</body>
</html>