@extends('main.user.layouts.master')

@section('title','MCL')

@section('content')
    <!-- profile start  -->
    <section class="container-lg" id="pass-page">
        @if(session('passUpdate'))
            <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                <div class="col-lg-6 offset-6 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('passUpdate') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="personal">
            <h3>Change Password</h3>
            <div class="container-lg">
                <div id="contact-content">
                    <form action="{{ route('user#passUpdate',Auth::user()->id) }}" method="POST" class="update-btn-group">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="">Current Password</label>
                            <input type="password" name="oldPassword" class="form-control mt-2 @error('oldPassword') is-invalid @enderror">
                            @error('oldPassword')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="">New Password</label>
                            <input type="password" name="newPassword" class="form-control mt-2 @error('newPassword') is-invalid @enderror">
                            @error('oldPassword')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="">Confirm New Password</label>
                            <input type="password" name="confirmPassword" class="form-control mt-2 @error('confirmPassword') is-invalid @enderror">
                            @error('confirmPassword')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <button class="btn py-1" type="submit" id="submit" disabled>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- profile end  -->
@endsection

@section('scriptSource')
    <script>
        const updateBtnFormElements = document.querySelectorAll('.update-btn-group input');
        const updateBtn = document.getElementById('submit');

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


