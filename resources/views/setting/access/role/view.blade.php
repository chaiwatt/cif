@extends('layouts.setting-dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">Role: {{$role->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('setting.access.role.index')}}">สิทธิ์การใช้งาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$role->name}}</li>
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
                            <h4 class="card-title">รายละเอียดข้อมูลแผนก</h4>
                        </div>
                        <form action="{{ route('setting.access.role.update', ['id' => $role->id]) }}" method="POST">
                            @method('PUT')
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Role<span class="small text-danger">*</span></label>
                                            <input type="text" name="name" value="{{old('name') ?? $role->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
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
</div>
@push('scripts')

@endpush
@endsection