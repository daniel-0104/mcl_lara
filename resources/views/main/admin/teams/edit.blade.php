@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Edit Member')


@section('noti')
    {{ $orderCounts->count() }}
@endsection



@section('content')
    <!-- edit account start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a href="{{ route('team#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
            </div>

            @if(session('updateSuccess'))
                <div class="row mt-3 mb-0 me-5 justify-content-end" id="alert-row">
                    <div class="col-lg-6 w-auto alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div id="add-table2">
                <h3 class="text-center">Edit Member</h3>
                <hr>
                <form action="{{ route('team#update') }}" method="POST" class="mt-4 update-btn-group" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="teamId" value="{{ $teams->id }}">
                    <div class="form-group mb-4">
                        <label for="">Name</label>
                        <input type="text" name="memberName" value="{{ old('memberName',$teams->name) }}" class="form-control mt-1 @error('memberName') is-invalid @enderror" placeholder="Enter name">
                        @error('memberName')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Profile Image</label>
                        <input type="file" id="file" name="memberImage" class="form-control mt-1 @error('memberImage') is-invalid @enderror" accept="image/*" onchange="loadFile(event);">
                        <img src="{{ asset('storage/members/'.$teams->image) }}" id="output" class="mt-3 mx-auto d-block img-thumbnail" alt="">
                        @error('memberImage')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Position</label>
                        <input type="text" name="memberPosition" value="{{ old('memberPosition',$teams->position) }}" class="form-control mt-1 @error('memberPosition') is-invalid @enderror" placeholder="Enter position">
                        @error('memberPosition')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mx-auto" id="update-btn" disabled>Update</button>
                </form>
            </div>
        </div>
    </main>
    <!-- edit account end -->
@endsection

@section('scriptSource')
    <script>
        const updateBtnFormElements = document.querySelectorAll('.update-btn-group input');
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
