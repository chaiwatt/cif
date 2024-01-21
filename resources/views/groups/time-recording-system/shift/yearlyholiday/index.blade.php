@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">วันหยุดประจำปี</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">วันหยุดประจำปี</li>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">วันหยุดประจำปี</h4>
                            <div class="d-flex gap-2">
                                @if ($permission->create)
                                <a class="btn btn-header" href="{{route('groups.time-recording-system.shift.yearlyholiday.create')}}">
                                    <i class="fas fa-plus"></i>
                                    เพิ่มวันหยุดประจำปี
                                </a>
                                @endif
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <select name="year" id="year"
                                            class="form-control @error('year') is-invalid @enderror" style="width: 100%;">
                                            @foreach ($years as $year)
                                            <option value="{{$year}}" {{ $year==date('Y') ? 'selected' : '' }}>{{$year}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive py-0 px-3" id="table_container">
                            <table class="table table-borderless text-nowrap">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>#</th>
                                        <th>วันที่</th>
                                        <th>วันหยุดประจำปี</th>
                                        <th class="text-end">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($yearlyHolidays as $key => $yearlyHoliday)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$yearlyHoliday->holiday_date}}</td>
                                        <td>{{$yearlyHoliday->name}}</td>
                                        <td class="text-end">
                                            @if ($permission->update)
                                            <a class="btn btn-action btn-edit btn-sm"
                                                href="{{ route('groups.time-recording-system.shift.yearlyholiday.view', ['id' => $yearlyHoliday->id]) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            @endif

                                            @if ($permission->delete == true)
                                            <a class="btn btn-action btn-delete btn-sm"
                                                data-confirm='ลบวันหยุดประจำปี "{{$yearlyHoliday->name}}" หรือไม่?'
                                                href="#" data-id="{{$yearlyHoliday->id}}"
                                                data-delete-route="{{ route('groups.time-recording-system.shift.yearlyholiday.delete', ['id' => '__id__']) }}"
                                                data-message="วันหยุดประจำปี">
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
<script type="module" src="{{asset('assets/js/helpers/time-recording-system/shift/yearly-holiday.js?v=1')}}"></script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.time-recording-system.shift.yearlyholiday.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection