@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ประกันสังคมและภาษี</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ประกันสังคมและภาษี</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ประกันสังคมและภาษี</h3>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>เงินเดือนขั้นต่ำประกันสังคม</label>
                                            <input type="text" name="social_contribution_salary"
                                                value="{{$taxSetting->social_contribution_salary}}"
                                                class="form-control decimal-input">
                                        </div>

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>ร้อยละหักประกันสังคม</label>
                                            <input type="text" name="social_contribution_percent"
                                                value="{{$taxSetting->social_contribution_percent}}"
                                                class="form-control decimal-input">
                                        </div>

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>สบทบสูงสุด</label>
                                            <input type="text" name="social_contribution_max"
                                                value="{{$taxSetting->social_contribution_max}}"
                                                class="form-control decimal-input">
                                        </div>

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>ร้อยละหักภาษีโบนัส</label>
                                            <input type="text" name="bonus_tax_percent"
                                                value="{{$taxSetting->bonus_tax_percent}}"
                                                class="form-control decimal-input">
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn bg-gradient-success btn-flat float-right">บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
@endpush
@endsection