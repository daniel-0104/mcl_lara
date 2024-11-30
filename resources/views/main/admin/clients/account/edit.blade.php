@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Clients Account')


@section('noti')
    {{ $orderCounts->count() }}
@endsection

@section('content')
    <!--edit category start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <a href="{{ route('account#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>

            <div id="add-table2">
                <h3 class="text-center">Edit Client Account</h3>
                <hr>
                <form action="{{ route('account#update') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="userId" value="{{ $users->id }}">
                    <div class="form-group mb-4">
                        <label for="">Name</label>
                        <input type="text" name="name" value="{{ old('name',$users->name) }}" class="form-control mt-1 @error('name') is-invalid @enderror" placeholder="Enter name">
                        @error('name')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Email</label>
                        <input type="email" name="email" value="{{ old('email',$users->email) }}" class="form-control mt-1 @error('email') is-invalid @enderror" placeholder="Enter email">
                        @error('email')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Project Permission</label>
                        <select name="permission" id="" class="form-control mt-1 @error('permission') is-invalid @enderror">
                            <option value="" disabled selected>Choose permission ...</option>
                            @foreach ($permissions as $p)
                                <option value="{{ $p->name }}" @if($users->project_permission == $p->name ) selected @endif>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('permission')
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
    <!--  end -->
@endsection


@section('scriptSource')
    <script>
        const updateBtnFormElements = document.querySelectorAll('input,select');
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
