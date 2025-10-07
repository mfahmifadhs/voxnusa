<!DOCTYPE html>
<html lang="en">

<head>
    <title>Voxnusa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('dist/img/icon.png') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/plugins/bootstrap/css/bootstrap.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/plugins/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/plugins/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/plugins/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/util.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/main.css') }}">
    <!--===============================================================================================-->
</head>

<body class="animsition">

    <!-- Header -->
    <header>
        <!-- Header desktop -->
        <div class="container-menu-desktop">
            <div class="topbar">
                <div class="content-topbar container h-100">
                    <div class="left-topbar">
                        <a href="#" class="left-topbar-item">
                            About
                        </a>

                        <a href="#" class="left-topbar-item">
                            Contact
                        </a>

                        <a href="{{ route('login') }}" class="left-topbar-item">
                            Log in
                        </a>
                    </div>

                    <div class="right-topbar">
                        <a href="#">
                            <span class="fab fa-facebook-f"></span>
                        </a>

                        <a href="#">
                            <span class="fab fa-twitter"></span>
                        </a>

                        <a href="#">
                            <span class="fab fa-pinterest-p"></span>
                        </a>

                        <a href="#">
                            <span class="fab fa-vimeo-v"></span>
                        </a>

                        <a href="#">
                            <span class="fab fa-youtube"></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Header Mobile -->
            <div class="wrap-header-mobile">
                <!-- Logo moblie -->
                <div class="logo-mobile">
                    <a href="{{ url('') }}"><img src="{{ asset('dist/img/logo.png') }}" alt="IMG-LOGO"></a>
                </div>

                <!-- Button show menu -->
                <div class="btn-show-menu-mobile hamburger hamburger--squeeze m-r--8">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div class="menu-mobile">
                <ul class="topbar-mobile">

                    <li class="left-topbar">
                        <a href="#" class="left-topbar-item">
                            About
                        </a>

                        <a href="#" class="left-topbar-item">
                            Contact
                        </a>

                        <a href="#" class="left-topbar-item">
                            Sing up
                        </a>

                        <a href="{{ route('login') }}" class="left-topbar-item">
                            Log in
                        </a>
                    </li>

                    <li class="right-topbar">
                        <a href="#">
                            <span class="fab fa-facebook-f"></span>
                        </a>

                        <a href="#">
                            <span class="fab fa-twitter"></span>
                        </a>

                        <a href="#">
                            <span class="fab fa-pinterest-p"></span>
                        </a>

                        <a href="#">
                            <span class="fab fa-vimeo-v"></span>
                        </a>

                        <a href="#">
                            <span class="fab fa-youtube"></span>
                        </a>
                    </li>
                </ul>

                <ul class="main-menu-m">
                    <li>
                        <a href="{{ route('home', $row->id) }}">{{ $row->name }}</a>
                    </li>
                    @foreach ($category as $row)
                    <li>
                        <a href="{{ route('home.category.show', $row->id) }}">{{ $row->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!--  -->
            <div class="wrap-logo container">
                <!-- Logo desktop -->
                <div class="logo">
                    <a href="{{ url('') }}">
                        <img src="{{ asset('dist/img/logo.png') }}" alt="">
                    </a>
                </div>

                <!-- Banner -->
                <div class="banner-header">
                    <a href="#">
                        <img src="{{ asset('dist/img/banner-01.jpg') }}" alt="IMG">
                    </a>
                </div>
            </div>

            <div class="wrap-main-nav">
                <div class="main-nav">
                    <!-- Menu desktop -->
                    <nav class="menu-desktop">
                        <a class="logo-stick" href="index.html">
                            <img src="{{ asset('dist/img/logo.png') }}" alt="LOGO">
                        </a>

                        <ul class="main-menu">
                            <li class="main-menu-active home">
                                <a href="{{ route('home') }}">Home</a>
                            </li>

                            @foreach ($category as $row)
                            <li class="mega-menu-item">
                                <a href="{{ route('home.category.show', $row->slug) }}">{{ $row->name }}</a>

                                <div class="sub-mega-menu">
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="news-0" role="tabpanel">
                                            <div class="row">
                                                @if ($row->post->where('status', 'published')->count() != 0)
                                                @foreach ($row->post->where('status', 'published') as $subRow)
                                                <div class="col-3">
                                                    <!-- Item post -->
                                                    <div>
                                                        <a href="{{ route('home.post.detail', $subRow->slug ) }}" class="wrap-pic-w hov1 trans-03">
                                                            <img src="{{ asset('dist/img/thumbnail/'. $subRow->thumbnail) }}" alt="IMG">
                                                        </a>

                                                        <div class="p-t-10">
                                                            <h5 class="p-b-5">
                                                                <a href="blog-detail-01.html" class="f1-s-5 cl3 hov-cl10 trans-03">
                                                                    {{ $subRow->title }}
                                                                </a>
                                                            </h5>

                                                            <span class="cl8">
                                                                <a href="#" class="f1-s-6 cl8 hov-cl10 trans-03">
                                                                    {{ $subRow->category->name }}
                                                                </a>

                                                                <span class="f1-s-3 m-rl-3">
                                                                    -
                                                                </span>

                                                                <span class="f1-s-3">
                                                                    {{ Carbon\Carbon::parse($subRow->published_at)->format('d M Y') }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @else
                                                <div class="col-12 align-middle">
                                                    Tidak ada data
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="bg2 p-t-40 p-b-25">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 p-b-20">
                        <div class="size-h-3 flex-s-c">
                            <a href="index.html">
                                <img class="max-s-full" src="{{ asset('dist/img/logo-white.png') }}" alt="LOGO">
                            </a>
                        </div>

                        <div>
                            <p class="f1-s-1 cl0 p-b-16">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tempor magna eget elit efficitur, at accumsan sem placerat. Nulla tellus libero, mattis nec molestie at, facilisis ut turpis. Vestibulum dolor metus, tincidunt eget odio
                            </p>

                            <p class="f1-s-1 cl0 p-b-16">
                                Any questions? Call us on (+1) 96 716 6879
                            </p>

                            <div class="p-t-15">
                                <a href="#" class="fs-18 cl0 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-facebook-f"></span>
                                </a>

                                <a href="#" class="fs-18 cl0 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-twitter"></span>
                                </a>

                                <a href="#" class="fs-18 cl0 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-pinterest-p"></span>
                                </a>

                                <a href="#" class="fs-18 cl0 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-vimeo-v"></span>
                                </a>

                                <a href="#" class="fs-18 cl0 hov-cl10 trans-03 m-r-8">
                                    <span class="fab fa-youtube"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 p-b-20">
                        <div class="size-h-3 flex-s-c">
                            <h5 class="f1-m-7 cl0">
                                Recent Posts
                            </h5>
                        </div>

                        <ul>
                            @foreach ($posts->sortBy('desc')->take(3) as $row)
                            <li class="flex-wr-sb-s p-b-20">
                                <a href="#" class="size-w-4 wrap-pic-w hov1 trans-03">
                                    <img src="{{ asset('dist/img/thumbnail/'. $row->thumbnail) }}" alt="IMG">
                                </a>

                                <div class="size-w-5">
                                    <h6 class="p-b-5">
                                        <a href="#" class="f1-s-5 cl0 hov-cl10 trans-03">
                                            {{ $row->title }}
                                        </a>
                                    </h6>

                                    <span class="f1-s-3 cl6">
                                        {{ Carbon\Carbon::parse($row->published_at)->format('d M Y') }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-sm-6 col-lg-4 p-b-20">
                        <div class="size-h-3 flex-s-c">
                            <h5 class="f1-m-7 cl0">
                                Category
                            </h5>
                        </div>

                        <ul class="m-t--12">
                            @foreach ($category as $row)
                            <li class="how-bor1 p-rl-5 p-tb-10">
                                <a href="{{ route('home.category.show', $row->slug) }}" class="f1-s-5 cl0 hov-cl10 trans-03 p-tb-8">
                                    {{ $row->name }} ({{ $row->post->where('status', 'published')->count() }})
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg2">
            <div class="container size-h-4 flex-c-c p-tb-15">
                <span class="f1-s-1 cl0 txt-center">
                    <a href="#" class="f1-s-1 cl0 hov-link1">
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </span>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <span class="fas fa-angle-up"></span>
        </span>
    </div>

    <!-- Modal Video 01-->
    <div class="modal fade" id="modal-video-01" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" data-dismiss="modal">
            <div class="close-mo-video-01 trans-0-4" data-dismiss="modal" aria-label="Close">&times;</div>

            <div class="wrap-video-mo-01">
                <div class="video-mo-01">
                    <iframe src="https://www.youtube.com/embed/wJnBTPUQS5A?rel=0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('dist/plugins/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('dist/plugins/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('dist/js/main.js') }}"></script>

</body>

</html>
