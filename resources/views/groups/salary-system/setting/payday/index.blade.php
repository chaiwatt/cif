@extends('layouts.dashboard')
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">รอบคำนวนเงินเดือน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รอบคำนวนเงินเดือน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">รอบคำนวนเงินเดือน</h4>
                            <div class="d-flex gap-2">
                                @if ($permission->create)
                                <a class="btn btn-header" href="{{route('groups.salary-system.setting.payday.create')}}">
                                    <i class="fas fa-plus"></i>
                                    เพิ่มรอบคำนวนเงินเดือน
                                </a>
                                @endif
                                <div class="card-tools">
                                    <select name="year" id="year"
                                        class="form-control select2 @error('year') is-invalid @enderror" style="width: 100%;">
                                        @if (count($years) >= 1)
                                            @foreach ($years as $year)
                                            <option value="{{$year}}" {{ $year==date('Y') ? 'selected' : '' }}>{{$year}}
                                            </option>
                                            @endforeach
                                        @else
                                            <option selected disabled>ปี</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="table_container">
                            <table class="table text-nowrap table-borderless">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>กลุ่มพนักงาน</th>
                                        <th>จำนวนพนักงาน</th>
                                        <th>ปี</th>
                                        <th class="text-end">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paydays as $payday)
                                    <tr>
                                        <td>{{$payday->name}}</td>
                                        <td>{{count($payday->users)}}</td>
                                        <td>{{$payday->year}}</td>
                                        <td class="text-end">
                                            <a class="btn btn-action btn-user btn-sm"
                                                href="{{ route('groups.salary-system.setting.payday.assignment-user', ['id' => $payday->id]) }}">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a class="btn btn-action btn-links btn-sm"
                                                href="{{ route('groups.salary-system.setting.payday.assignment', ['id' => $payday->id]) }}">
                                                <i class="fas fa-link"></i>
                                            </a>
                                            @if ($permission->update)
                                            <a class="btn btn-action btn-edit btn-sm"
                                                href="{{route('groups.salary-system.setting.payday.view', ['id' => $payday->id])}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @endif

                                            @if ($permission->delete)
                                            <a class="btn btn-action btn-delete btn-sm"
                                                data-confirm='ลบรอบคำนวนเงินเดือน "{{$payday->name}}" หรือไม่?' href="#"
                                                data-id="{{$payday->id}}"
                                                data-delete-route="{{ route('groups.salary-system.setting.payday.delete', ['id' => '__id__']) }}"
                                                data-message="รอบคำนวนเงินเดือน">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/salary-system/setting/payday/index.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    $('.select2').select2();
    window.params = {
        searchRoute: '{{ route('groups.salary-system.setting.payday.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>
@endpush
@endsection