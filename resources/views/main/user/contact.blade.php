@extends('main.user.layouts.master')

@section('title','Contact Us')

@section('content')
    <!-- contact us start  -->
    <section>
        @if(session('success'))
            <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                <div class="col-lg-6 offset-6 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div id="contact-us">
            <h1>Let's get in touch.</h1>
            @if ($infos && $infos->contact_letter )
                <p>{{ $infos->contact_letter }}</p>
            @endif
        </div>
        <div class="container-lg">
            <div class="row" id="contact-content">
                <div class="col-lg-3 col-md-3 ps-4 border-start border-2 order-md-1">
                    <h5>We're glad to talk</h5>
                    <div class="mt-4">
                        @if ($infos && $infos->contact_phone )
                            <i class="fa-solid fa-phone me-2"></i> {{ $infos->contact_phone }}
                        @endif
                    </div>
                    <div class="mt-3">
                        @if ($infos && $infos->contact_email )
                            <i class="fa-solid fa-envelope me-2"></i> {{ $infos->contact_email }}
                        @endif
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <h5 class="text-uppercase">Let's Discuss Your Project</h5>
                    <form action="{{ route('message#send') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-6 col-sm-6 mb-4">
                                <label for="">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror mt-2">
                                @error('name')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-4">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror mt-2">
                                @error('email')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="">Website Project Name</label>
                            <input type="text" name="websiteName" value="{{ old('websiteName') }}" class="form-control @error('websiteName') is-invalid @enderror mt-2">
                            @error('websiteName')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="">Message</label>
                            <textarea name="message" class="form-control mt-2 @error('message') is-invalid @enderror" rows="6" id="" placeholder="Tell us about your project details, and we’ll provide simple and fast.">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn" id="submit">Submit Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- contact us end  -->
@endsection

