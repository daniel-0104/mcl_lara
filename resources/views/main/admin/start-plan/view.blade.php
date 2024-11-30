@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Starter Plan')


@section('noti')
    {{ $orderCounts->count() }}
@endsection



@section('content')
    <!-- add account start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route('start#planList') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
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
                <div id="starter-plan" class="row mt-4" style="margin-bottom: 70px;">
                    @foreach ($plans as $p)
                     <div class="col-lg-6 mb-5">
                        <div class="plan-content" style="padding-bottom: 40px;">
                            <div class="mb-4 text-center">
                                <span class="fs-4">{{ $p->title }} / </span>
                                <span>{{ $p->time }}</span>
                            </div>
                            <ul class="ps-3">
                                @foreach (explode("\n", $p->starter_plan) as $detail)
                                    @php
                                        $parts = explode('=>', $detail);
                                    @endphp
                                    @if(count($parts) == 2)
                                        <li class="mb-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <i class="fa-solid fa-circle-check me-1"></i>
                                                    {{ trim($parts[0]) }}
                                                </div>
                                                <div class="pe-5">
                                                    <i class="fa-solid fa-caret-right me-3"></i>                                    {{ number_format(trim($parts[1])) }} Ks
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="d-flex mt-1">
                            <a href="{{ route('start#planEdit',$p->id) }}" class="me-2">
                                <button class="btn btn-primary">Edit</button>
                            </a>
                            <a href="{{ route('start#planDelete',$p->id) }}">
                                <button class="btn btn-danger">Delete</button>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center mt-5 mx-auto text-secondary">
                    <h6>There is no starter plan yet!</h6>
                </div>
            @endif

            <!-- price plan end  -->
        </div>
    </main>
    <!-- add account end -->
@endsection
