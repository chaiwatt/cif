@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">เพิ่มรายการจัดการเรียนรู้</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.learning-system.setting.learning-list')}}">กลุ่มพนักงาน</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มรายการจัดการเรียนรู้</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">

                        <!-- Display validation errors -->
                        <form action="{{route('groups.learning-system.setting.learning-list.store')}}"
                            method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ชื่อรายการจัดการเรียนรู้ <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name')}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>คำอธิบาย</label>
                                            <input type="text" name="description" value="{{old('description')}}"
                                                class="form-control @error('description') is-invalid @enderror">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="cif-modal-footer">
                                @if ($permission->create)
                                <button type="submit"
                                    class="btn btn-primary">บันทึก</button>
                                @endif

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')


<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('setting.organization.approver.assignment.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection