@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Projects List')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="bg-white text-dark px-3 border rounded pt-2 h-100 text-center">
                    <h5>Total - {{ count($projects) }}</h5>
                </div>
                <a href="{{ route('project#add') }}">
                    <button type="button" class="btn btn-primary mt-2 me-3">Add Project</button>
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
                    <div class="table-responsive">
                        @if (count($projects) != 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $p)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->type }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('project#edit',$p->id) }}" class="text-decoration-none" id="edit">
                                                    <button class="item btn bg-warning text-dark" data-toggle="tooltip"
                                                        data-placement="top" title="View">
                                                        View More
                                                    </button>
                                                </a>
                                                <a href="{{ route('project#delete',$p->id) }}" class="text-decoration-none ms-2" id="delete">
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
                                {{$projects->links()}}
                            </div>
                        @else
                            <div class="text-center mx-auto text-secondary">
                                <h6>There is no project yet!</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
