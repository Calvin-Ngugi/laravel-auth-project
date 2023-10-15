<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/layout.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <title>Laragigs</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            @auth
                <a href="#" class="navbar-brand">
                    Welcome {{ Auth::user()->username }}
                </a>
            @endauth
            @guest
                <a href="#" class="navbar-brand">
                    Calvo's Org
                </a>
            @endguest
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
    <div class="nav flex-column nav-pills bg-dark navbar-dark pr-3 pl-3 pb-5 position-fixed pt-5 h-100" id="v-pills-tab"
        role="tablist" aria-orientation="vertical">
        <a class="nav-link {{ Route::currentRouteName() === 'listings' ? 'active' : '' }}"
            href="{{ route('listings') }}">Home</a>
        @auth
            <a class="nav-link {{ Route::currentRouteName() === 'users.index' ? 'active' : '' }}"
                href="{{ route('users.index') }}">User Management</a>
            @if (Auth::user()->roles == 'super-admin')
                <a class="nav-link {{ Route::currentRouteName() === 'admin.showRoles' ? 'active' : '' }}"
                    href="{{ route('admin.showRoles') }}">Roles</a>
            @endif
        @endauth
        <a class="nav-link" href="#v-pills-settings">Settings</a>
    </div>
    </div>

    <div class="content container">
        @yield('content')
    </div>

</body>

</html>
