@extends('app')
@section('content')


<!-- Breadcrumb -->
<div class="container">
    <div class="headline bg0 flex-wr-sb-c p-rl-20 p-tb-8">
        <div class="f2-s-1 p-r-30 m-tb-6">
            <a href="{{ route('home') }}" class="breadcrumb-item f1-s-3 cl9">
                Home
            </a>

            <a href="{{ route('home.posts') }}" class="breadcrumb-item f1-s-3 cl9">
                data
            </a>

            <span class="breadcrumb-item f1-s-3 cl9">
                Search
            </span>
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

<!-- Page heading -->
@if ($search)
<div class="container p-t-4 p-b-40">
    <h2 class="f1-l-1 cl2">
        Pencarian "{{ $search }}"
    </h2>
</div>
@endif

<!-- Post -->
<section class="bg0 p-b-55">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 p-b-80">
                <div class="row">
                    @foreach ($data as $row)
                    <div class="col-sm-6 p-r-25 p-r-15-sr991">
                        <!-- Item latest -->
                        <div class="m-b-45">
                            <a href="{{ route('home.post.detail', $row->slug) }}" class="wrap-pic-w fit-img hov1 trans-03">
                                <img src="{{ asset('dist/img/thumbnail/'. $row->thumbnail) }}" alt="IMG">
                            </a>

                            <div class="p-t-16">
                                <h5 class="p-b-5">
                                    <a href="blog-detail-01.html" class="f1-m-3 cl2 hov-cl10 trans-03">
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

                    @if ($data->count() == 0)
                    <span class="ml-3">Tidak ada data</span>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="flex-wr-s-c m-rl--7 p-t-15">
                    <!-- <a href="#" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 pagi-active"></a> -->
                    {{ $data->links('pagination::bootstrap-4') }}
                </div>
            </div>

            <div class="col-md-10 col-lg-4 p-b-80">
                <div class="p-l-10 p-rl-0-sr991">
                    <!-- Most Popular -->
                    <div class="p-b-23">
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
                    </div>

                    <!--  -->
                    <div class="flex-c-s p-b-50">
                        <a href="#">
                            <img class="max-w-full" src="{{ asset('dist/img/banner-02.jpg') }}" alt="IMG">
                        </a>
                    </div>

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
