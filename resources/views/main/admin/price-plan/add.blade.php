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
            <div class="d-flex align-items-center">
                <a href="{{ route('plan#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
            </div>
            <div id="table-web">
                <h3 class="text-center">Add Price & Plan</h3>
                <hr>
                <form action="{{ route('plan#create') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Package Title*</label>
                            <input type="text" name="planTitle" value="{{ old('planTitle') }}" class="form-control mt-1 @error('planTitle') is-invalid @enderror" placeholder="Enter title">
                            @error('planTitle')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Package Price*</label>
                            <input type="number" name="planPrice" value="{{ old('planPrice') }}" class="form-control mt-1 @error('planPrice') is-invalid @enderror" placeholder="Enter price">
                            @error('planPrice')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Package Expire*</label>
                            <select name="planExpire" id="" class="form-control mt-1 @error('planExpire') is-invalid @enderror">
                                <option value="" disabled selected>Choose plan...</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->name }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('planExpire')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Project Permission*</label>
                            <select name="planPermission" id="" class="form-control mt-1 @error('planPermission') is-invalid @enderror">
                                <option value="" disabled selected>Choose permission ...</option>
                                @foreach ($permissions as $p)
                                    <option value="{{ $p->name }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('planPermission')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Cash Back Price</label>
                        <input type="number" name="cashBackPrice" value="{{ old('cashBackPrice',0) }}" class="form-control mt-1 @error('cashBackPrice') is-invalid @enderror" placeholder="Enter cash back price">
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Package Description*</label>
                        <textarea name="planDescription" class="form-control mt-1 @error('planDescription') is-invalid @enderror" cols="30" rows="15" placeholder="Enter package explanation">{{ old('planDescription') }}</textarea>
                        @error('planDescription')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3 mx-auto">Create</button>
                </form>
            </div>
        </div>
    </main>
    <!-- add account end -->
@endsection
