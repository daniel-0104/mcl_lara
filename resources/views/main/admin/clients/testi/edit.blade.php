@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Edit Client Review')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!--edit category start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <a href="{{ route('review#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>

            <div id="table-web">
                <h3 class="text-center">Edit Client Review</h3>
                <hr>
                <form action="{{ route('review#update') }}" method="post" class="mt-1" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="clientReviewId" value="{{ $clientTestis->id }}" id="">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Client Name</label>
                            <input type="text" name="clientName" value="{{ old('clientName',$clientTestis->name) }}" class="form-control mt-1 @error('clientName') is-invalid @enderror" placeholder="Enter client name">
                            @error('clientName')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Client Position</label>
                            <input type="text" name="clientPosition" value="{{ old('clientPosition',$clientTestis->position) }}" class="form-control mt-1 @error('clientPosition') is-invalid @enderror" placeholder="Enter client position">
                            @error('clientPosition')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Description</label>
                        <textarea  class="form-control mt-1 @error('clientDescription') is-invalid @enderror" name="clientDescription" id="" cols="30" rows="7">{{ old('clientDescription',$clientTestis->description) }}</textarea>
                        @error('clientDescription')
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
