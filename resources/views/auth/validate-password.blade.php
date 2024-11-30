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
                <form action="{{ route('validate#tokenUpdate') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <h5>Enter New Password</h5>

                    <div class="input-div">
                        <div class="input-i"><i class="fas fa-lock"></i></div>
                        <div>
                            <input type="password" class="@error('password') is-invalid @enderror" name="password" placeholder="New Password">
                        </div>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <input type="submit" class="btn" value="Create">

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
