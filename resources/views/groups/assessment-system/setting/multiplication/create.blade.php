@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">เพิ่มตัวคูณคะแนนเกณฑ์การประเมิน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('groups.assessment-system.setting.multiplication')}}">ตัวคูณคะแนนเกณฑ์การประเมิน</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มตัวคูณคะแนนเกณฑ์การประเมิน</li>
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
                        <div class="card-header">
                            <h4 class="card-title">เพิ่มตัวคูณคะแนนเกณฑ์การประเมิน</h4>
                        </div>
                        <form action="{{route('groups.assessment-system.setting.multiplication.store')}}"
                            method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ตัวคูณคะแนนเกณฑ์การประเมิน <span class="fw-bold text-danger">*</span></label>
                                            <input type="text" name="multiplication" id="multiplication"
                                                value="{{old('multiplication')}}"
                                                class="form-control  @error('multiplication') is-invalid @enderror">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cif-modal-footer">
                                <button class="btn btn-primary">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')
{{-- <script type="module" src="{{asset('assets/js/helpers/document-system/overtime/document/create.js?v=1')}}">
</script> --}}
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
{{-- <script>
    $('.select2').select2()
    window.params = {
    
    getUsersRoute: '{{ route('groups.document-system.overtime.document.get-users') }}',
    
    url: '{{ url('/') }}',
    token: $('meta[name="csrf-token"]').attr('content')
    };

</script> --}}
@endpush
@endsection