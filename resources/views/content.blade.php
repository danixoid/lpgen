<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- TITLE OF SITE -->
    <title>B-Apps - Landing Page with Page Builder</title>

    <meta name="description" content="glDescription" />
    <meta name="keywords" content="glKeywords" />
    <meta name="author" content="glAuthor">

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
@if(!isset($content))
    <link rel="stylesheet" href="/elements/css/plugins/pickadate-default.css">
    <link rel="stylesheet" href="/elements/css/plugins/pickadate-default.date.css">
@endif
    
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="/elements/css/style.css">

    <!-- RESPONSIVE FIXES -->
    <link rel="stylesheet" href="/elements/css/responsive.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn''t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body data-spy="scroll" data-target="#main-navbar">

@if(Auth::check() && preg_match('/builder\/preview/',request()->fullUrl()))
    <style>
        #adminpanel {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background-color: #000000;
            background-color: rgba(0,0,0,0.5);
        }
    </style>
    <div id="adminpanel">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            Выйти
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
@endif

<!-- Preloader -->
<!--
<div class="loader bg-white">
    <div class="loader-inner ball-scale-ripple-multiple vh-center">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
-->

    <div class="main-container" id="page">@if(isset($content)){!! $content !!}@endif</div><!-- /End Main Container -->


<!-- Back to Top Button -->
<!--
<a href="#" class="top">Top</a>
-->

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
@if(!isset($content))
    <script src="/elements/js/plugins/picker.js"></script>
    <script src="/elements/js/plugins/picker.date.js"></script>
@endif
    <!-- Custom Script -->
    <script src="/elements/js/custom.js"></script>
    
</body>
</html>