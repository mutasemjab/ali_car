<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Ayla</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->



                @if (
                $user->can('customer-table') ||
                $user->can('customer-add') ||
                $user->can('customer-edit') ||
                $user->can('customer-delete'))
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.Customers')}} </p>
                    </a>
                </li>
                @endif



           @if (
                $user->can('category-table') ||
                $user->can('category-add') ||
                $user->can('category-edit') ||
                $user->can('category-delete'))
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.categories')}} </p>
                    </a>
                </li>
                @endif

                @if (
                $user->can('unit-table') ||
                $user->can('unit-add') ||
                $user->can('unit-edit') ||
                $user->can('unit-delete'))
                <li class="nav-item">
                    <a href="{{ route('units.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.units')}} </p>
                    </a>
                </li>
                @endif

                @if (
                $user->can('product-table') ||
                $user->can('product-add') ||
                $user->can('product-edit') ||
                $user->can('product-delete'))
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.products')}} </p>
                    </a>
                </li>
                @endif




                @if (
                    $user->can('warehouse-table') ||
                        $user->can('warehouse-add') ||
                        $user->can('warehouse-edit') ||
                        $user->can('warehouse-delete'))
                    <li class="nav-item">
                        <a href="{{ route('warehouses.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{ __('messages.warehouses') }} </p>
                        </a>
                    </li>
                @endif

                @if (
                    $user->can('purchaseOrder-table') ||
                        $user->can('purchaseOrder-add') ||
                        $user->can('purchaseOrder-edit') ||
                        $user->can('purchaseOrder-delete'))
                    <li class="nav-item">
                        <a href="{{ route('purchaseOrders.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{ __('messages.purchaseOrders') }} </p>
                        </a>
                    </li>
                @endif

             @if (
                    $user->can('invoice-table') ||
                        $user->can('invoice-add') ||
                        $user->can('invoice-edit') ||
                        $user->can('invoice-delete'))
                    <li class="nav-item">
                        <a href="{{ route('invoices.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{ __('messages.invoices') }} </p>
                        </a>
                    </li>
                @endif

           @if (
                    $user->can('invoice-table') ||
                        $user->can('invoice-add') ||
                        $user->can('invoice-edit') ||
                        $user->can('invoice-delete'))
                    <li class="nav-item">
                        <a href="{{ route('check.car') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{ __('messages.Check car') }} </p>
                        </a>
                    </li>
                @endif




                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            {{ __('messages.reports') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('inventory_report') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> {{ __('messages.inventory_report_with_costs') }} </p>
                            </a>
                        </li>


                    </ul>
                </li>





                <li class="nav-item">
                    <a href="{{ route('admin.login.edit',auth()->user()->id) }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('messages.Admin_account')}} </p>
                    </a>
                </li>

                @if ($user->can('role-table') || $user->can('role-add') || $user->can('role-edit') ||
                $user->can('role-delete'))
                <li class="nav-item">
                    <a href="{{ route('admin.role.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <span>{{__('messages.Roles')}} </span>
                    </a>
                </li>
                @endif

                @if (
                $user->can('employee-table') ||
                $user->can('employee-add') ||
                $user->can('employee-edit') ||
                $user->can('employee-delete'))
                <li class="nav-item">
                    <a href="{{ route('admin.employee.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <span> {{__('messages.Employee')}} </span>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
