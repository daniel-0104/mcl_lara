@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Price & Plan')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!-- add account start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route('plan#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
            </div>

            <div class="d-block text-center">
                <h4>Plans for Permission: {{ $permission }}</h4>
            </div>
            <hr>

            @if(session('updateSuccess'))
                <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('deleteSuccess'))
                <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- price plan start  -->
            @if (count($plans) != 0)
                <div class="row mt-4 mx-auto" id="price-plan" style="margin-bottom: 50px;">
                    @foreach ($plans as $p)
                        <div class="col-lg-4 col-md-6 mx-auto package-plan" style="margin-bottom: 100px;">
                            <div class="plan-content d-flex flex-column h-100">
                                <div class="mb-4">
                                    <span>{{ $p->title }}</span>
                                    <h3>{{ number_format($p->price) }} Ks</h3>
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
                            </div>
                            <div class="d-flex justify-content-end mt-1">
                                <a href="{{ route('plan#edit',$p->id) }}" class="me-2">
                                    <button class="btn btn-primary">Edit</button>
                                </a>
                                <a href="{{ route('plan#delete',$p->id) }}">
                                    <button class="btn btn-danger">Delete</button>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center mt-5 mx-auto text-secondary">
                    <h6>There is no package plan yet!</h6>
                </div>
            @endif
            <!-- price plan end  -->
        </div>
    </main>
    <!-- add account end -->
@endsection
