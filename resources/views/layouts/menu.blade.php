<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <img style="width: 35px;" src="{{ asset('logo.png') }}" alt="">
            <span class="demo menu-text fw-bolder ms-2" style="font-size: 20px;">{{ __('messages.panel_name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        @can('user_management_access')
            <li
                class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/roles') || request()->is('admin/roles/*') || request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-user-circle'></i>
                    <div data-i18n="Layouts">User Management</div>
                </a>

                <ul class="menu-sub">
                    @can('permission_access')
                        <li
                            class="menu-item {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Permission</div>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li
                            class="menu-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Roles</div>
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li
                            class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Users</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        <li class="menu-item {{ request()->is('admin/job') || request()->is('admin/job/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Job</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item {{ request()->is('admin/job/job-cards') || request()->is('admin/job/job-cards/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.job-cards.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Job Card</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->is('admin/job/delivery') || request()->is('admin/job/delivery/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.delivery.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Job Card Delivery</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->is('admin/job/complete-job-cards') || request()->is('admin/job/complete-job-cards/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.complete-job-cards.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Completed List</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->is('admin/job/invoices') || request()->is('admin/job/invoices/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.invoices.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Invoice</div>
                    </a>
                </li>
            </ul>
        </li>


    </ul>
</aside>
