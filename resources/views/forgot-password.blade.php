<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">

    <!-- font awesome css  -->
    <script src="https://kit.fontawesome.com/10de2103ef.js" crossorigin="anonymous"></script>

    <!-- css  -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
</head>
<body id="auth-bg">



    <!-- login form start  -->
    <div class="container-lg">
		<div class="login-content">
			<div class="login-form">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('reset#link') }}" method="POST">
                    @csrf
                    <a href="{{ route('login#page') }}" class="text-start mt-0 mb-3 justify-content-start">
                        <i class="fa-solid fa-arrow-left me-2 mb-0"></i>Login
                    </a>
                    <p>Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>

                    <div class="input-div mt-4">
                        <div class="input-i"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <input type="email" class="@error('email') is-invalid @enderror" name="email" placeholder="Email address" required>
                        </div>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <input type="submit" class="btn" value="Email Password Reset Link">

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
