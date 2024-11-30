<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!-- css bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- font-awesome  -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/all.min.css') }}">

    <!-- animate  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- swiper css  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
</head>

    @yield('styleSource')
<body>
    <!-- nav bar start-->
    <nav class="navbar navbar-expand-md sticky-top shadow-sm" id="nav">
        <div class="container-fluid">
            <a href="{{ route('user#homePage') }}" class="d-flex align-items-center text-decoration-none">
                @if ($infos && $infos->logo_image)
                    <img src="{{ asset('storage/website/'.$infos->logo_image) }}" alt="" id="logo-img">
                @endif
            </a>
            <div class="offcanvas offcanvas-start navbarNav" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasLabel">
                        @if ($infos && $infos->logo_image)
                            <img src="{{ asset('storage/website/'.$infos->logo_image) }}" alt="" id="logo-img">
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <ul class="navbar-nav" id="nav-order">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user#caseList') }}">Cases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user#service') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user#about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user#contact') }}">Contact Us</a>
                    </li>
                    <li class="nav-item" id="noti-btn-mb">
                        <a href="{{ route('cart#list') }}" class="nav-link">
                            <button type="button" class="btn position-relative me-3 noti-btn">
                                <i class="fa-solid fa-cart-shopping"></i>
                                @if($carts && count($carts) != 0)
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 border border-light rounded-circle noti-bg">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                @endif
                            </button>
                        </a>
                    </li>
                </ul>
            </div>
            @if (Auth::check())
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'developer')
                    <div class="nav-item d-flex ms-3" id="nav-icon">
                        <form action="{{ route('dashboard') }}" method="GET" class="d-inline">
                            @csrf
                            <button class="btn text-white" type="submit" id="dashboard">
                                Dashboard
                            </button>
                        </form>
                    </div>
                @elseif(Auth::user()->role === 'user')
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="nav-item" id="noti-btn-lp">
                            <a href="{{ route('cart#list') }}" class="nav-link">
                                <button type="button" class="btn position-relative me-3 noti-btn">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    @if($carts && count($carts) != 0)
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 border border-light rounded-circle noti-bg">
                                            <span class="visually-hidden">New alerts</span>
                                        </span>
                                    @endif
                                </button>
                            </a>
                        </div>
                        <div class="nav-item dropdown" id="nav-icon">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon text-decoration-none text-dark dropdown-toggle" id="login-btn">
                                <i class="fa-regular fa-user me-1"></i> <label for="" id="user-name">{{ Auth::user()->name }}</label>
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end pb-0">
                                <a href="{{ route('user#profile') }}" class="dropdown-item nav-link mb-3">Profile</a>
                                <a href="{{ route('user#changePass') }}" class="dropdown-item nav-link">Change Password</a>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item ms-0 ps-0 border-top mt-3">
                                    @csrf
                                    <button class="btn w-100 fs-6 mb-0" type="submit">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="nav-item d-flex ms-3" id="nav-icon">
                    <div class="d-inline me-2">
                        <a href="{{ route('login#page') }}" class="btn text-white" role="button" id="login-btn">
                            LOGIN
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </nav>
    <!-- nav bar end  -->

    @yield('content')

    <!-- footer start  -->
    <section id="footer">
        <div class="d-flex align-items-center justify-content-between">
            <p>© 2024 MCL Team. All rights reserved.</p>
        </div>
    </section>
    <!-- footer end  -->

    {{-- @yield('scriptSource') --}}

</body>

    <!-- js bootstrap  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- jquery  -->
    <script src="{{ asset('user/js/jquery-3.7.1.js') }}"></script>

    <!-- swiper js  -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- js  -->
    <script src="{{ asset('user/js/script.js') }}"></script>

    @yield('scriptSource')

</html>
