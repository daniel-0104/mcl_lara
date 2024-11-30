<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">

    <!-- font awesome css  -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/all.min.css') }}">

    <!-- css  -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    @yield('styleSource')

</head>

<body>
    <section class="wrapper">
        <div id="sidebar" class="js-sidebar">
            <div class="h-100">
                <a href="#" class="sidebar-logo">
                    <h5 class="fw-bold">mcl Dashboard</h5>
                </a>
                <span class="menu">Menu</span>
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="{{ route('team#list') }}" class="sidebar-link-name">
                            <i class="fa-solid fa-users pe-2"></i> Teams
                        </a>
                    </li>
                    <hr>
                    <li class="sidebar-item">
                        <a href="{{ route('order#list') }}" class="sidebar-link-name">
                            <i class="fa-solid fa-cash-register pe-2"></i> Orders
                        </a>
                    </li>
                    <hr>
                    <li class="sidebar-item">
                        <a href="{{ route('admin#message') }}" class="sidebar-link-name">
                            <i class="fa-regular fa-message pe-2"></i> Message
                        </a>
                    </li>
                    <hr>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link-name collapsed" data-bs-target="#category-dropdown" data-bs-toggle="collapse" aria-expanded="false">
                            <i class="fa-solid fa-list pe-2"></i> Category
                        </a>
                        <ul id="category-dropdown" class="px-3 sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li>
                                <a href="{{ route('category#list') }}" class="sidebar-link">Plan</a>
                            </li>
                            <li>
                                <a href="{{ route('per#list') }}" class="sidebar-link">Project Permission</a>
                            </li>
                        </ul>
                    </li>
                    <hr>
                    <li class="sidebar-item">
                        <a href="{{ route('project#list') }}" class="sidebar-link-name">
                            <i class="fa-solid fa-list-check pe-2"></i> Client Projects
                        </a>
                    </li>
                    <hr>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link-name collapsed" data-bs-target="#clients-dropdown" data-bs-toggle="collapse" aria-expanded="false">
                            <i class="fa-solid fa-person-military-pointing pe-2"></i> Clients
                        </a>
                        <ul id="clients-dropdown" class="px-3 sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li>
                                <a href="{{ route('logo#list') }}" class="sidebar-link">Website Logo</a>
                            </li>
                            <li>
                                <a href="{{ route('review#list') }}" class="sidebar-link">Testimonials</a>
                            </li>
                            <li>
                                <a href="{{ route('account#list') }}" class="sidebar-link">Accounts</a>
                            </li>
                        </ul>
                    </li>
                    <hr>
                    <li class="sidebar-item">
                        <a href="{{ route('plan#list') }}" class="sidebar-link-name">
                            <i class="fa-solid fa-hand-holding-dollar pe-2"></i> Price & Plan
                        </a>
                    </li>
                    <hr>
                    <li class="sidebar-item">
                        <a href="{{ route('start#planList') }}" class="sidebar-link-name">
                            <i class="fa-solid fa-flag-checkered pe-2"></i> Starter Plan
                        </a>
                    </li>
                    <hr>
                    <li class="sidebar-item">
                        <a href="{{ route('info#list') }}" class="sidebar-link-name">
                            <i class="fa-solid fa-circle-info pe-2"></i> Website Information
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main">
            <nav class="navbar navbar-expand px-3 shadow-sm border-bottom sticky-top">
                <button class="btn mb-1" id="sidebar-toggle" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="ms-3 text-dark">
                    <h4>@yield('label')</h4>
                </div>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item me-5">
                            <a href="{{ route('order#list') }}">
                                <button type="button" class="btn position-relative border-0">
                                    <i class="fa-regular fa-bell fs-4 text-dark"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                        @yield('noti')
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-3 text-dark fs-4">
                                <i class="fa-regular fa-user"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('profile#view') }}" class="dropdown-item">Profile</a>
                                <form action="{{ route('user#homePage') }}" method="GET" class="dropdown-item customer-page-form">
                                    @csrf
                                    <button class="btn  text-white w-100" type="submit">
                                        Customer Page
                                    </button>
                                </form>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                    @csrf
                                    <button class="btn bg-danger text-white w-100" type="submit">
                                        <i class="fa-solid fa-right-from-bracket"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('content')
        </div>
    </section>


</body>

    <!-- bootstrap js  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jquery  -->
    <script src="{{ asset('admin/js/jquery-3.7.1.js') }}"></script>

    <!-- js  -->
    <script src="{{ asset('admin/js/script.js') }}"></script>

@yield('scriptSource')

</html>
