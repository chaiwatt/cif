@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">ข่าวสมัครงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}">หน้าหลัก</a>
                        </li>
                        <li class="breadcrumb-item active">ข่าวสมัครงาน</li>
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
                            <h4 class="card-title">รายการข่าวสมัครงาน</h4>
                            <a class="btn btn-header"
                                href="{{route('groups.job-application-system.job-application.list.create')}}">
                                <i class="fas fa-plus">
                                </i>
                                เพิ่มข่าวสมัครงาน
                            </a>
                            {{-- @if (count($users) !=0)
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-end" placeholder="ค้นหา">
                                </div>
                            </div>
                            @endif --}}

                        </div>
                        <div class="card-body py-0">
                            <div class="row">
                                <div class="col-sm-12 table-responsive" id="table_container">
                                    <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th>ตำแหน่ง</th>
                                                <th>จำนวน</th>
                                                <th>ระยะเวลาการรับสมัคร</th>
                                                <th>สถานะเปิดรับสมัคร</th>
                                                <th style="width: 120px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applicationNews as $applicationNew)
                                            <tr>
                                                <td>{{$applicationNew->title}}</td>
                                                <td>{{$applicationNew->description}}</td>
                                                <td>{{ \Jenssegers\Date\Date::parse($applicationNew->start_date)->format('d M Y') }} - {{ \Jenssegers\Date\Date::parse($applicationNew->end_date)->format('d M Y') }}</td>
                                                <td>
                                                    @if ($applicationNew->status == 1)
                                                    แสดง
                                                    @elseif($applicationNew->status == 2)
                                                    ไม่แสดง
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" data-bs-target="#preview-{{ $applicationNew->id }}" data-bs-toggle="modal" class="text-primary">Preview</a>
                                                    <a class="btn btn-action btn-sm btn-edit"
                                                        href="{{route('groups.job-application-system.job-application.list.view',['id' => $applicationNew->id ])}}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    @if ($permission->delete == true)
                                                    <a class="btn btn-action btn-delete btn-sm"
                                                        data-confirm='ลบข่าวสมัครงาน"{{$applicationNew->name}}" หรือไม่?'
                                                        href="#" data-id="{{$applicationNew->id}}"
                                                        data-delete-route="{{ route('groups.job-application-system.job-application.list.delete', ['id' => '__id__']) }}"
                                                        data-message="ข่าวสมัครงาน">
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
                </div>

            </div>

            @endif

        </div>
    </div>
</div>
<!-- Modal -->
<div>
    @foreach ($applicationNews as $item)
    <div class="modal fade" id="preview-{{ $item->id }}" tabindex="-1" aria-labelledby="preview-{{ $item->id }}-Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 980px;">
          <div class="modal-content cif-content">
            <div class="modal-header">
                <div class="d-flex align-items-center" style="gap: 32px">
                    <img src="{{ asset('logomark.png') }}" alt="logomark" width="60" height="60">
                    <h3 class="modal-title" id="preview-{{ $item->id }}-Label">{{ $item->title }}</h3>
                </div>
                <a href="{{ $item->application_form }}" target="_blank" class="btn btn-primary btn-lg" style="width: 160px">สมัครงาน</a>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 48px 124px 0 124px">
                {!! $item->body !!}
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
    @endforeach
</div>
{{-- <div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
</div>
</div>
</div>
</div>
</div> --}}
@push('scripts')


<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {       
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection