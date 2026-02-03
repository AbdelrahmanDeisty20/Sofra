<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sofra App</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('plugins/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition {{auth()->check() ? 'skin-blue sidebar-mini' : 'login-page'}}">

    @auth
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-mini"><b>S</b>Sofra</span>
                <span class="logo-lg"><b>Sofra</b></span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                                    <p>
                                        {{ auth()->user()->name }}
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <ul class="sidebar-menu" data-widget="tree">
                    <li><a href="{{ route('categories.index') }}"><i class="fa fa-list"></i> <span>Categories</span></a></li>
                    <li><a href="{{ route('cities.index') }}"><i class="fa fa-map-marker"></i> <span>Cities</span></a></li>
                    <li><a href="{{ route('regions.index') }}"><i class="fa fa-flag"></i> <span>Regions</span></a></li>
                    <li><a href="{{ route('restaurants.index') }}"><i class="fa fa-cutlery"></i> <span>Restaurants</span></a></li>
                    <li><a href="{{ route('products.index') }}"><i class="fa fa-lemon-o"></i> <span>Products</span></a></li>
                    <li><a href="{{ route('offers.index') }}"><i class="fa fa-calendar"></i> <span>Offers</span></a></li>
                    <li><a href="{{ route('payments.index') }}"><i class="fa fa-money"></i> <span>Payments</span></a></li>
                    <li><a href="{{ route('orders.index') }}"><i class="fa fa-cart-plus"></i> <span>Orders</span></a></li>
                    <li><a href="{{ route('clients.index') }}"><i class="fa fa-user-circle"></i> <span>Clients</span></a></li>
                    <li><a href="{{ route('comments.index') }}"><i class="fa fa-star-half-o"></i> <span>Comments & Ratings</span></a></li>
                    <li><a href="{{ route('change-password') }}"><i class="fa fa-key"></i> <span>Change Password</span></a></li>
                    <li><a href="{{route('users.index')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>
                    <li><a href="{{route('roles.index')}}"><i class="fa fa-users"></i> <span>Roles</span></a></li>
                    <li><a href="{{route('permissions.index')}}"><i class="fa fa-list"></i> <span>Permissions</span></a></li>
                    <li><a href="{{ route('settings.create') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                    <li><a href="{{ route('contacts.index') }}"><i class="fa fa-comment-o"></i> <span>Contact Us</span></a></li>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    @yield('page_title')
                    <small>@yield('small_title')</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url(route('home')) }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">@yield('page_title')</li>
                </ol>
            </section>
            @yield('content')
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights reserved.
        </footer>
    </div>
    @else
        @yield('content')
    @endauth

    <!-- jQuery 3 -->
    <script src="{{ asset('plugins/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('plugins/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.sidebar-menu').tree()
        })
    </script>
</body>

</html>
