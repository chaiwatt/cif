@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">หัวข้อการเรียนรู้</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.learning-system.setting.learning-list')}}">รายการจัดการเรียนรู้</a>
                        </li>
                        <li class="breadcrumb-item active">{{$lesson->name}}</li>
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
                            <h4 class="card-title">รายการหัวข้อการเรียนรู้</h4>
                                <a class="btn btn-header"
                                href="{{route('groups.learning-system.setting.learning-list.chapter.create',['id' => $lesson->id])}}">
                                <i class="fas fa-plus">
                                </i>
                                เพิ่มหัวข้อการเรียนรู้
                            </a>
                            {{-- @if (count($users) !=0)
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control float-right" placeholder="ค้นหา">
                                </div>
                            </div>
                            @endif --}}

                        </div>
                        <div>
                            <div class="row">
                                <div class="col-sm-12" id="table_container">
                                    <div class="table-responsive">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>หัวข้อการเรียนรู้</th>
                                                    {{-- <th>วันที่เพิ่ม</th> --}}
                                                    <th class="text-end" style="width: 200px">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($lesson->chapters as $chapter)
                                                <tr>
                                                    <td>{{$chapter->name}}</td>

                                                    <td class="text-end">
                                                        <a class="btn btn-action btn-sm btn-links "
                                                            href="{{route('groups.learning-system.setting.learning-list.chapter.topic',['id' => $chapter->id])}}"><i
                                                                class="fas fa-link"></i></a>
                                                        <a class="btn btn-action btn-sm btn-edit "
                                                            href="{{route('groups.learning-system.setting.learning-list.chapter.view',['id' => $lesson->id ])}}"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                        @if ($permission->delete == true)
                                                        <a class="btn btn-action btn-delete btn-sm"
                                                            data-confirm='ลบหัวข้อการเรียนรู้ "{{$chapter->name}}" หรือไม่?'
                                                            href="#" data-id="{{$chapter->id}}"
                                                            data-delete-route="{{ route('groups.learning-system.setting.learning-list.chapter.delete', ['id' => '__id__']) }}"
                                                            data-message="หัวข้อการเรียนรู้">
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

            </div>

            @endif

        </div>
    </div>

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

<script type="module" src="{{ asset('assets/js/helpers/salary-system/salary/calculation/index.js?v=1') }}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.salary-system.salary.calculation.search') }}',        
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection