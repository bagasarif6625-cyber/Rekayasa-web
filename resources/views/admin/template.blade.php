<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Web Profile')</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar {
            position: fixed;
            top: 56px;
            width: 200px;
            min-height: 100vh;
            background-color: #343a40;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            flex: 1 0 auto;
            margin-top: 70px;
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            border-radius: 10px;
            border: 0;
        }

        footer {
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning fixed-top shadow-sm px-3">
        <!-- <div class="container"> -->
        <a class="navbar-brand text-dark fw-bold" href="{{ route('admin.home') }}">Admin Web Profile</a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Lihat Website</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="nav-link border-0 bg-transparent" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
        <!-- </div> -->
    </nav>
    <div class="sidebar shadow-sm">
        <h5 class="text-center text-white py-3">Admin Menu</h5>
        <a href="{{ route('admin.home') }}">Dashboard</a>
        <a href="{{ route('admin.projects.index') }}">Data Project</a>
    </div>

    <div class="content p-3 d-flex flex-column">
        <div class="flex-grow">
            @yield('content')
        </div>
    </div>

    <footer class="bg-white text-dark text-center py-3 border-top">
        <!-- <div class="container"> -->
        <p class="mb-0">&copy; {{ date('Y') }}  Bagas Muhammad Arif -251011701159</p>
        <!-- </div> -->
    </footer>
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
    @yield('scripts')
</body>

</html>
