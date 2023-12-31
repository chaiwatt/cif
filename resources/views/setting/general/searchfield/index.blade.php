@extends('layouts.setting-dashboard')
@push('styles')

@endpush
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ฟิลเตอร์ของตาราง</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">ฟิลเตอร์ของตาราง</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                กำหนดฟิลด์
                            </h3>
                        </div>
                        <div class="card-body">

                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
                                        href="#custom-content-below-home" role="tab"
                                        aria-controls="custom-content-below-home" aria-selected="false">ตารางพนักงาน</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                                        href="#custom-content-below-profile" role="tab"
                                        aria-controls="custom-content-below-profile"
                                        aria-selected="false">ตารางอื่น1</a>
                                </li> --}}
                            </ul>
                            <div class="tab-content" id="custom-content-below-tabContent">
                                <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel"
                                    aria-labelledby="custom-content-below-home-tab">
                                    <form action="{{route('setting.general.searchfield.user.update')}}" method="POST">
                                        @csrf
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%">ใช้งาน</th>
                                                    <th>ชื่อฟิลด์ค้นหา</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($searchFields as $searchFiled)
                                                <tr>
                                                    <td>
                                                        <div class="icheck-primary d-inline">
                                                            <input name="selectField[]" type="checkbox"
                                                                id="checkboxPrimary{{$searchFiled->id}}"
                                                                @if($searchFiled->status ==1)
                                                            checked
                                                            @endif
                                                            value="{{$searchFiled->id}}"
                                                            >
                                                            <label for="checkboxPrimary{{$searchFiled->id}}">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>{{$searchFiled->comment}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn bg-gradient-success btn-flat float-right">บันทึก</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                {{-- <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel"
                                    aria-labelledby="custom-content-below-profile-tab">
                                    Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra
                                    purus ut ligula
                                    tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit.
                                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia
                                    Curae; Maecenas
                                    sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus
                                    ligula eu lectus.
                                    Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod
                                    pellentesque diam.
                                </div> --}}
                            </div>



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
@endpush
@endsection