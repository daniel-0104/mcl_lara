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
            <a href="{{ route('category#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>

            <div id="add-table">
                <h3 class="text-center">Edit Category</h3>
                <hr>
                <form action="{{ route('category#update') }}" method="post" class="mt-1">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="hidden" name="categoryId" id="" value="{{ $categories->id }}">
                        <label class="mb-1">Name</label>
                        <input id="category-name" type="text" value="{{ old('categoryName',$categories->name) }}" class="form-control @error('categoryName') is-invalid @enderror" name="categoryName" placeholder="Enter category name">
                        @error('categoryName')
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
        const inputField = document.getElementById('category-name');
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
