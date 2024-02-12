@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">รายการเงินได้เงินหัก</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการเงินได้เงินหัก</li>
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
                            <h4 class="card-title">รายการเงินได้เงินหัก</h4>
                        </div>
                        <div class="table-responsive" id="table_container">
                            <table class="table table-borderless text-nowrap">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>#</th>
                                        <th>รายการ</th>
                                        <th>ประเภท</th>
                                        <th>หน่วย</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomeDeducts as $key => $incomeDeduct)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$incomeDeduct->name}}</td>
                                        <td>{{$incomeDeduct->assessableType->name}}</td>
                                        <td>{{$incomeDeduct->unit->name}}</td>
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
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>

@endpush
@endsection