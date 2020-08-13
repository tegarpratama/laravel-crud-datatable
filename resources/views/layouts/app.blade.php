<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Bootstrap Core --}}
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- Datatables --}}
    <link href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    {{-- Sweetaler2 --}}
    <link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    {{-- Font Awesome --}}
    <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    {{-- Custom for this template --}}
    <link href="{{ asset('assets/css/navbar-fixed-top.css') }}" rel="stylesheet">

    <title>Laravel Crud with Datatable</title>
</head>
<body>

    <nav class="navbar navbar-expand-md fixed-top navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Laravel CRUD Datatable</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('user.index') }}">User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('book.index') }}">Book</a>
                  </li>
              </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    @include('layouts._modal')

    {{-- Jquery --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    {{-- Bootstrap --}}
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- Datatables --}}
    <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    {{-- Sweetalert2 --}}
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- Custom Script --}}
    {{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}
    @stack('scripts')

</body>
</html>
