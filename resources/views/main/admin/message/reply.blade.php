@extends('main.admin.layouts.master')

@section('title','Reply Message')
@section('label','Reply Message')

@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')

    <!-- contact message start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center ms-1">
                <a href="{{ route('admin#message') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
            </div>
            <div id="table-web">
                <form action="{{ route('admin#messageSend',$messages->id) }}" class="mt-3" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="">Email To</label>
                                <input type="email" name="email" class="form-control mt-1" value="{{ $messages->email }}" placeholder="Enter user email" disabled>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="">Website Name</label>
                                <input type="text" name="subject" class="form-control mt-1" value="{{ $messages->website_name }}" placeholder="Enter user subject" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label for="">Customer Message</label>
                        <textarea name="message" id="" rows="7" class="form-control mt-1" placeholder="Enter your message" disabled>{{ $messages->message }}</textarea>
                    </div>
                    <div class="form-group mt-4">
                        <label for="">Your Message</label>
                        <textarea name="message" id="" rows="7" class="form-control mt-1 @error('message') is-invalid @enderror" placeholder="Enter your message"></textarea>
                    </div>
                    @error('message')
                        <div id="invalid-feedback" class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    <button type="submit" class="btn btn-primary mt-4 w-100 mx-auto">Send</button>
                </form>
            </div>
        </div>
    </main>
    <!-- contact message end -->
@endsection
