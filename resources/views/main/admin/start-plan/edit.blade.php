@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Edit Starter Plan')


@section('noti')
    {{ $orderCounts->count() }}
@endsection



@section('content')
    <!-- add account start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
            </div>
            <div id="table-web">
                <h3 class="text-center">Edit Starter Plan</h3>
                <hr>
                <form action="{{ route('start#planUpdate') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $plans->id }}" name="startPlanId">
                    <div class="form-group mb-4">
                        <label for="">Package Title</label>
                        <input type="text" name="startPlanTitle" value="{{ old('startPlanTitle',$plans->title) }}" class="form-control mt-1 @error('startPlanTitle') is-invalid @enderror" placeholder="Enter title">
                        @error('startPlanTitle')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Package Expire</label>
                            <select name="startPlanExpire" id="" class="form-control mt-1 @error('startPlanExpire') is-invalid @enderror">
                                <option value="" disabled selected>Choose plan...</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->name }}" @if($plans->time == $c->name ) selected @endif >{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('startPanExpire')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-sm-6 mb-4">
                            <label for="">Project Permission</label>
                            <select name="projectPermission" id="" class="form-control mt-1 @error('projectPermission') is-invalid @enderror">
                                <option value="" disabled selected>Choose plan...</option>
                                @foreach ($permissions as $p)
                                    <option value="{{ $p->name }}" @if($plans->project_permission == $p->name) selected @endif>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('projectPermission')
                                <div class="text-danger invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Package Description</label>
                        <textarea name="startPlanDescription" class="form-control mt-1 @error('startPlanDescription') is-invalid @enderror" cols="30" rows="8" placeholder="Enter package explanation">{{ old('startPlanDescription',$plans->starter_plan) }}</textarea>
                        @error('startPlanDescription')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3 mx-auto" id="update-btn" disabled>Update</button>
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
