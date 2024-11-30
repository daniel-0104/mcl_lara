@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Orders')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
<main class="content px-3 py-4">
    <div class="container-fluid">
        <div class="d-flex align-items-center ms-1">
            <a href="{{ route('order#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
        </div>

        @php
            $counter = 1;
        @endphp

        <div id="order-table">
            <div class="my-3 align-items-center" id="order-view">
                <div class="d-flex align-items-center">
                    <label for="" class="me-2">
                        <i class="fa-solid fa-user"></i> Client Name :
                    </label>
                    <h5 class="mt-2">{{ $orderLists[0]->user_name }}</h5>
                </div>
                <div class="mt-3 d-flex align-items-center">
                    <label for="" class="me-2">
                        <i class="fa-solid fa-barcode"></i> Order Code :
                    </label>
                    <h5 class="mt-2">{{ $orderLists[0]->order_code }}</h5>
                </div>
                <div class="mt-3 d-flex align-items-center">
                    <label for="" class="me-2">
                        <i class="fa-solid fa-calendar"></i> Order Date :
                    </label>
                    <h5 class="mt-2">
                        {{ $orderLists[0]->created_at->setTimezone('Asia/Yangon')->format('j-F-Y') }} <br>
                        {{ $orderLists[0]->created_at->setTimezone('Asia/Yangon')->format('g:i A') }}
                    </h5>
                </div>
                <div class="mt-3 d-flex align-items-center">
                    <label for="" class="me-2">
                        <i class="fa-solid fa-dollar"></i> Total Price :
                        <br>
                    </label>
                    <h5 class="mt-2">{{ number_format($orders->total_price) }} Ks</h5>
                </div>
            </div>

            @php
                $counter = 1;
            @endphp

            <div id="table-bg">
                <div class="my-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Plan</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Cash Back</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderLists as $o)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $o->plan }}</td>
                                        <td class="text-end">{{ number_format($o->price) }}</td>
                                        <td>{{ $o->duration }}</td>
                                        <td class="text-end">{{ number_format($o->cash_back) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if ($orders->status == 1 || $orders->status == 3)
            <div id="table-bg" class="mt-5">
                <div class="my-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Contract Start Date</th>
                                    <th>Contract End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($orders->start_date)->setTimezone('Asia/Yangon')->format('l, F jS, Y g:i A') }}</td>
                                    <td>
                                        @if($orders->end_date === 'sold')
                                            Ownership Transferred
                                        @else
                                            {{ \Carbon\Carbon::parse($orders->end_date)->setTimezone('Asia/Yangon')->format('l, F jS, Y g:i A') }}
                                        @endif
                                    </td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection

