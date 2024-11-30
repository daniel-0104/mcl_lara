@extends('main.user.layouts.master')

@section('title','Case Studies')

@section('content')
    <!-- case details start  -->
    <section class="container-lg" id="case-detail">
        <div id="project-detail-title">
            <h1>{{ $projects->name }}</h1>
            <p>{{ $projects->paragraph2 }}</p>
            @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'developer' ||
                    (Auth::user()->role === 'user' && Auth::user()->project_permission == $projects->project_permission)))
                    <a href="#price-plan-content">
                        <button class="btn" id="price-plans">Price Plans<i class="fa-solid fa-arrow-down ms-2"></i></button>
                    </a>
            @endif
        </div>
        <div id="about-project">
            <div>
                <span>Service Type</span>
                <p>{{ $projects->type }}</p>
            </div>
            <div>
                <span>Project duration</span>
                <p>{{ $projects->project_duration }}</p>
            </div>
            <div>
                <span>Client Website</span>
                <p><a href="{{ $projects->website_link }}" target="_blank">{{ $projects->website_link }}</a></p>
            </div>
        </div>
        <div id="screens">
            <div>
                <h2>Screens</h2>
            </div>
            <div>
                @php
                    $images = json_decode($projects->images, true);
                @endphp
                @foreach ($images as $image)
                    <img src="{{ asset('storage/projects/'.$image) }}" class="w-100 d-block" alt="">
                @endforeach
            </div>
        </div>
    </section>
    <!-- case details end  -->

    <div  id="price-plan-content" class="mb-5"></div>

    @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'developer' ||
                            (Auth::user()->role === 'user' && Auth::user()->project_permission == $projects->project_permission)))
        <hr>

        <!-- price plan start  -->
        <section id="price-plan">
            <div class="px-5">
                <h2>Pricing & Plans</h2>
                <p class="mt-3">{{ $projects->price_letter }}</p>
            </div>
            <div id="plan-expire">
                @foreach ($categories as $category)
                    <a href="javascript:void(0)" class="text-decoration-none me-2">
                        <button
                            class="btn text-content {{ $loop->first ? 'text-active' : '' }}"
                            onclick="detailsClick(event, 'category-{{ $category->id }}')">
                            {{ $category->name }}
                        </button>
                    </a>
                @endforeach
            </div>
            @foreach ($categories as $category)
                <div class="container-lg plan-section" id="category-{{ $category->id }}" style="display: {{ $loop->first ? 'block' : 'none' }};">
                    <div class="row mt-4 mx-auto">
                        @foreach ($plans->where('time', $category->name) as $p)
                            <div class="col-lg-4 col-md-6 mx-auto mb-4 package-plan">
                                <div class="plan-content d-flex flex-column h-100">
                                    <div class="mb-4">
                                        <span>{{ $p->title }}</span>
                                        <h2>{{ number_format($p->price) }} Ks</h2>
                                        <span class="expire">{{ $p->time }}</span>
                                        @if ($p && $p->cash_back)
                                            <div id="cash-back">
                                                <p>
                                                    <i class="fa-solid fa-angles-right"></i>
                                                    {{ number_format($p->cash_back) }} Ks cash back
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    <ul class="ps-3">
                                        @foreach (explode("\n", $p->description) as $feature)
                                            <li class="mb-3">
                                                <i class="fa-solid fa-circle-check me-2"></i>
                                                {{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <button class="btn addCartBtn" id="order-btn"
                                        data-user-name="{{ Auth::user()->name }}"
                                        data-user-plan="{{ $p->title }}"
                                        data-user-price="{{ $p->price }}"
                                        data-user-cash="{{ $p->cash_back }}"
                                        data-user-time="{{ $p->time }}">Buy Now</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @foreach ($startPlans->where('time', $category->name) as $sp)
                        <div id="starter-plan" class="row mt-4">
                            <div class="plan-content">
                                <div class="mb-4">
                                    <span>{{ $sp->title }} / </span>
                                    <span>{{ $sp->time }}</span>
                                </div>
                                <ul class="ps-3">
                                    @foreach (explode("\n",$sp->starter_plan) as $detail)
                                        @php
                                            $parts = explode('=>',$detail);
                                        @endphp
                                        @if(count($parts) == 2)
                                            <li class="mb-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <i class="fa-solid fa-circle-check me-1"></i>
                                                        {{ trim($parts[0]) }}
                                                    </div>
                                                    <div class="pe-5">
                                                        <i class="fa-solid fa-caret-right me-3"></i>
                                                        {{ number_format(trim($parts[1])) }} Ks
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <button class="btn addCartBtn" id="order-btn-start"
                                    data-user-name="{{ Auth::user()->name }}"
                                    data-user-plan="{{ $sp->title }}"
                                    data-user-price="{{ trim($parts[1]) }}"
                                    data-user-time="{{ $sp->time }}">Buy Now</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <div class="conatainer-lg" id="service-plan" >
                <p>All our plans come with 24/7 service at a standard cost of  <span>{{ number_format($infos->service_price) }}</span> Kyats.</p>
                <a href="">
                    <button class="btn fw-bold" id="price-plans">Contact Us<i class="fa-solid fa-arrow-right ms-2"></i></button>
                </a>
            </div>
        </section>
        <!-- price plan end  -->
    @else
        <section>
            <div id="new-project">
                <h5>Have a project you'd like to discuss?</h5>
                <a href="{{ route('user#contact') }}">
                    <button class="btn fw-bold" id="price-plans">Contact Us<i class="fa-solid fa-arrow-right ms-2"></i></button>
                </a>
            </div>
        </section>
    @endif
@endsection


@section('scriptSource')
    <script>
        $(document).ready(function () {
            $('.addCartBtn').click(function () {
                let totalPrice = 0;

                if ($(this).attr('id') === 'order-btn-start') {
                    $(this)
                        .closest('.plan-content')
                        .find('ul li .pe-5')
                        .each(function () {
                            const priceText = $(this).text().trim();
                            const price = parseFloat(priceText.replace(/[^0-9]/g, ''));
                            if (!isNaN(price)) {
                                totalPrice += price;
                            }
                        });

                    $(this).data('user-price', totalPrice);
                } else {
                    totalPrice = parseFloat($(this).data('user-price'));
                }

                $('#total-price').text(totalPrice.toLocaleString());

                const source = {
                    userName: $(this).data('user-name'),
                    userPlan: $(this).data('user-plan'),
                    userPrice: $(this).data('user-price'),
                    userCash: $(this).data('user-cash') || 0,
                    userTime: $(this).data('user-time')
                };
                $.ajax({
                    type : 'get',
                    url : '/ajax/cart',
                    data : source,
                    dataType : 'json',
                    success : function(response){
                        if(response.status == 'Success'){
                            window.location.reload();
                            alert('The Plan was successfully added to the cart');
                        }
                    }
                });
            });
        });
    </script>
@endsection
