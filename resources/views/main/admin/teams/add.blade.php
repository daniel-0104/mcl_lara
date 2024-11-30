@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Add Member')


@section('noti')
    {{ $orderCounts->count() }}
@endsection



@section('content')
    <!-- add account start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center ms-1">
                <a href="{{ route('team#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
            </div>
            <div id="add-table2">
                <h3 class="text-center">Add Member</h3>
                <hr>
                <form action="{{ route('team#create') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="">Name</label>
                        <input type="text" name="memberName" value="{{ old('memberName') }}" class="form-control mt-1 @error('memberName') is-invalid @enderror" placeholder="Enter name">
                        @error('memberName')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Profile Image</label>
                        <input type="file" id="file" name="memberImage" class="form-control mt-1 @error('memberImage') is-invalid @enderror" accept="image/*" onchange="loadFile(event);">
                        <img src="{{ asset('admin/image/default.jpg') }}" id="output" class="mt-3 mx-auto d-block img-thumbnail" alt="">
                        @error('memberImage')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Position</label>
                        <input type="text" name="memberPosition" value="{{ old('memberPosition') }}" class="form-control mt-1 @error('memberPosition') is-invalid @enderror" placeholder="Enter position">
                        @error('memberPosition')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mx-auto">Create</button>
                </form>
            </div>
        </div>
    </main>
    <!-- add account end -->
@endsection
