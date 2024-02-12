@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
@if ($errors->any())
    <div class="alert alert-danger m-4">
        <ul>
            @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
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
                    <form action="{{ route('setting.general.tax.store') }}" method="POST" class="card">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title">ประกันสังคมและภาษี</h4>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row gy-2">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label>เงินเดือนขั้นต่ำประกันสังคม</label>
                                            <input type="text" value="{{ $taxSetting->id }}" name="tagSettingId" hidden="">
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
                            </div>
                        </div>
                        <div class="cif-modal-footer">
                            <button type="submit"
                                class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
@endpush
@endsection
