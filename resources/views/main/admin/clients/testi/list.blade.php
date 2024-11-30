@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Clients Review')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!-- admin dashboard start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="bg-white text-dark px-3 border rounded pt-2 h-100 text-center">
                    <h5>Total - {{ count($clientTestis) }}</h5>
                </div>
                <button type="button" class="btn btn-primary mt-2 me-3" data-bs-toggle="modal" data-bs-target="#add-testi">Add Client Reviews</button>
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
                    @if(count($clientTestis) != 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Postion</th>
                                        <th class="message-column">Description</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientTestis as $c)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->position }}</td>
                                        <td class="message-column">{{ $c->description }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('review#edit',$c->id) }}" class="text-decoration-none" id="edit">
                                                    <button class="item btn bg-primary text-white" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('review#delete',$c->id) }}" class="text-decoration-none" id="delete">
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
                        <h6 class=" text-center text-secondary mt-4">There is no review here yet!</h6>
                    @endif
                    <div>
                        {{ $clientTestis->links() }}
                    </div>
                </div>

                <!--add category modal -->
                <div class="modal fade" id="add-testi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-testiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title d-block w-100 text-center" id="add-testiLabel">Add Client Reviews</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('review#create') }}" method="post" class="mt-1" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <label for="">Client Name</label>
                                            <input type="text" name="clientName" value="{{ old('clientName') }}" class="form-control mt-1 @error('clientName') is-invalid @enderror" placeholder="Enter client name">
                                            @error('clientName')
                                                <div class="text-danger invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-4">
                                            <label for="">Client Position</label>
                                            <input type="text" name="clientPosition" value="{{ old('clientPosition') }}" class="form-control mt-1 @error('clientPosition') is-invalid @enderror" placeholder="Enter client position">
                                            @error('clientPosition')
                                                <div class="text-danger invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="">Description</label>
                                        <textarea  class="form-control mt-1 @error('clientDescription') is-invalid @enderror" name="clientDescription" id="" cols="30" rows="7">{{ old('clientDescription') }}</textarea>
                                        @error('clientDescription')
                                            <div class="text-danger invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 my-2">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- admin dashboard end -->
@endsection
