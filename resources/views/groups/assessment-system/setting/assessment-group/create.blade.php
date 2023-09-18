@extends('layouts.dashboard')

@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มการประเมิน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.assessment-system.assessment.assessment')}}">การประเมิน</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มการประเมิน</li>
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
                            <h3 class="card-title">การประเมิน</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('groups.assessment-system.setting.assessment-group.store')}}"
                                method="POST">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>การประเมิน<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" id="name" value="{{old('name')}}"
                                                class="form-control  @error('name') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>จุดประสงค์<span class="small text-danger">*</span></label>
                                            <select name="purpose"
                                                class="form-control select2 @error('purpose') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($assessmentPurposes as $assessmentPurpose)
                                                <option value="{{ $assessmentPurpose->id }}">
                                                    {{ $assessmentPurpose->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 text-right">
                                        <button class="btn bg-success mt-2">บันทึก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
<script>
    $('.select2').select2()
    // window.params = {
    
    // getUsersRoute: '{{ route('groups.document-system.overtime.document.get-users') }}',
    
    // url: '{{ url('/') }}',
    // token: $('meta[name="csrf-token"]').attr('content')
    // };

</script>
@endpush
@endsection