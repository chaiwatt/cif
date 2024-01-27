@extends('layouts.landing')
@section('content')
<div class="row" style="padding: 0 40px">
    <div class="col-lg-12 p-0 mb-4">
        {{-- @if (count($announcements->where('status',1)) != 0) --}}
        <div class="card card-primary card-outline border-0">
            <div class="card-header">
                <h3 class="card-title m-0 px-4 py-3 d-flex gap-3 align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <mask id="mask0_1_3699" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="48" height="48">
                          <rect width="48" height="48" fill="#D9D9D9"/>
                        </mask>
                        <g mask="url(#mask0_1_3699)">
                          <path d="M44.25 26.05H39.15C38.5583 26.05 38.0604 25.8471 37.6563 25.4413C37.2521 25.0354 37.05 24.5521 37.05 23.9913C37.05 23.4304 37.2521 22.95 37.6563 22.55C38.0604 22.15 38.5583 21.95 39.15 21.95H44.25C44.8083 21.95 45.2896 22.1529 45.6938 22.5588C46.0979 22.9646 46.3 23.448 46.3 24.0088C46.3 24.5696 46.0979 25.05 45.6938 25.45C45.2896 25.85 44.8083 26.05 44.25 26.05ZM34.55 33.95C34.9167 33.5167 35.3804 33.2584 35.9413 33.175C36.5022 33.0917 37.0051 33.2167 37.45 33.55L41.55 36.6C41.9833 36.9334 42.25 37.3805 42.35 37.9413C42.45 38.5022 42.3167 39.0051 41.95 39.45C41.6167 39.9167 41.1696 40.2 40.6087 40.3C40.0478 40.4 39.5283 40.2667 39.05 39.9L34.95 36.85C34.5167 36.5167 34.25 36.0613 34.15 35.4837C34.05 34.9062 34.1833 34.395 34.55 33.95ZM41.55 11.4L37.6 14.4C37.1551 14.7334 36.6522 14.8584 36.0913 14.775C35.5304 14.6917 35.0667 14.4334 34.7 14C34.3333 13.5667 34.1917 13.0584 34.275 12.475C34.3583 11.8917 34.6333 11.4334 35.1 11.1L39.1 8.05002C39.5449 7.71669 40.0478 7.60002 40.6087 7.70002C41.1696 7.80002 41.6167 8.06669 41.95 8.50002C42.3167 8.96669 42.45 9.48335 42.35 10.05C42.25 10.6167 41.9833 11.0667 41.55 11.4ZM8.20001 31.25H5.85001C4.65835 31.1167 3.66876 30.5979 2.88126 29.6938C2.09376 28.7896 1.70001 27.7417 1.70001 26.55V21.45C1.70001 20.1584 2.16876 19.0438 3.10626 18.1063C4.04376 17.1688 5.15835 16.7 6.45001 16.7H14.6L22.7 11.9C23.5 11.4334 24.2917 11.4156 25.075 11.8468C25.8583 12.278 26.25 12.9624 26.25 13.9V34.1C26.25 35.0376 25.8583 35.722 25.075 36.1532C24.2917 36.5844 23.5 36.5667 22.7 36.1L14.6 31.25H13.15V36.8C13.15 37.4917 12.9138 38.0729 12.4413 38.5438C11.9687 39.0146 11.3854 39.25 10.6913 39.25C9.9971 39.25 9.40835 39.0146 8.92501 38.5438C8.44168 38.0729 8.20001 37.4917 8.20001 36.8V31.25ZM28.25 31.95V16C29.5167 16.9 30.525 18.05 31.275 19.45C32.025 20.85 32.4 22.3667 32.4 24C32.4 25.6334 32.025 27.15 31.275 28.55C30.525 29.95 29.5167 31.0834 28.25 31.95Z" fill="#FE872B"/>
                        </g>
                      </svg>
                    ข่าวประกาศ</h3>
            </div>
            <div class="card-body d-flex p-5 overflow-auto" style="gap: 32px">
                {{-- <div class="d-flex flex-column" style="gap: 20px; flex: 0 0 364px;">
                    <div>
                        <img src="{{ asset('image_test.jpg') }}" class="object-fit-cover rounded" style="width: 100%; height: 180px" alt="annoucement-image">
                    </div>
                    <div>
                        <p class="text-muted" style="margin-bottom: 12px">20/10/2566</p>
                        <strong class="annoucement-description">
                            ประกาศกระทรวงอุตสาหกรรม เรื่อง กำหนดให้โรง งานประเภทต่าง ๆ ต้องติดตั้ง เครื่องมือหรือเครื่อง อุปกรณ์พิเศษ เพื่อตรวจสอบคุณภาพอากาศ จากปล่องแบบอัตโนมัติอย่างต่อเนื่อง
                        </strong>
                    </div>
                    <div class="text-end">
                        <a href="#" class="text-primary" style="padding: 8px 14px;">อ่านเพิ่มเติม</a>
                    </div>
                </div> --}}

                @php
                    $countAnnounce = 0;
                @endphp
                @foreach ($announcements->where('status',1) as $announcement)
                <div class="d-flex flex-column" style="gap: 20px; flex: 0 0 364px;">
                    <div>
                        <img src="{{ asset('image_test.jpg') }}" class="object-fit-cover rounded" style="width: 100%; height: 180px" alt="annoucement-image">
                    </div>
                    <div>
                        <p class="text-muted" style="margin-bottom: 12px">
                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                            $announcement->created_at)->format('d/m/Y')}}
                            </p>
                        <strong class="annoucement-description">
                            {{$announcement->title}}
                        </strong>
                    </div>
                    <div class="text-end">
                        <a href="{{route('post-announcement',['id' => $announcement->id])}}" class="text-primary" style="padding: 8px 14px;">อ่านเพิ่มเติม</a>
                    </div>
                </div>
                @php
                    $countAnnounce++;
                @endphp
                @if (count($announcements->where('status',1)) != $countAnnounce)
                    <div class="divider-y"></div>
                @endif

                @endforeach
            </div>
        </div>
        {{-- @endif --}}
    </div>
</div>
@endsection
