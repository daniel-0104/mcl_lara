@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Edit Client Logo')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!--edit category start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <a href="{{ route('logo#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>

            <div id="add-table">
                <h3 class="text-center">Edit Client Logo</h3>
                <hr>
                <form action="{{ route('logo#update') }}" method="post" class="mt-1" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="hidden" name="clientLogoId" id="" value="{{ $clientLogos->id }}">
                        <label class="mb-1">Website Logo</label>
                        <input type="file" id="file" name="clientLogo" class="form-control mt-1 @error('clientLogo') is-invalid @enderror" accept="image/*" onchange="loadFile(event);">
                        <img src="{{ asset('storage/client-logo/'.$clientLogos->image) }}" id="output" class="mt-3 mx-auto d-block img-thumbnail" alt="">
                        @error('clientLogo')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-primary w-100 my-2" id="update-btn" disabled>Update</button>
                </form>
            </div>
        </div>
    </main>
    <!--  end -->
@endsection


@section('scriptSource')
    <script>
       const fileInput = document.getElementById('file');
        const updateBtn = document.getElementById('update-btn');

        updateBtn.disabled = true;

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                updateBtn.disabled = false;
            } else {
                updateBtn.disabled = true;
            }
        });

    </script>
@endsection
