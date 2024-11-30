@extends('main.user.layouts.master')

@section('title','MCL')

@section('content')
    <!-- cart start  -->
    <section class="container-lg" id="cart-page">
        <div>
            <div class="d-flex align-items-center justify-content-between" id="cart-title">
                <h3>Package Cart</h3>
                <label class="ms-5"><span>{{ count($carts) }}</span> Plan</label>
            </div>
            <hr>
            <div class="container-lg">
                <div class="row mt-4">
                    <div class="col-lg-8">
                        @if (count($carts) != 0)
                            @foreach ($carts as $c)
                                <div class="cart-content">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <form action="{{ route('ajax#cartRemove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="cartId" value="{{ $c->id }}">
                                            <button type="submit" class="btn border delete-btn" title="Delete">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div id="contact-content">
                                        <div class="row text-center" id="package-detail">
                                            <div class="col-lg-4 col-md-4 col-sm-6">
                                                <label for="">Plan</label>
                                                <h5 class="mt-1" id="cartPlan">{{ $c->plan }}</h5>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-6">
                                                <label for="">Pricing</label>
                                                <h5 class="mt-1" id="price">{{ number_format($c->price) }} Ks</h5>
                                            </div>
                                            <input type="hidden" id="cartUserName" value="{{ $c->user_name }}">
                                            <input type="hidden" id="cashPrice" value="{{ $c->cash_back }}">
                                            <input type="hidden" id="cartPricing" value="{{ $c->price }}">
                                            <div class="col-lg-4 col-md-4 col-sm-6">
                                                <label for="">Billing Duration</label>
                                                <h5 class="mt-1" id="cartDuration">{{ $c->duration }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center mx-auto text-secondary my-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-x"><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/><path d="m17 13 5 5m-5 0 5-5"/></svg>
                                <p class="mt-3">Oops! Nothing in Your Cart Yet</p>
                                <div class="mt-4">
                                    <a href="{{ route('user#caseView',$projects->id) }}">
                                        <button class="btn text-white px-4" id="buy-package">Buy Plan</button>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div id="summary">
                            <h5 class="text-uppercase text-center fw-bold">Summary</h5>
                            <div class="mt-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <label for="">Subtotal</label>
                                    <label id="subTotalPrice">{{ number_format($totalPrice) }} Ks</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <label for="">Cashback <br><span class="cash-business">( OwnerShip Transfer )</span></label>
                                    <label id="cashTotalPrice">{{ number_format($cashPrice ?? 0) }} Ks</label>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-between">
                                    <label for="">Total</label>
                                    <label id="finalPrice">{{ number_format($totalPrice - $cashPrice) }} Ks</label>
                                </div>
                                <input type="hidden" id="finalPriceHidden" value="0">
                            </div>
                            @if (count($carts) != 0)
                                <button class="btn fw-bold w-100 checkOut" id="price-plans">CheckOut</button>
                            @else
                                <button class="btn fw-bold w-100" id="price-plans" disabled>CheckOut</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart end  -->
@endsection


@section('scriptSource')
    <script>
        $(document).ready(function() {
            function summaryCalculation() {
                let totalPrice = 0;
                let cashPrice = 0;

                $('.cart-content').each(function () {
                    let priceText = $(this).find('#price').text();
                    let price = parseFloat(priceText.replace(/[^0-9.]/g, '').trim());
                    if (!isNaN(price)) {
                        totalPrice += price;
                    }

                    let cashText = $(this).find('#cashPrice').val();
                    let cash = parseFloat(cashText.replace(/[^0-9.]/g, '').trim());
                    if (!isNaN(cash)) {
                        cashPrice += cash;
                    }
                });

                $('#subTotalPrice').text(`${totalPrice.toLocaleString()} Ks`);
                $('#cashTotalPrice').text(`${cashPrice.toLocaleString()} Ks`);
                $('#finalPrice').text(`${(totalPrice - cashPrice).toLocaleString()} Ks`);
                $('#finalPriceHidden').val(totalPrice - cashPrice);
            }
            summaryCalculation();
        });

        //ckeck out btn
        $('.checkOut').click(function(){
            const finalPrice = $('#finalPriceHidden').val();
            let $orderList = [];
            $random = Math.floor(Math.random() * 10000001);

            $('.cart-content').each(function () {
                const cashBack = $(this).find('#cashPrice').val() || '0';

                $orderList.push({
                    'user_name' : $(this).find('#cartUserName').val(),
                    'plan' : $(this).find('#cartPlan').text(),
                    'price' : $(this).find('#cartPricing').val(),
                    'cash_back' : cashBack,
                    'duration' : $(this).find('#cartDuration').text(),
                    'order_code' : 'MCl' + $random
                });
            });

            $.ajax({
                type : 'get',
                url : '/ajax/checkout',
                data: {
                    orderList: $orderList,
                    finalPrice: finalPrice
                },
                dataType : 'json',
                success : function(response){
                    if(response.status == 'true'){
                        alert('The package was ordered successfully');
                        window.location.href = '/account/profile';
                        $orderList = [];
                        $('.cart-content').remove();
                        $('#finalPrice').text('0');
                    }
                }
            });
        });

    </script>
@endsection
