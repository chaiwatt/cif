@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">ประกันสังคมและภาษี</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
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
                                <div class="row gy-2">
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
                                    <div class="mt-2 text-end">
                                        <button type="submit"
                                            class="btn btn-primary">บันทึก</button>
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