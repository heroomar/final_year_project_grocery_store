<?php
    $setting=[];
    $setting['metatitle'] = '';
    $setting['metatitle'] = '';
    $setting['metakeyword'] = '';
    $setting['metakeyword'] = '';
    $setting['metadesc'] = '';
    $setting['metadesc'] = '';
    $setting['metatitle'] = '';
    $setting['metatitle'] = '';
    $setting['metadesc'] = '';
    $setting['metadesc'] = '';
    $setting['metaimage'] = '';
    $setting['metaimage'] = '';
    $setting['metatitle'] = '';
    $setting['metatitle'] = '';
    $setting['metadesc'] = '';
    $setting['metadesc'] = '';
    $setting['metaimage'] = '';
    $setting['metaimage'] = '';
    $setting['color'] = '';
    $setting['footer_text'] = '';
    $setting['footer_text'] = '';
    $setting['footer_text'] = '';
    $setting['footer_text'] = '';
    $setting['footer_text'] = '';
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ isset($SITE_RTL) && $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="WorkDo.io" />

    <meta name="title" content="{{ isset($setting['metatitle']) ? $setting['metatitle'] : 'EcommerceGo' }}">
    <meta name="keywords" content="{{ isset($setting['metakeyword']) ? $setting['metakeyword'] : 'EcommerceGo, Store with Multi theme and Multi Store' }}">
    <meta name="description" content="{{ isset($setting['metadesc']) ? $setting['metadesc'] : 'Discover the efficiency of EcommerceGo, a user-friendly web application by Workdo.io.'}}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ isset($setting['metatitle']) ? $setting['metatitle'] : 'EcommerceGo' }}">
    <meta property="og:description" content="{{ isset($setting['metadesc']) ? $setting['metadesc'] : 'Discover the efficiency of EcommerceGo, a user-friendly web application by Workdo.io.'}} ">
    <meta property="og:image" content="{{ (isset($setting['metaimage']) ? $setting['metaimage'] : 'storage/uploads/ecommercego-saas-preview.png')  }}{{'?'.time() }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ isset($setting['metatitle']) ? $setting['metatitle'] : 'EcommerceGo' }}">
    <meta property="twitter:description" content="{{ isset($setting['metadesc']) ? $setting['metadesc'] : 'Discover the efficiency of EcommerceGo, a user-friendly web application by Workdo.io.'}} ">
    <meta property="twitter:image" content="{{ (isset($setting['metaimage']) ? $setting['metaimage'] : 'storage/uploads/ecommercego-saas-preview.png')  }}{{'?'.time() }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}-@yield('page-title')</title>

    <!-- Favicon icon -->
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->
        <!-- <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link"> -->
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ asset('css/rtl-loader.css') }}{{ '?v=' . time() }}">
        <!-- <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link"> -->
        <link rel="stylesheet" href="{{ asset('css/loader.css') }}{{ '?v=' . time() }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ asset('css/rtl-loader.css') }}{{ '?v=' . time() }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ asset('css/loader.css') }}{{ '?v=' . time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}{{ '?v=' . time() }}">
    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">

    <style>
        :root {
            --color-customColor: <?= $setting['color'] ?? 'linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #ffffff 99.86%)' ?>;
        }
    </style>
    <style>
        .lnding-menubar {
            display: flex;
            align-items: center;
            color: #000000;
        }

        .lnding-menubar li {
            list-style-type: none;

        }

        .lnding-menubar li a {
            color: #000000;
            text-transform: capitalize;
        }

        .lnding-menubar li.has-item>a {
            padding-right: 20px;
        }

        .lnding-menubar li.has-item .menu-dropdown {
            position: absolute;
            top: 100%;
            background-color: #ffffff;
            transform-origin: top;
            box-shadow: 0px 10px 40px rgb(0 0 0 / 5%);
            opacity: 0;
            visibility: hidden;
            min-width: 220px;
            z-index: 2;
            padding: 20px;
            -moz-transition: all ease-in-out 0.3s;
            -ms-transition: all ease-in-out 0.3s;
            -o-transition: all ease-in-out 0.3s;
            -webkit-transition: all ease-in-out 0.3s;
            transition: all ease-in-out 0.3s;
            -moz-transform: scaleY(0);
            -ms-transform: scaleY(0);
            -o-transform: scaleY(0);
            -webkit-transform: scaleY(0);
            transform: scaleY(0);
        }
        .lnding-menubar li.has-item:hover .menu-dropdown {
            opacity: 1;
            visibility: visible;
            -webkit-transform: scaleY(1);
            -moz-transform: scaleY(1);
            -ms-transform: scaleY(1);
            -o-transform: scaleY(1);
            transform: scaleY(1);
        }

        .lnding-menubar li.has-item .menu-dropdown li.lnk-itm>.dropdown-item {
            margin-bottom: 7px;
        }

        .lnding-menubar li.has-item .menu-dropdown li.lnk-itm:not(:last-of-type) {
            margin-bottom: 15px;
        }

        .lnding-menubar li.has-item .menu-dropdown li.lnk-itm .lnk-child li:not(:last-of-type) {
            margin-bottom: 10px;
        }

        .lnding-menubar li.has-item .menu-dropdown li.lnk-itm .lnk-child li {
            list-style-type: disc;
        }
    </style>
</head>

<body class="" style="background-image: url('http://localhost:8000/front/img/carousel-1.jpg') !important;background-size: cover !important;" >

    <div class="register-page auth-wrapper auth-v3">
        <!-- <div class="login-back-img">
            <img src="{{ asset('assets/images/auth/img-bg-1.svg') }}" alt="" class="img-fluid login-bg-1" />
            <img src="{{ asset('assets/images/auth/img-bg-2.svg') }}" alt="" class="img-fluid login-bg-2" />
            <img src="{{ asset('assets/images/auth/img-bg-3.svg') }}" alt="" class="img-fluid login-bg-3" />
            <img src="{{ asset('assets/images/auth/img-bg-4.svg') }}" alt="" class="img-fluid login-bg-4" />
        </div> -->
        <div class="bg-auth-side bg-primary login-page"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">

                    <a class="navbar-brand" href="{{ \URL::to('/') }}">
                        <img src="{{ GetAllSettings()['logo_light'] }}"
                            alt="logo" class="brand_icon" />
                    </a>

                    
                </div>
            </nav>
            <div class="card">
                <div class="row align-items-center justify-content-center text-start">
                    <div class="col-xl-12">
                        <div class="card-body mx-auto my-4 new-login-design">
                            @yield('content')
                        </div>
                    </div>

                </div>
            </div>
            <div class="auth-footer">
                <div class="container-fluid text-center">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-black">
                                @if (isset($setting['footer_text']) &&
                                        (strpos($setting['footer_text'], '©') === false && strpos($setting['footer_text'], '&copy;') === false))
                                    &copy;
                                @endif

                                {{ date('Y') }}
                                {{ isset($setting['footer_text']) ? $setting['footer_text'] : config('app.name', 'E-CommerceGo') }}
                            </p>
                        </div>
                        <div class="col-6 text-end">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loader" class="loader-wrapper" style="display: none;">
        <span class="site-loader"> </span>
        <h3 class="loader-content"> {{ __('Loading . . .') }} </h3>
    </div>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('js/loader.js') }}"></script>
    @stack('scripts')
    
</body>

</html>
