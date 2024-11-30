@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Orders')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
<main class="content px-3 py-4">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
           <div class="d-flex align-items-center">
                <div class="bg-white text-dark px-3 border rounded pt-2 h-100 text-center">
                    <h5>Total - {{ $orders->count() }}</h5>
                </div>
                <a href="{{ route('order#list') }}" class="ms-2">
                    <button class="" id="reload"><i class="fa-solid fa-rotate me-2"></i>Reload</button>
                </a>
           </div>

           <form action="{{ route('order#list') }}" id="search-form" method="GET">
                <div class="search-client">
                    <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                        <g>
                            <path
                                d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                            </path>
                        </g>
                    </svg>
                    <input placeholder="name, order code" type="search" name="key" value="{{ request('key') }}" class="input">
                </div>
            </form>
            <form action="{{ route('order#list') }}" id="search-form" method="GET">
                <div class="d-flex">
                    <select name="status" class="form-select me-2">
                        <option value="">All Status</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Accept</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Reject</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Expired</option>
                    </select>
                    <button type="submit" class="btn" id="reload">Filter</button>
                </div>
            </form>
        </div>

        <form action="" id="search-form-small" class="mt-3 mb-3">
            <div class="search-client">
                <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                    <g>
                        <path
                            d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                        </path>
                    </g>
                </svg>
                <input placeholder="Search" type="search" name="key" value="{{ request('key') }}" class="input">
            </div>
        </form>
        <form action="{{ route('order#list') }}" id="search-form-small" method="GET">
            <div class="d-flex">
                <select name="status" class="form-select me-2">
                    <option value="">All Status</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Accept</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Reject</option>
                    <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Expired</option>
                </select>
                <button type="submit" class="btn" id="reload">Filter</button>
            </div>
        </form>

        <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1050;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        @if(session('deleteSuccess'))
            <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('deleteSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @php
            $counter = 1;
        @endphp

        <div id="table-bg">
            <div class="my-3">
                <div class="table-responsive">
                    @if (count($orders) != 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Order Code</th>
                                    <th>Plan</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $o)
                                <tr>
                                    <input type="hidden" value="{{ $o->id }}" id="orderId">
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $o->user_name }}</td>
                                    <td>
                                        <a href="{{ route('order#view',$o->order_code) }}">{{ $o->order_code }}</a>
                                    </td>
                                    <td>{{ $o->qty }}</td>
                                    <td class="text-end">{{ number_format($o->total_price) }}</td>
                                    <td>
                                        <select class="form-control statusChange" name="status" id="status-select">
                                            <option value="0" @if( $o->status == 0 ) selected @endif>Pending</option>
                                            <option value="1" @if( $o->status == 1 ) selected @endif>Accept</option>
                                            <option value="2" @if( $o->status == 2 ) selected @endif>Reject</option>
                                            <option value="3" @if( $o->status == 3 ) selected @endif>Expired</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="table-data-feature">
                                            <a href="{{ route('order#delete',$o->order_code) }}" class="text-decoration-none" id="delete">
                                                <button class="item btn bg-danger text-white" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{$orders->links()}}
                        </div>
                    @else
                        <div class="text-center mx-auto text-secondary">
                            <h6>There is no order yet!</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


@section('scriptSource')
    <script>
        $(document).ready(function() {
            updateSelectColor();

            $('.statusChange').change(function() {
                updateSelectColor();

                const $currentStatus = $(this).val();
                const $parentNode = $(this).parents('tr');
                const $orderId = $parentNode.find('#orderId').val();
                const $previousStatus = $(this).data('previous-status');

                if ($currentStatus != $previousStatus) {
                    $('#loading-overlay').show();

                    $.ajax({
                        type: 'get',
                        url: '/orders/status',
                        data: { status: $currentStatus, orderId: $orderId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert(response.success);
                                location.reload();
                            }
                        },
                        complete: function() {
                            $('#loading-overlay').hide();
                        }
                    });

                    $(this).data('previous-status', $currentStatus);
                }
            });

            function updateSelectColor() {
                $('.statusChange').each(function() {
                    const selectedValue = $(this).val();
                    const colors = {
                        0: '#FF7900', // Pending
                        1: '#00b32c', // Accept
                        2: '#dc3545', // Reject
                        3: '#6c757d'  // Expired
                    };

                    $(this).css('color', colors[selectedValue] || '');
                });
            }

            // Store initial previous status
            $('.statusChange').each(function() {
                $(this).data('previous-status', $(this).val());
            });
        });


    </script>
@endsection
