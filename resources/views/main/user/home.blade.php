@extends('main.user.layouts.master')

@section('title','MCL')

@section('content')
    <!-- home section start  -->
    <section id="home">
        <div>
            <img src="{{ asset('user/image/home.jpg') }}" class="w-100 d-block" alt="">
            <div id="home-content">
                <h1 class="animate__animated animate__fadeInDown">Design &</h1>
                <h1 class="animate__animated animate__fadeInDown">Development Team</h1>
                @if ($infos && $infos->home_letter)
                    <p class="animate__animated animate__fadeInDown animate__delay-1s">
                        {{ $infos->home_letter }}
                    </p>
                @endif

                <a href="{{ route('user#contact') }}" class="">
                    <button class="btn animate__animated animate__fadeInDown animate__delay-2s" id="contact">Contact Us<i class="fa-solid fa-arrow-right ms-2"></i></button>
                </a>
            </div>
        </div>
    </section>
    <!-- home section end  -->


    <!-- partner company start  -->
    <section id="partner-company" class="container-lg">
        <div class="text-center">
            <h3>Clients We Work With</h3>
            <p>Partners</p>
        </div>
        <div class="row align-items-center mt-4">
            @foreach ($clientLogos as $c)
            <div class="col-lg-3 col-md-3 col-sm-4 mb-2">
                <img src="{{ asset('storage/client-logo/'.$c->image) }}" class="d-block w-100" alt="">
            </div>
            @endforeach
        </div>
    </section>
    <!-- partner company end  -->

    <!-- cases start  -->
    <section id="web-case" class="container-fluid px-3">
        <div class="text-center">
            <h3>Web Case studies</h3>
            <p>Portfolio</p>
        </div>
        <div id="case-content">
            <a href="{{ route('user#caseList') }}">See All Cases <i class="fa-solid fa-arrow-right-long ms-1"></i></a>
            <div class="swiper mySwiper mt-3">
                <div class="swiper-wrapper">
                    @foreach ($projects as $p)
                    <div class="swiper-slide">
                        <div class="row">
                            <div class="col-lg-8 p-0 order-lg-1">
                                @php
                                    $images = json_decode($p->images, true);
                                @endphp
                                <img src="{{ asset('storage/projects/'.$images[1]) }}" alt="">
                            </div>
                            <div class="col-lg-4">
                                <a href="{{ route('user#caseView',$p->id) }}">
                                    <h4>{{ $p->name }}</h4>
                                </a>
                                <label for="">{{ $p->type }}</label>
                                <p>{{ $p->paragraph1 }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <!-- cases end  -->


    <!-- review start  -->
    <section id="review" class="container-lg">
        <h3>Clients' testimonials</h3>
        <div class="swiper mySwiper2 mt-4">
            <div class="swiper-wrapper">
                @if (count($clientTestis) != 0)
                    @foreach ($clientTestis as $c)
                    <div class="swiper-slide">
                        <h6 class="fw-medium">{{ $c->name }}</h6>
                        <span>{{ $c->position }}</span>
                        <hr>
                        <p>"{{ $c->description }}"</p>
                    </div>
                    @endforeach
                @else
                    <div class="text-center mx-auto mt-4 text-secondary">
                        <h5>There is no review yet!</h5>
                    </div>
                @endif
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- review end  -->
@endsection
