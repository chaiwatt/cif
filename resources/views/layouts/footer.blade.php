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