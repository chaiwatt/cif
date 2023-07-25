@extends('layouts.dashboard')
@push('scripts')
<style>
    #calendar .fc-header-toolbar,
    #calendar .fc-toolbar {
        display: none;
    }
</style>
@endpush
@section('content')
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มตารางทำงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.schedulework.schedule')}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มตารางทำงาน</li>
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
                            <h3 class="card-title">รายละเอียดตารางทำงาน</h3>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{route('groups.time-recording-system.schedulework.schedule.update', ['id' => $workSchedule->id])}}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ตารางทำงาน<span class="small text-danger">*</span></label>
                                            <input type="text" name="name"
                                                value="{{old('name') ?? $workSchedule->name}}"
                                                class="form-control @error('name') is-invalid @enderror">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>คำอธิบาย</label>
                                            <input type="text" name="description"
                                                value="{{old('description') ?? $workSchedule->description}}"
                                                class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>กะการทำงานที่ใช้<span class="small text-danger">*</span></label>
                                            <select name="shift[]" id="shift"
                                                class="form-control select2 @error('shift') is-invalid @enderror"
                                                style="width: 100%;" multiple>
                                                @foreach ($shifts->where('base_shift', 1) as $shift)
                                                <option value="{{ $shift->id }}" {{ $shift->
                                                    existsInWorkScheduleShifts($workSchedule->id) ? 'selected' : '' }}>
                                                    {{ $shift->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('shift')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>กรุณาเลือกกะการทำงาน</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ประเภทตารางทำงาน<span class="small text-danger">*</span></label>
                                            <select name="schedule_type"
                                                class="form-control select2 @error('schedule_type') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($scheduleTypes as $scheduleType)
                                                <option value="{{ $scheduleType->id }}" @if ($scheduleType->id ==
                                                    $workSchedule->schedule_type_id)
                                                    selected

                                                    @endif>
                                                    {{ $scheduleType->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ปี<span class="small text-danger">*</span></label>
                                            <select name="year"
                                                class="form-control select2 @error('year') is-invalid @enderror"
                                                style="width: 100%;">
                                                @foreach ($years as $year)
                                                <option value="{{ $year }}" @if ($year==$workSchedule->year) selected
                                                    @endif>
                                                    {{ $year }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        @if ($permission->update)
                                        <button type="submit"
                                            class="btn bg-gradient-success btn-flat float-right">บันทึก</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            <!-- Display validation errors -->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')

<script>
    $('.select2').select2()
</script>
@endpush
@endsection