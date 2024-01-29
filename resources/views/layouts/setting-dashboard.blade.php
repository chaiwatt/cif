<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>CIF HRM</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    {{--
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}"> --}}

    @stack('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+Thai">
<body data-page="dashboard">
    <div class="d-flex flex-grow-1">
        @include('layouts.partial.setting-aside')
        <div class="d-flex flex-grow-1 flex-column rounded-start-3 overflow-hidden" style="background: #F2F4F7;">
            <nav class="navbar navbar-expand">
                <ul class="navbar-nav d-flex justify-content-between align-items-center w-100 px-3">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="d-flex text-decoration-none" style="color: #101828;">
                            <span class="material-symbols-outlined" style="font-size: 28px">
                                home
                            </span>
                        </a>
                    </li>
                    {{-- Current Page --}}
                    @isset($currentPage)
                        <li class="nav-item">
                            <h4 class="m-0">{{ $currentPage }}</h4>
                        </li>
                    @endisset
                    <li class="d-flex gap-3">
                        <div class="d-none d-sm-block">
                            <p class="text-md-end m-0">{{Auth::user()->name}} {{Auth::user()->lastname}}</p>
                            <p class="text-md-end m-0 text-muted" style="font-size: 12px">{{Auth::user()->user_position->name}}</p>
                        </div>
                        <img src="{{ Auth::user()->avatar != "" ? route('storage.avatar', ['image'=> Auth::user()->avatar]) : asset('user_test.png') }}" class="rounded-circle" width="40px" height="40px" alt="avatar">
                        {{-- โทรโขง --}}
                        <button class="btn rounded-circle p-0" style="width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <mask id="mask0_114_428" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                                <rect width="24" height="24" fill="#D9D9D9"/>
                                </mask>
                                <g mask="url(#mask0_114_428)">
                                <path d="M22.125 13.025H19.575C19.2792 13.025 19.0302 12.9236 18.8281 12.7206C18.626 12.5177 18.525 12.276 18.525 11.9956C18.525 11.7152 18.626 11.475 18.8281 11.275C19.0302 11.075 19.2792 10.975 19.575 10.975H22.125C22.4042 10.975 22.6448 11.0765 22.8469 11.2794C23.049 11.4823 23.15 11.724 23.15 12.0044C23.15 12.2848 23.049 12.525 22.8469 12.725C22.6448 12.925 22.4042 13.025 22.125 13.025ZM17.275 16.975C17.4583 16.7583 17.6902 16.6292 17.9707 16.5875C18.2511 16.5458 18.5025 16.6083 18.725 16.775L20.775 18.3C20.9917 18.4667 21.125 18.6902 21.175 18.9707C21.225 19.2511 21.1583 19.5025 20.975 19.725C20.8083 19.9583 20.5848 20.1 20.3044 20.15C20.0239 20.2 19.7641 20.1333 19.525 19.95L17.475 18.425C17.2583 18.2583 17.125 18.0306 17.075 17.7419C17.025 17.4531 17.0917 17.1975 17.275 16.975ZM20.775 5.70001L18.8 7.20001C18.5775 7.36668 18.3261 7.42918 18.0457 7.38751C17.7652 7.34584 17.5333 7.21668 17.35 7.00001C17.1667 6.78334 17.0958 6.52918 17.1375 6.23751C17.1792 5.94584 17.3167 5.71668 17.55 5.55001L19.55 4.02501C19.7725 3.85834 20.0239 3.80001 20.3044 3.85001C20.5848 3.90001 20.8083 4.03334 20.975 4.25001C21.1583 4.48334 21.225 4.74168 21.175 5.02501C21.125 5.30834 20.9917 5.53334 20.775 5.70001ZM4.10001 15.625H2.92501C2.32917 15.5583 1.83438 15.299 1.44063 14.8469C1.04688 14.3948 0.850006 13.8708 0.850006 13.275V10.725C0.850006 10.0792 1.08438 9.52189 1.55313 9.05314C2.02188 8.58439 2.57917 8.35001 3.22501 8.35001H7.30001L11.35 5.95001C11.75 5.71668 12.1458 5.70781 12.5375 5.92341C12.9292 6.13901 13.125 6.48121 13.125 6.95001V17.05C13.125 17.5188 12.9292 17.861 12.5375 18.0766C12.1458 18.2922 11.75 18.2833 11.35 18.05L7.30001 15.625H6.57501V18.4C6.57501 18.7458 6.45688 19.0365 6.22063 19.2719C5.98436 19.5073 5.6927 19.625 5.34563 19.625C4.99855 19.625 4.70417 19.5073 4.46251 19.2719C4.22084 19.0365 4.10001 18.7458 4.10001 18.4V15.625ZM14.125 15.975V8.00001C14.7583 8.45001 15.2625 9.02501 15.6375 9.72501C16.0125 10.425 16.2 11.1833 16.2 12C16.2 12.8167 16.0125 13.575 15.6375 14.275C15.2625 14.975 14.7583 15.5417 14.125 15.975Z" fill="#101828"/>
                                </g>
                            </svg>
                        </button>
                        {{-- document --}}
                        <button class="btn rounded-circle p-0 noifiy" style="width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <mask id="mask0_114_434" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                                <rect width="24" height="24" fill="#D9D9D9"/>
                                </mask>
                                <g mask="url(#mask0_114_434)">
                                <path d="M7.5 16.85C7.7 16.85 7.875 16.775 8.025 16.625C8.175 16.475 8.25 16.3 8.25 16.1C8.25 15.9 8.175 15.725 8.025 15.575C7.875 15.425 7.7 15.35 7.5 15.35C7.3 15.35 7.125 15.425 6.975 15.575C6.825 15.725 6.75 15.9 6.75 16.1C6.75 16.3 6.825 16.475 6.975 16.625C7.125 16.775 7.3 16.85 7.5 16.85ZM7.5 12.75C7.7 12.75 7.875 12.675 8.025 12.525C8.175 12.375 8.25 12.2 8.25 12C8.25 11.8 8.175 11.625 8.025 11.475C7.875 11.325 7.7 11.25 7.5 11.25C7.3 11.25 7.125 11.325 6.975 11.475C6.825 11.625 6.75 11.8 6.75 12C6.75 12.2 6.825 12.375 6.975 12.525C7.125 12.675 7.3 12.75 7.5 12.75ZM7.5 8.65C7.7 8.65 7.875 8.575 8.025 8.425C8.175 8.275 8.25 8.1 8.25 7.9C8.25 7.7 8.175 7.525 8.025 7.375C7.875 7.225 7.7 7.15 7.5 7.15C7.3 7.15 7.125 7.225 6.975 7.375C6.825 7.525 6.75 7.7 6.75 7.9C6.75 8.1 6.825 8.275 6.975 8.425C7.125 8.575 7.3 8.65 7.5 8.65ZM11.55 16.85H16.15C16.3625 16.85 16.5406 16.7777 16.6844 16.6331C16.8281 16.4885 16.9 16.3094 16.9 16.0956C16.9 15.8819 16.8281 15.7042 16.6844 15.5625C16.5406 15.4208 16.3625 15.35 16.15 15.35H11.55C11.3375 15.35 11.1594 15.4223 11.0156 15.5669C10.8719 15.7115 10.8 15.8906 10.8 16.1044C10.8 16.3181 10.8719 16.4958 11.0156 16.6375C11.1594 16.7792 11.3375 16.85 11.55 16.85ZM11.55 12.75H16.15C16.3625 12.75 16.5406 12.6777 16.6844 12.5331C16.8281 12.3885 16.9 12.2094 16.9 11.9956C16.9 11.7819 16.8281 11.6042 16.6844 11.4625C16.5406 11.3208 16.3625 11.25 16.15 11.25H11.55C11.3375 11.25 11.1594 11.3223 11.0156 11.4669C10.8719 11.6115 10.8 11.7906 10.8 12.0044C10.8 12.2181 10.8719 12.3958 11.0156 12.5375C11.1594 12.6792 11.3375 12.75 11.55 12.75ZM11.55 8.65H16.15C16.3625 8.65 16.5406 8.57771 16.6844 8.43313C16.8281 8.28853 16.9 8.10936 16.9 7.89563C16.9 7.68188 16.8281 7.50417 16.6844 7.3625C16.5406 7.22083 16.3625 7.15 16.15 7.15H11.55C11.3375 7.15 11.1594 7.22229 11.0156 7.36687C10.8719 7.51147 10.8 7.69064 10.8 7.90437C10.8 8.11812 10.8719 8.29583 11.0156 8.4375C11.1594 8.57917 11.3375 8.65 11.55 8.65ZM4.5 21C4.1 21 3.75 20.85 3.45 20.55C3.15 20.25 3 19.9 3 19.5V4.5C3 4.1 3.15 3.75 3.45 3.45C3.75 3.15 4.1 3 4.5 3H19.5C19.9 3 20.25 3.15 20.55 3.45C20.85 3.75 21 4.1 21 4.5V19.5C21 19.9 20.85 20.25 20.55 20.55C20.25 20.85 19.9 21 19.5 21H4.5Z" fill="#101828"/>
                                </g>
                            </svg>
                            {{-- new noifiy --}}
                            <span class="red-dot">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <circle cx="6" cy="6" r="5" fill="#F04438" stroke="#F9FAFB" stroke-width="2"/>
                                </svg>
                            </span>
                        </button>
                        {{-- calender --}}
                        <button class="btn rounded-circle p-0" style="width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <mask id="mask0_114_440" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                                <rect width="24" height="24" fill="#D9D9D9"/>
                                </mask>
                                <g mask="url(#mask0_114_440)">
                                <path d="M14.9204 18.5C14.2401 18.5 13.6667 18.2651 13.2 17.7954C12.7333 17.3257 12.5 16.7507 12.5 16.0704C12.5 15.3901 12.7349 14.8167 13.2046 14.35C13.6743 13.8833 14.2493 13.65 14.9296 13.65C15.6099 13.65 16.1833 13.8849 16.65 14.3546C17.1167 14.8243 17.35 15.3993 17.35 16.0796C17.35 16.7599 17.1151 17.3333 16.6454 17.8C16.1757 18.2667 15.6007 18.5 14.9204 18.5ZM4.5 22C4.1 22 3.75 21.85 3.45 21.55C3.15 21.25 3 20.9 3 20.5V5C3 4.6 3.15 4.25 3.45 3.95C3.75 3.65 4.1 3.5 4.5 3.5H6.125V2.8C6.125 2.57333 6.20167 2.38333 6.355 2.23C6.50833 2.07667 6.69833 2 6.925 2C7.15875 2 7.35469 2.07667 7.51283 2.23C7.67094 2.38333 7.75 2.57333 7.75 2.8V3.5H16.25V2.8C16.25 2.57333 16.3267 2.38333 16.48 2.23C16.6333 2.07667 16.8233 2 17.05 2C17.2838 2 17.4797 2.07667 17.6378 2.23C17.7959 2.38333 17.875 2.57333 17.875 2.8V3.5H19.5C19.9 3.5 20.25 3.65 20.55 3.95C20.85 4.25 21 4.6 21 5V20.5C21 20.9 20.85 21.25 20.55 21.55C20.25 21.85 19.9 22 19.5 22H4.5ZM4.5 20.5H19.5V9.75H4.5V20.5Z" fill="#101828"/>
                                </g>
                            </svg>
                        </button>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn btn-outline-secondary p-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <mask id="mask0_114_445" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                <rect width="20" height="20" fill="#D9D9D9"/>
                                </mask>
                                <g mask="url(#mask0_114_445)">
                                <path d="M9.02085 9.89583V2.875C9.02085 2.59722 9.1146 2.36111 9.3021 2.16667C9.4896 1.97222 9.72224 1.875 10 1.875C10.2778 1.875 10.5104 1.97222 10.6979 2.16667C10.8854 2.36111 10.9792 2.59722 10.9792 2.875V9.89583C10.9792 10.1736 10.8854 10.4062 10.6979 10.5938C10.5104 10.7812 10.2778 10.875 10 10.875C9.72224 10.875 9.4896 10.7812 9.3021 10.5938C9.1146 10.4062 9.02085 10.1736 9.02085 9.89583ZM10 18.0625C8.88891 18.0625 7.84724 17.8542 6.87502 17.4375C5.9028 17.0208 5.0521 16.4479 4.32294 15.7188C3.59377 14.9896 3.02085 14.1389 2.60419 13.1667C2.18752 12.1944 1.97919 11.1528 1.97919 10.0417C1.97919 9.05556 2.14585 8.12153 2.47919 7.23958C2.81252 6.35764 3.31252 5.55556 3.97919 4.83333C4.17363 4.59722 4.42016 4.46875 4.71877 4.44792C5.01738 4.42708 5.2778 4.52083 5.50002 4.72917C5.69446 4.92361 5.78474 5.15625 5.77085 5.42708C5.75697 5.69792 5.66669 5.9375 5.50002 6.14583C4.97224 6.6875 4.57988 7.2882 4.32294 7.94792C4.06599 8.60764 3.93752 9.30556 3.93752 10.0417C3.93752 11.7222 4.5278 13.1528 5.70835 14.3333C6.88891 15.5139 8.31947 16.1042 10 16.1042C11.6806 16.1042 13.1111 15.5139 14.2917 14.3333C15.4722 13.1528 16.0625 11.7222 16.0625 10.0417C16.0625 9.29167 15.9306 8.59028 15.6667 7.9375C15.4028 7.28472 15.0278 6.6875 14.5417 6.14583C14.3611 5.92361 14.2604 5.66667 14.2396 5.375C14.2188 5.08333 14.3056 4.84722 14.5 4.66667C14.7222 4.44444 14.9861 4.34722 15.2917 4.375C15.5972 4.40278 15.8542 4.53472 16.0625 4.77083C16.7014 5.50694 17.191 6.32292 17.5313 7.21875C17.8715 8.11458 18.0417 9.05556 18.0417 10.0417C18.0417 11.1528 17.8299 12.1944 17.4063 13.1667C16.9827 14.1389 16.4063 14.9896 15.6771 15.7188C14.9479 16.4479 14.0972 17.0208 13.125 17.4375C12.1528 17.8542 11.1111 18.0625 10 18.0625Z" fill="#101828"/>
                                </g>
                            </svg>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            @yield('content')
        </div>


    </div>
    @include('layouts.footer')

</body>
{{-- HRM Slidebar --}}
<script src="{{ asset('js/hrm_slidebar.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

{{-- <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script> --}}

{{-- <script src="{{ asset('assets/js/adminlte.min.js') }}"></script> --}}

@stack('scripts')



</html>
