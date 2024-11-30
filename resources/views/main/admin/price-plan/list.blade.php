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
                <div class="bg-white text-dark px-3 border rounded pt-2 h-100 text-center">
                    <h5>Total - {{ count($projectPlans) }}</h5>
                </div>
                <a href="{{ route('plan#add') }}">
                    <button type="button" class="btn btn-primary mt-2 me-3">Add Price Plan</button>
                </a>
            </div>

            @if(session('success'))
                <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('perDeleteSuccess'))
                <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('perDeleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                        <div class="col-lg-6 w-auto alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endforeach
            @endif

            @php
                $counter = 1;
            @endphp

            <div id="table-bg">
                <div class="my-3">
                    @if(count($projectPlans) != 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Project</th>
                                        <th>Plans</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projectPlans as $p)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $p->project_permission }}</td>
                                        <td>{{ $permissionCounts[$p->project_permission]->count ?? 0 }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('plan#view',$p->project_permission) }}" class="text-decoration-none me-2" id="edit">
                                                    <button class="item btn bg-warning text-dark" data-toggle="tooltip"
                                                        data-placement="top" title="View">
                                                        View More
                                                    </button>
                                                </a>
                                                <a href="{{ route('plan#permissionDelete',$p->project_permission) }}" class="text-decoration-none" id="delete"
                                                    onclick="return confirm('Are you sure you want to delete all plans with permission {{ $p->project_permission }}?')">
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
                        </div>
                    @else
                        <h6 class=" text-center text-secondary mt-4">There is no price plans here yet!</h6>
                    @endif
                    <div>
                        {{ $projectPlans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- add account end -->
@endsection
