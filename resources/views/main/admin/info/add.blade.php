@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Add Website Info')


@section('noti')
    {{ $orderCounts->count() }}
@endsection



@section('content')
    <!-- add account start  -->
    <main class="content py-4">
        <div class="container-fluid">
            <div id="table-web">
                <form action="{{ route('info#create') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="">Home Letter</label>
                        <textarea name="homeLetter" class="form-control mt-1 @error('homeLetter') is-invalid @enderror" cols="30" rows="5">{{ old('homeLetter') }}</textarea>
                        @error('homeLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Price Letter</label>
                        <textarea name="priceLetter" class="form-control mt-1 @error('priceLetter') is-invalid @enderror" cols="30" rows="5">{{ old('priceLetter') }}</textarea>
                        @error('priceLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Services Letter</label>
                        <textarea name="serviceLetter" class="form-control mt-1 @error('serviceLetter') is-invalid @enderror" cols="30" rows="5">{{ old('serviceLetter') }}</textarea>
                        @error('serviceLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">About Us Letter</label>
                        <textarea name="aboutLetter" class="form-control mt-1 @error('aboutLetter') is-invalid @enderror" cols="30" rows="5">{{ old('aboutLetter') }}</textarea>
                        @error('aboutLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Contact Us Letter</label>
                        <textarea name="contactLetter" class="form-control mt-1 @error('contactLetter') is-invalid @enderror" cols="30" rows="5">{{ old('contactLetter') }}</textarea>
                        @error('contactLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Website Logo</label>
                        <input type="file" id="file" name="logoImage" class="form-control mt-1 @error('logoImage') is-invalid @enderror" accept="image/*" onchange="loadFile(event);">
                        <img src="{{ asset('admin/image/default.jpg') }}" id="output" class="mt-3 mx-auto d-block img-thumbnail" alt="">
                        @error('logoImage')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group row mt-5">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Contact Phone Number</label>
                            <input type="text" name="contactNumber" value="{{ old('contactNumber') }}" class="form-control mt-1 @error('contactNumber') is-invalid @enderror">
                            @error('contactNumber')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Contact Email</label>
                            <input type="email" name="contactEmail" value="{{ old('contactEmail') }}" class="form-control mt-1 @error('contactEmail') is-invalid @enderror">
                            @error('contactEmail')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mx-auto">Create</button>
                </form>
            </div>
        </div>
    </main>
    <!-- add account end -->
@endsection
