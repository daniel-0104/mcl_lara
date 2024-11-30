@extends('main.admin.layouts.master')

@section('title','Admin Dashboard')
@section('label','Clients Account')


@section('noti')
    {{ $orderCounts->count() }}
@endsection



@section('content')
    <!-- add account start  -->
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center ms-1">
                <a href="{{ route('account#list') }}"><i class="fa-solid fa-arrow-left-long" id="arrow-back"></i></a>
            </div>
            <div id="add-table2">
                <h3 class="text-center">Add Client Account</h3>
                <hr>
                <form action="{{ route('account#create') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" value="admin" name="role">
                    <div class="form-group mb-4">
                        <label for="">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control mt-1 @error('name') is-invalid @enderror" placeholder="Enter name">
                        @error('name')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control mt-1 @error('email') is-invalid @enderror" placeholder="Enter email">
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
                                <option value="{{ $p->name }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('permission')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control mt-1 @error('password') is-invalid @enderror" placeholder="Enter password">
                        @error('password')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Password Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control mt-1 @error('password_confirmation') is-invalid @enderror" placeholder="Enter password confirmation">
                        @error('password_confirmation')
                            <div class="text-danger invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 mb-1 mx-auto">Create</button>
                </form>
            </div>
        </div>
    </main>
    <!-- add account end -->
@endsection
