<nav class="mt-2">
    <ul class="nav nav-sidebar flex-column" role="menu" data-accordion="true" data-accordion="false">
        <li class="nav-item">
            <a href="{{url($groupUrl)}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    แดชบอร์ด
                </p>
            </a>
        </li>
    </ul>
</nav>
<nav>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach ($modules as $module)
        <li class="nav-item">
            <a href="" class="nav-link">
                <i class="nav-icon fas {{$module->module_icon}}"></i>
                <p>
                    {{ $module->module_name }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
                @foreach ($module->jobs as $job)
                <li class="nav-item">
                    <a href="{{ $job->job_route ? route($job->job_route) : '#' }}"
                        class="nav-link {{ empty($job->job_route) ? ' text-danger' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{$job->job_name}}</p>
                    </a>
                </li>
                @endforeach

            </ul>

        </li>
        @endforeach
        <li class="nav-item">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>ออกจากระบบ</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>