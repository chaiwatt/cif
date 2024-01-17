<div class="sidebar">
    <nav class="mt-2">
        <ul class="navbar-nav text-center gap-3" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{route('setting')}}" class="nav-link {{ request()->is('setting') ? 'active' : '' }}">
                    <span class="material-symbols-outlined" >
                        dashboard
                    </span>
                    <p>
                        แดชบอร์ด
                    </p>
                    <span class="material-symbols-outlined icon-right">
                        keyboard_arrow_right
                    </span>
                </a>
            </li>
            <li class="nav-item nav-item {{ request()->is('setting/organization*') ? 'menu-open' : '' }}">
                <a href="" class="nav-link {{ request()->is('setting/organization*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined" >
                        location_city
                    </span>
                    <p>
                        องค์กร
                    </p>
                    <span class="material-symbols-outlined icon-right">
                        keyboard_arrow_right
                    </span>
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
                    <span class="material-symbols-outlined" >
                        person_check
                    </span>
                    <p>
                        การใช้งาน
                    </p>
                    <span class="material-symbols-outlined icon-right">
                        keyboard_arrow_right
                    </span>
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
                    <span class="material-symbols-outlined" >
                        settings
                    </span>
                    <p>
                        ทั่วไป
                    </p>
                    <span class="material-symbols-outlined icon-right">
                        keyboard_arrow_right
                    </span>
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
                    <span class="material-symbols-outlined" >
                        finance
                    </span>
                    <p>
                        รายงาน
                    </p>
                    <span class="material-symbols-outlined icon-right">
                        keyboard_arrow_right
                    </span>
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
        </ul>
    </nav>
</div>