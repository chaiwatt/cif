<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ระบบ HRM | Top Navigation</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}"> --}}

    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font.css?v=1.0') }}">
</head>

<body class="" style="background-color: #F2F4F7;">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white p-0 ">
            <div class="container-fluid" style="padding: 40px;">
                <img src="{{ asset('CIF_Logo.png') }}" alt="website logo">
                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav ml-auto align-items-center gap-5">
                    <li class="nav-item">
                        <a href="{{ url('/home') }}" class="nav-link">ข่าวประกาศ</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/home') }}" class="nav-link">รับสมัครงาน</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/home') }}" class="nav-link">ติดต่อเรา</a>
                    </li>
                    @if (Route::has('login'))
                    <!-- Messages Dropdown Menu -->
                    @auth

                    <li class="nav-item">
                        <a href="{{ url('/home') }}" class="nav-link">แดชบอร์ด</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="#" class="btn btn-primary btn-lg">เข้าสู่ระบบ</a>
                    </li>

                    @endauth
                    @endif

                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <div class="content-wrapper">
            {{-- <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">บริษัท ฉวีวรรณอินเตอร์เนชั่นแนลฟู๊ดส์ จำกัด</h1>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>

        <!-- Main Footer -->
        <footer class="main-footer bg-primary py-2 px-3 text-white d-flex justify-content-between">
            @php
            $currentYear = date('Y');
            @endphp
            <div>
                Copyright &copy; {{ $currentYear }}-{{ $currentYear + 1 }} CIF
                    HRM. All rights reserved.
            </div>
            <div class="float-right d-none d-sm-inline">
                ระบบ HRM บริษัท ฉวีวรรณอินเตอร์เนชั่นแนลฟู๊ดส์ จำกัด | V.01.01
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/adminlte.min.js?v=3.2.0') }}"></script>
</body>

</html>