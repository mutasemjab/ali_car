<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link d-flex align-items-center">
        <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3 ml-3" style="opacity: .9">
        <span class="brand-text font-weight-light ml-2">Ayla</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom border-secondary">
            <div class="image ml-2">
                <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

                @if (
                    $user->can('home-table'))
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-home nav-icon"></i>
                        <p> {{__('messages.Home')}} </p>
                    </a>
                </li>
                @endif

                <!-- Customers -->
                @if (
                $user->can('customer-table') ||
                $user->can('customer-add') ||
                $user->can('customer-edit') ||
                $user->can('customer-delete'))
                <li class="nav-item mb-1">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p> {{__('messages.Customers')}} </p>
                    </a>
                </li>
                @endif

                <!-- Categories -->
                @if (
                $user->can('category-table') ||
                $user->can('category-add') ||
                $user->can('category-edit') ||
                $user->can('category-delete'))
                <li class="nav-item mb-1">
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p> {{__('messages.categories')}} </p>
                    </a>
                </li>
                @endif

                <!-- Units -->
                @if (
                $user->can('unit-table') ||
                $user->can('unit-add') ||
                $user->can('unit-edit') ||
                $user->can('unit-delete'))
                <li class="nav-item mb-1">
                    <a href="{{ route('units.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p> {{__('messages.units')}} </p>
                    </a>
                </li>
                @endif

                <!-- Products -->
                @if (
                $user->can('product-table') ||
                $user->can('product-add') ||
                $user->can('product-edit') ||
                $user->can('product-delete'))
                <li class="nav-item mb-1">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p> {{__('messages.products')}} </p>
                    </a>
                </li>
                @endif

                <!-- Warehouses -->
                @if (
                    $user->can('warehouse-table') ||
                        $user->can('warehouse-add') ||
                        $user->can('warehouse-edit') ||
                        $user->can('warehouse-delete'))
                    <li class="nav-item mb-1">
                        <a href="{{ route('warehouses.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p> {{ __('messages.warehouses') }} </p>
                        </a>
                    </li>
                @endif

                <!-- Purchase Orders -->
                @if (
                    $user->can('purchaseOrder-table') ||
                        $user->can('purchaseOrder-add') ||
                        $user->can('purchaseOrder-edit') ||
                        $user->can('purchaseOrder-delete'))
                    <li class="nav-item mb-1">
                        <a href="{{ route('purchaseOrders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p> {{ __('messages.purchaseOrders') }} </p>
                        </a>
                    </li>
                @endif

                <!-- Invoices -->
                @if (
                    $user->can('invoice-table') ||
                        $user->can('invoice-add') ||
                        $user->can('invoice-edit') ||
                        $user->can('invoice-delete'))
                    <li class="nav-item mb-1">
                        <a href="{{ route('invoices.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p> {{ __('messages.invoices') }} </p>
                        </a>
                    </li>
                @endif

                <!-- Check Car -->
                @if (
                    $user->can('invoice-table') ||
                        $user->can('invoice-add') ||
                        $user->can('invoice-edit') ||
                        $user->can('invoice-delete'))
                    <li class="nav-item mb-1">
                        <a href="{{ route('check.car') }}" class="nav-link">
                            <i class="nav-icon fas fa-car"></i>
                            <p> {{ __('messages.Check car') }} </p>
                        </a>
                    </li>
                @endif

                @if (
                    $user->can('report-table'))
                <!-- Reports -->
                <li class="nav-item has-treeview mb-1">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            {{ __('messages.reports') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('inventory_report') }}" class="nav-link">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p> {{ __('messages.inventory_report_with_costs') }} </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif




                <!-- Roles Management -->
                @if ($user->can('role-table') || $user->can('role-add') || $user->can('role-edit') ||
                $user->can('role-delete'))
                <!-- Admin Settings Section Divider -->
                <li class="nav-header mt-2 text-uppercase">{{ __('messages.Admin') }}</li>

                <li class="nav-item mb-1">
                    <a href="{{ route('admin.role.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>{{__('messages.Roles')}} </p>
                    </a>
                </li>
                @endif

                <!-- Employee Management -->
                @if (
                $user->can('employee-table') ||
                $user->can('employee-add') ||
                $user->can('employee-edit') ||
                $user->can('employee-delete'))
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.employee.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p> {{__('messages.Employee')}} </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
