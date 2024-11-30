@extends('main.admin.layouts.master')

@section('title','Profile')
@section('label','Profile')

@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!-- profile page start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">

            @if(session('updateSuccess'))
                <div class="row me-5 mt-3 mb-0 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('passUpdate'))
                <div class="row me-5 mt-3 mb-0 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('passUpdate') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('passFail'))
                <div class="row me-5 mt-3 mb-0 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('passFail') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="row me-5 mt-3 mb-0 justify-content-end" id="alert-row">
                        <div class="col-lg-6 w-auto alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endforeach
            @endif

            <div id="add-table3">
                <div class="d-flex my-3 align-items-center" id="profile-page">
                    @if(Auth::user()->image != null)
                        <img src="{{ asset('storage/'.Auth::user()->image) }}" class="img-thumbnail"  alt="">
                    @else
                        <img src="{{ asset('admin/image/3515103.jpg') }}" class="img-thumbnail"  alt="">
                    @endif
                    <div>
                        <div class="d-flex align-items-center">
                            <label for="" class="me-2">Name :</label>
                            <h5 class="mt-1">{{ Auth::user()->name }}</h5>
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <label for="" class="me-2">Email :</label>
                            <h5 class="mt-1">{{ Auth::user()->email }}</h5>
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <label for="" class="me-2">Position :</label>
                            <h5 class="mt-1">{{ Auth::user()->role }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row" id="profile-update">
                <div class="col-lg-6 col-md-6">
                    <div id="table-bg" class="py-3">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-angles-right me-3 mb-2"></i>
                            <h5>Edit Profile</h5>
                        </div>
                        <form action="{{ route('profile#update',Auth::user()->id) }}" method="POST" class="mt-3 update-btn-group">
                            @csrf
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" value="{{ old('name',Auth::user()->name) }}" name="name" id="" class="form-control mt-1 @error('name') is-invalid @enderror" placeholder="Enter your name">
                                @error('name')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Email</label>
                                <input type="email" value="{{ old('email',Auth::user()->email) }}" name="email" id="" class="form-control mt-1 @error('email') is-invalid @enderror" placeholder="Enter your email">
                                @error('email')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary w-auto" id="update-btn" disabled>Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div id="table-bg" class="py-3">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-angles-right me-3 mb-2"></i>
                            <h5>Change Password</h5>
                        </div>
                        <form action="{{ route('pass#update',Auth::user()->id) }}" method="POST" class="mt-3 update-btn2-group">
                            @csrf
                            <div class="form-group">
                                <label for="">Old Password</label>
                                <input type="password" name="oldPassword" id="" class="form-control mt-1 @error('oldPassword') is-invalid @enderror">
                                @error('oldPassword')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="">New Passsword</label>
                                <input type="password" name="newPassword" id="" class="form-control mt-1 @error('newPassword') is-invalid @enderror">
                                @error('newPassword')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Confirm New Passsword</label>
                                <input type="password" name="confirmPassword" id="" class="form-control mt-1 @error('confirmPassword') is-invalid @enderror">
                                @error('confirmPassword')
                                    <div class="text-danger invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary w-auto" id="update-btn2" disabled>Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- profile page end -->
@endsection


@section('scriptSource')
    <script>
        const updateBtnFormElements = document.querySelectorAll('.update-btn-group input');
        const updateBtn2FormElements = document.querySelectorAll('.update-btn2-group input');

        const updateBtn = document.getElementById('update-btn');
        const updateBtn2 = document.getElementById('update-btn2');

        const initialValues = {};
        const initialValues2 = {};

        updateBtnFormElements.forEach(element => {
            initialValues[element.name] = element.value;
        });

        updateBtn2FormElements.forEach(element => {
            initialValues2[element.name] = element.value;
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

        function checkUpdateValueForBtn2() {
            let hasChanged2 = false;
            updateBtn2FormElements.forEach(element => {
                if (element.value != initialValues2[element.name]) {
                    hasChanged2 = true;
                }
            });
            updateBtn2.disabled = !hasChanged2;
        }

        updateBtnFormElements.forEach(element => {
            element.addEventListener('input', checkUpdateValueForBtn);
            element.addEventListener('change', checkUpdateValueForBtn);
        });

        updateBtn2FormElements.forEach(element => {
            element.addEventListener('input', checkUpdateValueForBtn2);
            element.addEventListener('change', checkUpdateValueForBtn2);
        });

        checkUpdateValueForBtn();
        checkUpdateValueForBtn2();
    </script>

@endsection
