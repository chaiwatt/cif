@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">กะการทำงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">กะการทำงาน</li>
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
                            <h4 class="card-title">กะการทำงาน</h4>
                            <div class="d-flex gap-2">
                                @if ($permission->create)
                                <a class="btn btn-header"
                                    href="{{route('groups.time-recording-system.shift.timeattendance.create')}}">
                                    <i class="fas fa-plus">
                                    </i>
                                    เพิ่มกะการทำงาน
                                </a>
                                @endif
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <select name="year" id="year"
                                            class="form-control select2 @error('year') is-invalid @enderror" style="width: 100%;">
                                            @if (count($years) >= 1)     
                                                @foreach ($years as $year)
                                                <option value="{{$year}}" {{ $year==date('Y') ? 'selected' : '' }}>{{$year}}
                                                </option>
                                                @endforeach
                                            @else
                                                <option value="" disabled selected>ยังไม่มีข้อมูล</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="table_container">
                            <table class="table table-borderless text-nowrap">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>ชื่อกะการทำงาน</th>
                                        <th>เวลาเริ่มงาน</th>
                                        <th>เวลาเลิกงาน</th>
                                        <th>ปีกะทำงาน</th>
                                        <th class="text-end">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shifts->where('base_shift',1) as $key => $shift)
                                    <tr>
                                        {{-- <td>{{$key +1}}</td> --}}
                                        <td>{{$shift->name}}</td>
                                        <td>{{$shift->start}}</td>
                                        <td>{{$shift->end}}</td>
                                        <td>{{$shift->year}}</td>
                                        <td class="text-end">
                                            @if ($permission->create)
                                            <a class="btn btn-user btn-action btn-sm"
                                                href="{{ route('groups.time-recording-system.shift.timeattendance.duplicate', ['id' => $shift->id]) }}">
                                                <i class="fas fa-copy"></i>
                                                </i>
                                            </a>
                                            @endif
                                            @if ($permission->update)
                                            <a class="btn btn-action btn-edit btn-sm"
                                                href="{{ route('groups.time-recording-system.shift.timeattendance.view', ['id' => $shift->id]) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            @endif

                                            @if ($permission->delete == true)
                                            <a class="btn btn-action btn-delete btn-sm"
                                                data-confirm='ลบกะการทำงาน "{{$shift->name}}" หรือไม่?' href="#"
                                                data-id="{{$shift->id}}"
                                                data-delete-route="{{ route('groups.time-recording-system.shift.timeattendance.delete', ['id' => '__id__']) }}"
                                                data-message="กะการทำงาน">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @endif
                                        </td>
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
<script type="module" src="{{asset('assets/js/helpers/time-recording-system/shift/shift.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.time-recording-system.shift.timeattendance.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
    $('.select2').select2()
</script>
@endpush
@endsection