<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="#" class="d-block">{{Auth::user()->name}} {{Auth::user()->lastname}}</a>
        </div>
    </div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{route('setting')}}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        แดชบอร์ด
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-sitemap"></i>
                    <p>
                        องค์กร
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{route('setting.organization.employee.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>พนักงาน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('setting.organization.approver.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>การอนุมัติ</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-user-tag"></i>
                    <p>
                        การใช้งาน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{route('setting.access.role.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>สิทธิ์การใช้งาน</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        ทั่วไป
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{route('setting.general.companydepartment.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>แผนก</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('setting.general.searchfield.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ฟิลเตอร์ตาราง</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                        รายงาน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{route('setting.report')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ข้อมูลพนักงาน</p>
                        </a>
                    </li>
                </ul>
            </li>
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
</div>