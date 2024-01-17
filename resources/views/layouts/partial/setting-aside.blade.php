<aside class="slidebar-dashboard">
    <div class="title-bar">
        <a href="{{url('/')}}" class="brand-link">
            <img src="{{ asset('CIF_Logo.png') }}" height="32" alt="website logo">
        </a>
        <a href="#" id="menuBtn" class="menuBtn" >
            <span class="material-symbols-outlined" style="font-size: 2rem;">
                menu
            </span>
        </a>
    </div>
    @include('layouts.partial.setting-sidebar')
</aside>