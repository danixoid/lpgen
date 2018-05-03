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
    <link rel="shortcut icon" href="{!! url('/elements/images/favicon.ico') !!}" type="image/x-icon">
    <link rel="icon" href="{!! url('/elements/images/favicon.ico') !!}" type="image/x-icon">

    <!-- =========================
       STYLESHEETS
    ============================== -->
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="{!! url('/elements/css/plugins/bootstrap.min.css') !!}">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Arsenal' rel='stylesheet' type='text/css'>

    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="{!! url('/elements/css/style.css') !!}">

    <!-- RESPONSIVE FIXES -->
    <link rel="stylesheet" href="{!! url('/elements/css/responsive.css') !!}">
    @yield("style")

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn''t work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body data-spy="scroll" data-target="#main-navbar">

    <div class="main-container" id="page">@yield('content')</div><!-- /End Main Container -->


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

</body>
</html>