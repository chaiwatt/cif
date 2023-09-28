<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">แดชบอร์ดระบบบันทึกเวลา</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active">ระบบบันทึกเวลา</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-calendar-times"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">ขาด (สิงหาคม)</span>
                        <span class="info-box-number">1,410</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">กลับก่อน (สิงหาคม)</span>
                        <span class="info-box-number">410</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">มาสาย (สิงหาคม)</span>
                        <span class="info-box-number">13,648</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">การบันทึกเวลา</h3>
                        <div class="card-tools mr-1">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <div id="searchWrapper" class="d-flex"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>ตารางทำงาน</th>
                                                <th>จำนวนขาด</th>
                                                <th>จำนวนมาสาย</th>
                                                <th>จำนวนกลับก่อน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>