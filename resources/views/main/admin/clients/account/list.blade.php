@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Clients Account')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!-- admin dashboard start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="bg-white text-dark px-3 border rounded pt-2 h-100 text-center">
                    <h5>Total - {{ count($users) }}</h5>
                </div>
                <a href="{{ route('account#add') }}">
                    <button type="button" class="btn btn-primary mt-2 me-3">Add Account</button>
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
                    @if(count($users) != 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Project Permission</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->project_permission }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('account#edit',$u->id) }}" class="text-decoration-none" id="edit">
                                                    <button class="item btn bg-primary text-white" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('account#delete',$u->id) }}" class="text-decoration-none" id="delete">
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
                        <h6 class=" text-center text-secondary mt-4">There is no client account here yet!</h6>
                    @endif
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- admin dashboard end -->
@endsection
