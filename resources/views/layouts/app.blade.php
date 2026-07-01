<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<style>
    #loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, .8);

        display: flex;
        justify-content: center;
        align-items: center;

        z-index: 99999;
    }
</style>

<body>
    <div id="loader" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand" href="/">
                Product Management System
            </a>

            <div>
                <a href="/dashboard" class="btn btn-outline-light me-2">
                    Dashboard
                </a>
                @if(!Auth::check())
                    <a href="/login" class="btn btn-outline-light me-2">
                        Login
                    </a>

                    <a href="/register" class="btn btn-danger">
                        Register
                    </a>
                @endif
                @if(Auth::check())
                    <a href="/logout" class="btn btn-outline-light me-2">
                        Logout
                    </a>
                @endif
            </div>

        </div>
    </nav>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container mt-4">

        @yield('content')

    </div>
</body>

</html>