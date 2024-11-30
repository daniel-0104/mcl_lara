<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">

    <!-- font awesome css  -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/all.min.css') }}">

    <!-- css  -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
</head>
<body id="auth-bg">

    <!-- login form start  -->
    <div class="container-lg">
        <div class="login-content text-center">
            <div class="login-form">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('fail'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('fail') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="d-flex align-items-center justify-content-center">
                    <img src="{{ asset('user/image/logo.png') }}" alt="Logo" class="img-fluid">
                </div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-div mt-4">
                        <div class="input-i"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <input type="email" class="@error('email') is-invalid @enderror" name="email" placeholder="Email address">
                        </div>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <div class="input-div">
                        <div class="input-i"><i class="fas fa-lock"></i></div>
                        <div>
                            <input type="password" class="@error('password') is-invalid @enderror" name="password" placeholder="Password">
                        </div>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <input type="submit" class="btn" value="Login">

                    <a href="{{ route('forgot#page') }}">Forgot Password?</a>
                </form>
            </div>
        </div>
    </div>
    <!-- login form end  -->

</body>
    <!-- bootstrap js  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- js  -->
    <script src="{{ asset('admin/js/script.js') }}"></script>
</html>
