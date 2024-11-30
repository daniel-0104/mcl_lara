@extends('main.user.layouts.master')

@section('title','MCL')

@section('content')
    <!-- profile start  -->
    <section class="container-lg" id="profile-page">
        @if(session('updateSuccess'))
            <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                <div class="col-lg-6 offset-6 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('updateSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="personal">
            <h3>Personal Information</h3>
            <div class="container-lg">
                <div id="contact-content">
                    <form action="{{ route('user#pfpUpdate',Auth::user()->id) }}" method="POST" class="update-btn-group">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-6 col-sm-6 mb-4">
                                <label for="">Name</label>
                                <input type="text" name="name" value="{{ old('name',Auth::user()->name) }}" class="form-control mt-2 @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-4">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{ old('email',Auth::user()->email) }}" class="form-control mt-2 @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn py-1" type="submit" id="submit" disabled>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="personal">
            <h3>Product Package</h3>
            <div class="container-lg">
                @if ($orderCounts->isNotEmpty())
                    @if($orders->status == 0)
                        <div id="order-pending">
                            <h6>Your order code <span class="text-primary">{{ $orders->order_code }}</span> is still pending. Please contact us if it is taking longer than expected.</h6>
                        </div>
                    @elseif($orders->status == 1)
                        @php
                            $groupedOrders = $orderLists->groupBy(function($order) {
                                return $order->plan . '-' . $order->price . '-' . $order->duration;
                            });
                        @endphp
                        <div id="contact-content">
                            @foreach ($groupedOrders as $groupKey => $group)
                                @php
                                    $order = $group->first();
                                    $orderQty = $order->qty;
                                @endphp
                                <div class="row mx-auto mt-4 mb-5" id="package-detail">
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <label for="">Plan</label>
                                        <h6 class="mt-1">{{ $order->plan }}</h6>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <label for="">Pricing</label>
                                        <h6 class="mt-1">{{ number_format($order->price) }} Ks</h6>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <label for="">Billing Duration</label>
                                        <h6 class="mt-1">{{ $order->duration }}
                                            @if ($group->count() > 1)
                                                ({{ $orderQty }})
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <label for="">Status</label>
                                        <h6 class="mt-1 text-success"><i class="fa-regular fa-square-check me-2"></i>Active</h6>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <div class="row mx-auto mt-4" id="package-detail">
                                <div class="col-lg-6 col-sm-6">
                                    <label for="">Contract Start Date</label>
                                    <h6 class="mt-1">{{ \Carbon\Carbon::parse($orders->start_date)->format('l, F jS, Y') }}</h6>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label for="">Contract End Date</label>
                                    @if($orders->end_date === 'sold')
                                        <h6 class="mt-1 text-success"><i class="fa-regular fa-square-check me-2"></i>Successfully Transferred</h6>
                                    @else
                                        <h6 class="mt-1">
                                            {{ \Carbon\Carbon::parse($orders->end_date)->setTimezone('Asia/Yangon')->format('l, F jS, Y') }}
                                        </h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif($orders->status == 2)
                        <div id="order-pending">
                            <h6>Your order code with <span class="text-primary">{{ $orders->order_code }}</span> has been rejected. If you have any questions, please contact our support team.</h6>
                        </div>
                    @elseif($orders->status == 3)
                        <div id="order-empty">
                            <h6>Your order code with <span class="text-primary">{{ $orders->order_code }}</span> has been expired.</h6>
                            <p>Please purchase a new plan within <strong>30 minutes</strong>.  If you do not renew within this period, your website may no longer function properly.</p>
                            <div class="mt-3" id="pfp-price">
                                <a href="{{ route('user#caseView',$projects->id) }}">
                                    <button class="btn py-2" id="submit">Buy Plan<i class="fa-solid fa-arrow-right ms-2"></i></button>
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                <div id="order-empty">
                    <h6>{{ $projects->price_letter }}</h6>
                    <div class="mt-3" id="pfp-price">
                        <a href="{{ route('user#caseView',$projects->id) }}">
                            <button class="btn py-2" id="submit">Buy Plan<i class="fa-solid fa-arrow-right ms-2"></i></button>
                        </a>
                    </div>
                </div>

                @endif



            </div>
        </div>
    </section>
    <!-- profile end  -->
@endsection


@section('scriptSource')
    <script>
        const updateBtnFormElements = document.querySelectorAll('.update-btn-group input');
        const updateBtn = document.getElementById('submit');

        const initialValues = {};

        updateBtnFormElements.forEach(element => {
            initialValues[element.name] = element.value;
        });

        function checkUpdateValueForBtn() {
            let hasChanged = false;
            updateBtnFormElements.forEach(element => {
                if (element.value != initialValues[element.name]) {
                    hasChanged = true;
                }
            });
            updateBtn.disabled = !hasChanged;
        }

        updateBtnFormElements.forEach(element => {
            element.addEventListener('input', checkUpdateValueForBtn);
            element.addEventListener('change', checkUpdateValueForBtn);
        });
        checkUpdateValueForBtn();
    </script>
@endsection

