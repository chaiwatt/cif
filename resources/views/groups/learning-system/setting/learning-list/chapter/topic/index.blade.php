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
                    <h3 class="m-0">รายละเอียดการเรียนรู้: {{$chapter->name}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.learning-system.setting.learning-list.chapter',['id' => $chapter->lesson->id ])}}">หัวข้อการเรียนรู้</a>
                        </li>
                        <li class="breadcrumb-item active">{{$chapter->name}}</li>
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
                            <h4 class="card-title">รายละเอียดการเรียนรู้</h4>
                                <a class="btn btn-header"
                                href="{{route('groups.learning-system.setting.learning-list.chapter.topic.create',['id' => $chapter->id])}}">
                                <i class="fas fa-plus">
                                </i>
                                เพิ่มรายละเอียดการเรียนรู้
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
                                <div class="col-sm-12 table-responsive" id="table_container">
                                    <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th>รายละเอียดการเรียนรู้</th>
                                                {{-- <th>วันที่เพิ่ม</th> --}}
                                                <th class="text-end" style="width: 110px">เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($chapter->topics as $topic)
                                            <tr>
                                                <td>{{$topic->name}}</td>

                                                <td class="text-end">
                                                    <a class="btn btn-action btn-sm btn-edit"
                                                        href="{{route('groups.learning-system.setting.learning-list.chapter.topic.view',['id' => $topic->id ])}}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    @if ($permission->delete == true)
                                                    <a class="btn btn-action btn-delete btn-sm"
                                                        data-confirm='ลบรายละเอียดการเรียนรู้ "{{$topic->name}}" หรือไม่?'
                                                        href="#" data-id="{{$topic->id}}"
                                                        data-delete-route="{{ route('groups.learning-system.setting.learning-list.chapter.topic.delete', ['id' => '__id__']) }}"
                                                        data-message="รายละเอียดการเรียนรู้">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    @endif
                                                    {{-- <a class="btn btn-sm btn-primary "
                                                        href="{{route('groups.learning-system.setting.learning-list.chapter.topic',['id' => $chapter->id])}}"><i
                                                            class="fas fa-link"></i></a>

                                                    --}}
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