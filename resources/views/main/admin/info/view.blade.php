@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Website Information')


@section('noti')
    {{ $orderCounts->count() }}
@endsection



@section('content')
    <!-- add account start  -->
    <main class="content py-4">
        <div class="container-fluid">
            @if(session('updateSuccess'))
                <div class="row me-5 mt-3 mb-0 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div id="table-web">
                <form action="{{ route('info#update',$infos->id) }}" method="POST" enctype="multipart/form-data" class="update-btn-group">
                    @csrf
                    <input type="hidden" value="{{ $infos->id }}" name="infoId">
                    <div class="form-group mb-4">
                        <label for="">Home Letter</label>
                        <textarea name="homeLetter" class="form-control mt-2 @error('homeLetter') is-invalid @enderror" cols="30" rows="5">{{ old('homeLetter',$infos->home_letter) }}</textarea>
                        @error('homeLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Services Letter</label>
                        <textarea name="serviceLetter" class="form-control mt-2 @error('serviceLetter') is-invalid @enderror" cols="30" rows="5">{{ old('serviceLetter',$infos->service_letter) }}</textarea>
                        @error('serviceLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">About Us Letter</label>
                        <textarea name="aboutLetter" class="form-control mt-2 @error('aboutLetter') is-invalid @enderror" cols="30" rows="5">{{ old('aboutLetter',$infos->about_letter) }}</textarea>
                        @error('aboutLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Contact Us Letter</label>
                        <textarea name="contactLetter" class="form-control mt-2 @error('contactLetter') is-invalid @enderror" cols="30" rows="5">{{ old('contactLetter',$infos->contact_letter) }}</textarea>
                        @error('contactLetter')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Website Logo</label>
                        <input type="file" id="file" name="logoImage" class="form-control mt-2 @error('logoImage') is-invalid @enderror" accept="image/*" onchange="loadFile(event);">
                        <img src="{{ asset('storage/website/'.$infos->logo_image) }}" id="output" class="mt-3 mx-auto d-block img-thumbnail" alt="">
                        @error('logoImage')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Service Price</label>
                        <input type="number" name="servicePrice" value="{{ old('servicePrice',$infos->service_price) }}" class="form-control mt-2 @error('servicePrice') is-invalid @enderror">
                        @error('servicePrice')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group row mt-5">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Contact Phone Number</label>
                            <input type="number" name="contactNumber" value="{{ old('contactNumber',$infos->contact_phone) }}" class="form-control mt-2 @error('contactNumber') is-invalid @enderror">
                            @error('contactNumber')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Contact Email</label>
                            <input type="email" name="contactEmail" value="{{ old('contactEmail',$infos->contact_email) }}" class="form-control mt-2 @error('contactEmail') is-invalid @enderror">
                            @error('contactEmail')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mt-4 w-100" id="update-btn" disabled>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- add account end -->
@endsection


@section('scriptSource')
    <script>
        const updateBtnFormElements = document.querySelectorAll('input,textarea');
        const updateBtn = document.getElementById('update-btn');

        const initialValues = {};

        updateBtnFormElements.forEach(element => {
            initialValues[element.name] = element.value;
        });

        function checkUpdateValueForBtn() {
            let hasChanged = false;
            updateBtnFormElements.forEach(element => {
                if (element.value != initialValues[element.name]) {
                    hasChanged = true;
                }
            });
            updateBtn.disabled = !hasChanged;
        }

        updateBtnFormElements.forEach(element => {
            element.addEventListener('input', checkUpdateValueForBtn);
            element.addEventListener('change', checkUpdateValueForBtn);
        });

        checkUpdateValueForBtn();
    </script>

@endsection



