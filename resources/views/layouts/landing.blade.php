<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ระบบ HRM | Top Navigation</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+Thai">
</head>

<body>
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg sticky-top p-0" style="background-color: #F2F4F7;">
            <section class="container-fluid" style="padding: 40px;">
                <a class="navbar-brand" href="/"><img src="{{ asset('CIF_Logo.png') }}" height="48" alt="website logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvaHRN" aria-controls="navbarOffcanvaHRN" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvaHRN" aria-labelledby="navbarOffcanvaHRNLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="{{ asset('CIF_Logo.png') }}" height="48" alt="website logo"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                      </div>
                      <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end align-items-lg-center flex-grow-1 gap-3 gap-lg-5">
                            <li class="nav-item">
                                <a href="{{ route('announcement') }}" class="nav-link offcanva">ข่าวประกาศ</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('application') }}" class="nav-link offcanva">รับสมัครงาน</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link offcanva">ติดต่อเรา</a>
                            </li>
                            @if (Route::has('login'))
                            <!-- Messages Dropdown Menu -->
                            @auth

                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link offcanva">แดชบอร์ด</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="/login" class="btn btn-primary btn-lg">เข้าสู่ระบบ</a>
                            </li>

                            @endauth
                            @endif
                        </ul>
                      </div>
                </div>
            </section>
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
        @include('layouts.footer')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <script src="{{ asset('assets/js/adminlte.min.js?v=3.2.0') }}"></script>
</body>

</html>
