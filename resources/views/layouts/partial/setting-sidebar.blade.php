<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="#" class="d-block">{{Auth::user()->name}} {{Auth::user()->lastname}}</a>
        </div>
    </div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{route('setting')}}" class="nav-link {{ request()->is('setting') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        แดชบอร์ด
                    </p>
                </a>
            </li>
            <li class="nav-item nav-item {{ request()->is('setting/organization*') ? 'menu-open' : '' }}">
                <a href="" class="nav-link {{ request()->is('setting/organization*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-sitemap"></i>
                    <p>
                        องค์กร
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview"
                    style="{{ request()->is('setting/organization*') ? '' : 'display: none;' }}">
                    <li class="nav-item">
                        <a href="{{route('setting.organization.employee.index')}}"
                            class="nav-link {{ request()->is('setting/organization/employee*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>พนักงาน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('setting.organization.company.index')}}"
                            class="nav-link {{ request()->is('setting/organization/company*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ข้อมูลบริษัท</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ request()->is('setting/access*', 'setting/assignment*') ? 'menu-open' : '' }}">
                <a href=""
                    class="nav-link {{ request()->is('setting/access*', 'setting/assignment*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-tag"></i>
                    <p>
                        การใช้งาน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview"
                    style="{{ request()->is('setting/access*', 'setting/assignment*') ? '' : 'display: none;' }}">
                    <li class="nav-item">
                        <a href="{{route('setting.access.role.index')}}"
                            class="nav-link {{ request()->is('setting/access/role*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>สิทธิ์การใช้งาน</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ request()->is('setting/general*') ? 'menu-open' : '' }}">
                <a href="" class="nav-link {{ request()->is('setting/general*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        ทั่วไป
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="{{ request()->is('setting/general*') ? '' : 'display: none;' }}">
                    <li class="nav-item">
                        <a href="{{route('setting.general.companydepartment.index')}}"
                            class="nav-link {{ request()->is('setting/general/companydepartment*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>แผนก</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('setting.general.tax')}}"
                            class="nav-link {{ request()->is('setting.general.tax*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ประกันสังคมและภาษี</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('setting.general.searchfield.index')}}"
                            class="nav-link {{ request()->is('setting/general/searchfield*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ฟิลเตอร์ตาราง</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ request()->is('setting/report*') ? 'menu-open' : '' }}">
                <a href="" class="nav-link {{ request()->is('setting/report*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                        รายงาน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="{{ request()->is('setting/report*') ? '' : 'display: none;' }}">
                    <li class="nav-item">
                        <a href="{{route('setting.report.user')}}"
                            class="nav-link {{ request()->is('setting/report/user*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ข้อมูลพนักงาน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('setting.report.expiration')}}"
                            class="nav-link {{ request()->is('setting/report/expiration*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>วีซ่า/ใบอนุญาต</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('setting.report.log')}}"
                            class="nav-link {{ request()->is('setting/report/log*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ประวัติใช้งาน (Log)</p>
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