<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>HISP</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            @auth
                <a href="#" class="navbar-brand">
                    <img src="{{ asset('logo-light.svg') }}" alt="img" width="40px">
                    <span class="ms-1 d-none d-sm-inline">Welcome {{ Auth::user()->username }}</span>
                </a>
            @endauth
            @guest
                <a href="#" class="navbar-brand">
                    <img src="{{ asset('logo-light.svg') }}" alt="img" width="50px">
                    Calvo's Org
                </a>
            @endguest
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @auth
                        <li class="nav-item">
                            <a href="#" class="navbar-brand"></a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item mr-2">
                            <a class="btn btn-danger green" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item mr-2">
                            <a class="btn btn-info green" href="{{ route('login') }}">Login</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-5 text-white"
                    style="height: 94vh;">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start position-fixed"
                        id="menu">
                        <div style="height: 74vh">
                            <li class="nav-item">
                                <a class="nav-link align-middle {{ Route::currentRouteName() === 'listings' ? 'active' : '' }}"
                                    href="{{ route('listings') }}"><i class="fs-4 bi-house"></i> <span
                                        class="ms-1 d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            @auth
                                @can('view patients', 'view checkups')
                                    <li class="nav-item">
                                        <a class="nav-link align-middle {{ Route::currentRouteName() === 'patients.index' ? 'active' : '' }} {{ Route::currentRouteName() === 'checkups.index' ? 'active' : '' }}"
                                            href="#sub" data-toggle="collapse" aria-expanded="false"><i
                                                class="fs-4 bi-table"></i><span class="ms-1 d-none d-sm-inline">Patients
                                                Management</span></a>
                                        <ul class="collapse nav flex-column ms-1" id="sub" data-bs-parent="#menu">
                                            @can('view patients')
                                                <li class="w-100">
                                                    <a href="{{ route('patients.index') }}" class="nav-link ">- <span
                                                            class="d-none d-sm-inline {{ Route::currentRouteName() === 'patients.index' ? 'text-decoration-underline' : '' }}">Patients</span></a>
                                                </li>
                                            @endcan
                                            @can('view checkups')
                                                <li>
                                                    <a href="{{ route('checkups.index') }}" class="nav-link">-
                                                        <span
                                                            class="d-none d-sm-inline {{ Route::currentRouteName() === 'checkups.index' ? 'text-decoration-underline' : '' }}">
                                                            Checkups</span></a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a class="nav-link align-middle {{ Route::currentRouteName() === 'appointment.index' ? 'active' : '' }}"
                                        href="{{ route('appointment.index') }}"><i class="fs-4 bi-file-medical"></i><span
                                            class="ms-1 d-none d-sm-inline">Appointments</span></a>
                                </li>
                                @can('view services', 'view medicine')
                                    <li class="nav-item">
                                        <a class="nav-link align-middle {{ Route::currentRouteName() === 'services.index' ? 'active' : '' }} {{ Route::currentRouteName() === 'medicine.index' ? 'active' : '' }}"
                                            href="#sub2" data-toggle="collapse" aria-expanded="false"><i
                                                class="fs-4 bi-gear"></i><span class="ms-1 d-none d-sm-inline">Service
                                                Management</span></a>
                                        <ul class="collapse nav flex-column ms-1" id="sub2" data-bs-parent="#menu">
                                            @can('view services')
                                                <li class="w-100">
                                                    <a href="{{ route('services.index') }}" class="nav-link ">- <span
                                                            class="d-none d-sm-inline {{ Route::currentRouteName() === 'services.index' ? 'text-decoration-underline' : '' }}">Services</span></a>
                                                </li>
                                            @endcan
                                            @can('view medicine')
                                                <li>
                                                    <a href="{{ route('medicine.index') }}" class="nav-link">-
                                                        <span
                                                            class="d-none d-sm-inline {{ Route::currentRouteName() === 'medicine.index' ? 'text-decoration-underline' : '' }}">
                                                            Pharmacy</span></a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a class="nav-link align-middle {{ Route::currentRouteName() === 'billings.index' ? 'active' : '' }}"
                                        href="{{ route('billings.index') }}"><i class="fs-4 bi-cash-coin"></i><span
                                            class="ms-1 d-none d-sm-inline">Accounts</span></a>
                                </li>
                                @can('view rooms')
                                    <li class="nav-item">
                                        <a class="nav-link align-middle {{ Route::currentRouteName() === 'rooms.index' ? 'active' : '' }}"
                                            href="{{ route('rooms.index') }}"><i class="fs-4 bi-hospital"></i><span
                                                class="ms-1 d-none d-sm-inline">Room Management</span></a>
                                    </li>
                                @endcan
                                @can('edit users')
                                    <li class="nav-item">
                                        <a class="nav-link align-middle {{ Route::currentRouteName() === 'users.index' ? 'active' : '' }}"
                                            href="{{ route('users.index') }}"><i class="fs-4 bi-people"></i><span
                                                class="ms-1 d-none d-sm-inline">User Management</span></a>
                                    </li>
                                @endcan
                                @can('view roles')
                                    <li class="nav-item">
                                        <a class="nav-link align-middle {{ Route::currentRouteName() === 'admin.showRoles' ? 'active' : '' }}"
                                            href="{{ route('admin.showRoles') }}"><i class="fs-4 bi-database-lock"></i><span
                                                class="ms-1 d-none d-sm-inline">Roles & Permissions</span></a>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a class="nav-link align-middle {{ Route::currentRouteName() === 'users.single' ? 'active' : '' }}"
                                        href="{{ route('users.single', ['id' => Auth::user()->id]) }}">
                                        <i class="fs-4 bi-person-fill"></i> <span
                                            class="ms-1 d-none d-sm-inline">Profile</span></a>
                                </li>
                            </div>
                            <hr>
                            <div class="dropdown">
                                <a href="#"
                                    class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                    id="dropdownUser1" data-toggle="dropdown">
                                    <img src="https://media.istockphoto.com/id/610003972/vector/vector-businessman-black-silhouette-isolated.jpg?s=612x612&w=0&k=20&c=Iu6j0zFZBkswfq8VLVW8XmTLLxTLM63bfvI6uXdkacM="
                                        alt="hugenerd" width="30" height="30" class="rounded-circle">
                                    <span class="d-none d-sm-inline mx-2">{{ Auth::user()->username }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('users.single', ['id' => Auth::user()->id]) }}">Profile</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#"><a class="dropdown-item"
                                                href="{{ route('logout') }}">Logout</a></a></li>
                                </ul>
                            </div>
                        @endauth
                        @guest
                            <div class="dropdown mt-4">
                                <a href="#"
                                    class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                    id="dropdownUser1" data-toggle="dropdown">
                                    <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30"
                                        class="rounded-circle">
                                    <span class="d-none d-sm-inline mx-2">Guest</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#"><a class="dropdown-item"
                                                href="{{ route('login') }}">Login</a></a></li>
                                </ul>
                            </div>
                        @endguest
                    </ul>
                </div>
            </div>
            <div class="col py-3">
                <div class="ml-25">
                    <div class="content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
