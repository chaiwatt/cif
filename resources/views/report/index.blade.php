@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
<style>
    a{
        text-decoration: none;
    }
</style>
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">สรรพกร

                        {{-- {{$month->name}} --}}
                    </h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">รายงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('bis50', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>หนังสือรับรองการหักภาษี ณ ที่จ่าย</span>
                            <h2 class="m-0">ทวิ 50</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('bis50', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>รายชื่อพนักงานผู้เสียภาษีเงินได้ (สรุปรายเดือน)</span>
                            <h2 class="m-0">ภ.ง.ด.1</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>รายชื่อพนักงานผู้เสียภาษีเงินได้ (สรุปรายปี)</span>
                            <h2 class="m-0">ภ.ง.ด.1</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('bis50', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>ใบปะแบบยื่นรายการภาษีเงินได้ (รายเดือน)</span>
                            <h2 class="m-0">ภ.ง.ด.1</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('bis50', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>ใบปะแบบยื่นรายการภาษีเงินได้ (รายปี)</span>
                            <h2 class="m-0">ภ.ง.ด.1</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('pnd', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>ไฟล์แนบการยื่นภาษีสรรพกร (รายเดือน)</span>
                            <h2 class="m-0">PND</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('pnd', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>ไฟล์แนบการยื่นภาษีสรรพกร (รายปี)</span>
                            <h2 class="m-0">PND</h2>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <hr>
            <div>
                <div class="container-fluid">
                    <div class="title-header">
                        <div>
                            <h3 class="m-0">ประกันสังคม
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('ssoPayment', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>แบบรายการแสดงการส่งเงินสมทบ (รายวัน)</span>
                            <h2 class="m-0">สปส 1-10</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('ssoPaymonth', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>แบบรายการแสดงการส่งเงินสมทบ (รายเดือน)</span>
                            <h2 class="m-0">สปส 1-10</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('ssoPayment', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>แบบรายการแสดงการส่งเงินสมทบ (ใบรวม)</span>
                            <h2 class="m-0">สปส 1-10</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('ssoPaymonth', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>รายชื่อพนักงานแสดงการส่งเงินสมทบ (รายวัน)</span>
                            <h2 class="m-0">สปส 1-10</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('ssoPayment', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>รายชื่อพนักงานแสดงการส่งเงินสมทบ (รายเดือน)</span>
                            <h2 class="m-0">สปส 1-10</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('ssoPaymonth', 1) }}">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>รายชื่อพนักงานแสดงการส่งเงินสมทบ (ใบรวม)</span>
                            <h2 class="m-0">สปส 1-10</h2>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <div class="d-flex gap-4 p-4 bg-white rounded-4">
                        <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                            bar_chart
                        </span>
                        <div class="d-flex flex-column justify-content-between">
                            <span>ไฟล์นำส่งข้อมูลเงินสมทบพนักงาน</span>
                            <h2 class="m-0">DAT FILE (CSV)</h2>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('ipay', 1) }}">
                        <div class="d-flex gap-4 p-4 bg-white rounded-4">
                            <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                                bar_chart
                            </span>
                            <div class="d-flex flex-column justify-content-between">
                                <span></span>
                                <h2 class="m-0">IPAY</h2>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-12 px-2 mb-3">
                    <a href="{{ route('cashBank', 1) }}">
                        <div class="d-flex gap-4 p-4 bg-white rounded-4">
                            <span class="material-symbols-outlined text-white rounded-circle d-flex justify-content-center align-items-center" style="background: #3538CD; width: 4rem; height: 4rem; font-size: 36px;">
                                bar_chart
                            </span>
                            <div class="d-flex flex-column justify-content-between">
                                <span>รายงานโอนเงินเข้าธนาคาร</span>
                                <h2 class="m-0">BANK</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')

<script type="module" src="{{ asset('assets/js/helpers/salary-system/salary/calculation/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.salary-system.salary.calculation.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection
