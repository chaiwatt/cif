@extends('layouts.setting-dashboard')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">นำเข้าพนักงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">นำเข้าพนักงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                เกิดข้อผิดพลาดการนำเข้า โปรดตรวจสอบไฟล์นำเข้าให้ถูกต้อง
            </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">วิธีการนำเข้าพนักงาน</h3>
                        </div>
                        <div class="card-body">
                            <p>การนำเข้าพนักงานโดยใช้ไฟล์เทมเพลต จะต้องตรวสอบข้อมูลให้ถูกต้องและห้ามลบแถวแรกของตาราง
                                ถ้าช่องคอลัมน์ที่ไฮไลต์สีแดงจะต้องใส่ให้ครบ</p>
                            <strong>ดาวน์โหลดเทมเพลต</strong>
                            <div>
                                <a href="https://fontawesome.com/">เทมเพลตนำเข้าพนักงาน</a><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form action="{{route('setting.organization.employee.import.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="file" name="file" accept=".xlsx, .xls, .csv"> --}}
                        <div class="form-group">

                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" accept=".xlsx, .xls, .csv"
                                    id="customFile">
                                {{-- <label class="custom-file-label" for="customFile">เลือกไฟล์</label> --}}
                                <label class="custom-file-label" for="customFile">เลือกไฟล์ exel</label>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary mb-2 float-right">นำเข้าพนักงาน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function () {
        bsCustomFileInput.init();
        });
</script>
@endpush
@endsection