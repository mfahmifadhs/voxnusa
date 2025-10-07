@extends('app')
@section('content')

<!-- Headline -->
<div class="container">
    <div class="bg0 flex-wr-sb-c p-rl-20 p-tb-8">
        <div class="f2-s-1 p-r-30 size-w-0 m-tb-6 flex-wr-s-c">
            <!-- <span class="text-uppercase cl2 p-r-8">
                Trending Now:
            </span>

            <span class="dis-inline-block cl6 slide100-txt pos-relative size-w-0" data-in="fadeInDown" data-out="fadeOutDown">
                <span class="dis-inline-block slide100-txt-item animated visible-false">
                    Interest rate angst trips up US equity bull market
                </span>

                <span class="dis-inline-block slide100-txt-item animated visible-false">
                    Designer fashion show kicks off Variety Week
                </span>

                <span class="dis-inline-block slide100-txt-item animated visible-false">
                    Microsoft quisque at ipsum vel orci eleifend ultrices
                </span>
            </span> -->
        </div>

        <form action="{{ route('home.posts') }}" method="GET">
            @csrf
            <div class="pos-relative size-a-2 bo-1-rad-22 of-hidden bocl11 m-tb-6">
                <input class="f1-s-1 cl6 plh9 s-full p-l-25 p-r-45" type="text" name="search" placeholder="Search">
                <button class="flex-c-c size-a-1 ab-t-r fs-20 cl2 hov-cl10 trans-03">
                    <i class="zmdi zmdi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Feature post -->
<section class="bg0">
    <div class="container">
        <div class="row m-rl--1">
            <div class="col-md-6 p-rl-1 p-b-2">
                <div class="bg-img1 size-a-3 how1 pos-relative" style="background-image: url('<?php echo asset('dist/img/thumbnail/' . $posts->sortByDesc('id')->first()->thumbnail); ?>');">
                    <a href="{{ route('home.post.detail', $posts->sortByDesc('id')->first()->slug) }}" class="dis-block how1-child1 trans-03"></a>

                    <div class="flex-col-e-s s-full p-rl-25 p-tb-20">
                        <a href="#" class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
                            {{ $posts->sortByDesc('id')->first()->subCategory->name }}
                        </a>

                        <h3 class="how1-child2 m-t-14 m-b-10">
                            <a href="{{ route('home.post.detail', $posts->sortByDesc('id')->first()->slug) }}" class="how-txt1 size-a-6 f1-l-1 cl0 hov-cl10 trans-03">
                                {{ $posts->sortByDesc('id')->first()->title }}
                            </a>
                        </h3>

                        <span class="how1-child2">
                            <span class="f1-s-4 cl11">
                                {{ $posts->sortByDesc('id')->first()->user->name }}
                            </span>

                            <span class="f1-s-3 cl11 m-rl-3">
                                -
                            </span>

                            <span class="f1-s-3 cl11">
                                {{ Carbon\Carbon::parse($posts->sortByDesc('id')->first()->published_at)->format('d M Y') }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 p-rl-1">
                <div class="row m-rl--1">
                    <div class="col-12 p-rl-1 p-b-2">
                        <div class="bg-img1 size-a-4 how1 pos-relative" style="background-image: url('<?php echo asset('dist/img/thumbnail/' . $posts->sortByDesc('id')->skip(1)->first()->thumbnail); ?>');">
                            <a href="{{ route('home.post.detail', $posts->sortByDesc('id')->first()->slug) }}" class="dis-block how1-child1 trans-03"></a>

                            <div class="flex-col-e-s s-full p-rl-25 p-tb-24">
                                <a href="#" class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
                                    {{ $posts->sortByDesc('id')->skip(1)->first()->subCategory->name }}
                                </a>

                                <h3 class="how1-child2 m-t-14">
                                    <a href="{{ route('home.post.detail', $posts->sortByDesc('id')->skip(1)->first()->slug) }}" class="how-txt1 size-a-7 f1-l-2 cl0 hov-cl10 trans-03">
                                        {{ $posts->sortByDesc('id')->skip(1)->first()->title }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    @foreach ($posts->sortByDesc('id')->skip(2)->take(2) as $row)
                    <div class="col-sm-6 p-rl-1 p-b-2">
                        <div class="bg-img1 size-a-5 how1 pos-relative" style="background-image: url('<?php echo asset('dist/img/thumbnail/' . $row->thumbnail); ?>');">
                            <a href="{{ route('home.post.detail', $row->slug) }}" class="dis-block how1-child1 trans-03"></a>

                            <div class="flex-col-e-s s-full p-rl-25 p-tb-20">
                                <a href="{{ route('home.post.detail', $row->slug) }}" class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
                                    {{ $row->category?->name }}
                                </a>

                                <h3 class="how1-child2 m-t-14">
                                    <a href="{{ route('home.post.detail', $row->slug) }}" class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
                                        {{ $row->title }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Post -->
<section class="bg0 p-t-70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="p-b-20">
                    <!-- Berita -->
                    @foreach ($pages->where('title', 'home-ctg') as $row)
                    <div class="tab01 p-b-20">
                        <div class="tab01-head how2 how2-cl7 bocl12 flex-s-c m-r-10 m-r-0-sr991">
                            <h3 class="f1-m-2 cl19 tab01-title">
                                {{ $row->category->name }}
                            </h3>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach ($row->category->subCategory as $key => $subRow)
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}"
                                        data-toggle="tab"
                                        href="#subcat-{{ $subRow->id }}"
                                        role="tab">
                                        {{ $subRow->name }}
                                    </a>
                                </li>
                                @endforeach


                                <li class="nav-item-more dropdown dis-none">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>

                                    <ul class="dropdown-menu">

                                    </ul>
                                </li>
                            </ul>

                            <a href="{{ route('home.category.show', $row->category->slug) }}"
                                class="tab01-link f1-s-1 cl9 hov-cl10 trans-03">
                                View all
                                <i class="fs-12 m-l-5 fa fa-caret-right"></i>
                            </a>
                        </div>

                        <!-- Tab panes -->
                        <div class="tab-content p-t-35">
                            @foreach ($row->category->subCategory as $key => $subRow)
                            <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                id="subcat-{{ $subRow->id }}"
                                role="tabpanel">

                                <div class="row">
                                    <!-- Post Besar -->
                                    <div class="col-md-6 p-r-25 p-r-15-sr991">
                                        @if ($subRow->posts->where('status', 'published')->first())
                                        @php $firstPost = $subRow->posts->first(); @endphp
                                        <div class="m-b-30">
                                            <a href="{{ route('home.post.detail', $firstPost->slug) }}" class="wrap-pic-w hov1 trans-03">
                                                <img src="{{ asset('dist/img/thumbnail/'.$firstPost->thumbnail) }}" alt="{{ $firstPost->title }}">
                                            </a>
                                            <div class="p-t-20">
                                                <h5 class="p-b-5">
                                                    <a href="{{ route('home.post.detail', $firstPost->slug) }}"
                                                        class="f1-m-3 cl2 hov-cl10 trans-03">
                                                        {{ $firstPost->title }}
                                                    </a>
                                                </h5>
                                                <span class="cl8">
                                                    <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                                                        {{ $firstPost->user->name }}
                                                    </a>
                                                    <span class="f1-s-3 m-rl-3">-</span>
                                                    <span class="f1-s-3">{{ Carbon\Carbon::parse($firstPost->published_at)->format('M d, Y') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Post Kecil -->
                                    <div class="col-md-6 p-r-25 p-r-15-sr991">
                                        @foreach ($subRow->posts->where('status', 'published')->skip(1)->take(3) as $post)
                                        <div class="flex-wr-sb-s m-b-30">
                                            <a href="{{ route('home.post.detail', $post->slug) }}" class="size-w-1 wrap-pic-w hov1 trans-03">
                                                <img src="{{ asset('dist/img/thumbnail/'.$post->thumbnail) }}" alt="{{ $post->title }}">
                                            </a>

                                            <div class="size-w-2">
                                                <h5 class="p-b-5">
                                                    <a href="{{ route('home.post.detail', $post->slug) }}"
                                                        class="f1-s-5 cl3 hov-cl10 trans-03">
                                                        {{ $post->title }}
                                                    </a>
                                                </h5>
                                                <span class="cl8">
                                                    <a href="#" class="f1-s-6 cl8 hov-cl10 trans-03">
                                                        {{ $post->user->name }}
                                                    </a>
                                                    <span class="f1-s-3 m-rl-3">-</span>
                                                    <span class="f1-s-3">{{ Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>


                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-10 col-lg-4">
                <div class="p-l-10 p-rl-0-sr991 p-b-20">
                    <!--  -->
                    <div class="how2 how2-cl4 flex-s-c">
                        <h3 class="f1-m-2 cl3 tab01-title">
                            Recent Articles
                        </h3>
                    </div>

                    <ul class="p-t-35">
                        @foreach ($posts->sortByDesc('id')->take(6) as $row)
                        <li class="flex-wr-sb-s p-b-22">
                            <div class="size-a-8 flex-c-c borad-3 size-a-8 bg9 f1-m-4 cl0 m-b-6">
                                {{ $loop->iteration }}
                            </div>

                            <a href="{{ route('home.post.detail', $row->slug) }}" class="size-w-3 f1-s-7 cl3 hov-cl10 trans-03">
                                {{ $row->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <!--  -->
                    <div class="flex-c-s p-t-8">
                        <a href="#">
                            <img class="max-w-full" src="{{ asset('dist/img/banner-02.jpg') }}" alt="IMG">
                        </a>
                    </div>

                    <!--  -->
                    <div class="p-t-50">
                        <div class="how2 how2-cl4 flex-s-c">
                            <h3 class="f1-m-2 cl3 tab01-title">
                                Stay Connected
                            </h3>
                        </div>

                        <ul class="p-t-35">
                            <li class="flex-wr-sb-c p-b-20">
                                <a href="#" class="size-a-8 flex-c-c borad-3 size-a-8 bg-facebook fs-16 cl0 hov-cl0">
                                    <span class="fab fa-facebook-f"></span>
                                </a>

                                <div class="size-w-3 flex-wr-sb-c">
                                    <span class="f1-s-8 cl3 p-r-20">
                                        6879 Fans
                                    </span>

                                    <a href="#" class="f1-s-9 text-uppercase cl3 hov-cl10 trans-03">
                                        Like
                                    </a>
                                </div>
                            </li>

                            <li class="flex-wr-sb-c p-b-20">
                                <a href="#" class="size-a-8 flex-c-c borad-3 size-a-8 bg-twitter fs-16 cl0 hov-cl0">
                                    <span class="fab fa-twitter"></span>
                                </a>

                                <div class="size-w-3 flex-wr-sb-c">
                                    <span class="f1-s-8 cl3 p-r-20">
                                        568 Followers
                                    </span>

                                    <a href="#" class="f1-s-9 text-uppercase cl3 hov-cl10 trans-03">
                                        Follow
                                    </a>
                                </div>
                            </li>

                            <li class="flex-wr-sb-c p-b-20">
                                <a href="#" class="size-a-8 flex-c-c borad-3 size-a-8 bg-youtube fs-16 cl0 hov-cl0">
                                    <span class="fab fa-youtube"></span>
                                </a>

                                <div class="size-w-3 flex-wr-sb-c">
                                    <span class="f1-s-8 cl3 p-r-20">
                                        5039 Subscribers
                                    </span>

                                    <a href="#" class="f1-s-9 text-uppercase cl3 hov-cl10 trans-03">
                                        Subscribe
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Banner -->
<div class="container">
    <div class="flex-c-c">
        <a href="#">
            <img class="max-w-full" src="{{ asset('dist/img/banner-01.jpg') }}" alt="IMG">
        </a>
    </div>
</div>

<!-- Latest -->
<section class="bg0 p-t-60 p-b-35">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 p-b-20">
                <div class="how2 how2-cl4 flex-s-c m-r-10 m-r-0-sr991">
                    <h3 class="f1-m-2 cl3 tab01-title">
                        Latest Articles
                    </h3>
                </div>

                <div class="row p-t-35">
                    @foreach ($posts->sortBy('desc')->take(6) as $row)
                    <div class="col-sm-6 p-r-25 p-r-15-sr991">
                        <!-- Item latest -->
                        <div class="m-b-45">
                            <a href="{{ route('home.post.detail', $row->slug) }}" class="wrap-pic-w fit-img hov1 trans-03">
                                <img src="{{ asset('dist/img/thumbnail/'. $row->thumbnail) }}" alt="IMG">
                            </a>

                            <div class="p-t-16">
                                <h5 class="p-b-5">
                                    <a href="{{ route('home.post.detail', $row->slug) }}" class="f1-m-3 cl2 hov-cl10 trans-03">
                                        {{ $row->title }}
                                    </a>
                                </h5>

                                <span class="cl8">
                                    <a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
                                        by {{ $row->user->name }}
                                    </a>

                                    <span class="f1-s-3 m-rl-3">
                                        -
                                    </span>

                                    <span class="f1-s-3">
                                        {{ Carbon\Carbon::parse($row->published_at)->format('d M Y') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-10 col-lg-4">
                <div class="p-l-10 p-rl-0-sr991 p-b-20">

                    <!-- Tag -->
                    <div class="p-b-55">
                        <div class="how2 how2-cl4 flex-s-c m-b-30">
                            <h3 class="f1-m-2 cl3 tab01-title">
                                Tags
                            </h3>
                        </div>

                        <div class="flex-wr-s-s m-rl--5">
                            @foreach ($tags as $row)
                            <a href="#" class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                {{ $row->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
