@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Category List')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!--edit category start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <a href="{{ route('per#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>

            <div id="add-table">
                <h3 class="text-center">Edit Project Permission</h3>
                <hr>
                <form action="{{ route('per#update') }}" method="post" class="mt-1">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="hidden" name="perId" id="" value="{{ $permissions->id }}">
                        <label class="mb-1">Name</label>
                        <input type="text" id="permission-name" value="{{ old('permissionName',$permissions->name) }}" class="form-control @error('permissionName') is-invalid @enderror" name="permissionName" placeholder="Enter category name">
                        @error('permissionName')
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
        const inputField = document.getElementById('permission-name');
        const updateBtn = document.getElementById('update-btn');

        const initialVal = inputField.value;

        inputField.addEventListener('input', function() {
            const currentVal = inputField.value;
            if (initialVal !== currentVal) {
                updateBtn.disabled = false;
            } else {
                updateBtn.disabled = true;
            }
        });
    </script>
@endsection
