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
                $user->can('sectionUser-table') ||
                $user->can('sectionUser-add') ||
                $user->can('sectionUser-edit') ||
                $user->can('sectionUser-delete'))
                <li class="nav-item">
                    <a href="{{ route('sectionUsers.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.sectionUsers')}} </p>
                    </a>
                </li>
                @endif

                @if (
                $user->can('customer-table') ||
                $user->can('customer-add') ||
                $user->can('customer-edit') ||
                $user->can('customer-delete'))
                <li class="nav-item">
                    <a href="{{ route('admin.customer.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.Customers')}} </p>
                    </a>
                </li>
                @endif

              @if (
                $user->can('dealer-table') ||
                $user->can('dealer-add') ||
                $user->can('dealer-edit') ||
                $user->can('dealer-delete'))
                <li class="nav-item">
                    <a href="{{ route('admin.dealers.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.dealers')}} </p>
                    </a>
                </li>
                @endif


                @if (
                $user->can('cardPackage-table') ||
                $user->can('cardPackage-add') ||
                $user->can('cardPackage-edit') ||
                $user->can('cardPackage-delete'))
                <li class="nav-item">
                    <a href="{{ route('cardPackages.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.cardPackages')}} </p>
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
                $user->can('offer-table') ||
                $user->can('offer-add') ||
                $user->can('offer-edit') ||
                $user->can('offer-delete'))
                <li class="nav-item">
                    <a href="{{ route('offers.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.offers')}} </p>
                    </a>
                </li>
                @endif


                @if (
                    $user->can('transfer-table') ||
                        $user->can('transfer-add') ||
                        $user->can('transfer-edit') ||
                        $user->can('transfer-delete'))
                    <li class="nav-item">
                        <a href="{{ route('transfers.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{__('messages.transfers')}}  </p>
                        </a>
                    </li>
                @endif

            @if (
                    $user->can('requestBalance-table') ||
                        $user->can('requestBalance-add') ||
                        $user->can('requestBalance-edit') ||
                        $user->can('requestBalance-delete'))
                    <li class="nav-item">
                        <a href="{{ route('requestBalances.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{__('messages.requestBalances')}}  </p>
                        </a>
                    </li>
                @endif

            @if (
                    $user->can('payInvoice-table') ||
                        $user->can('payInvoice-add') ||
                        $user->can('payInvoice-edit') ||
                        $user->can('payInvoice-delete'))
                    <li class="nav-item">
                        <a href="{{ route('payInvoices.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{__('messages.payInvoices')}}  </p>
                        </a>
                    </li>
                @endif

            @if (
                    $user->can('transferBank-table') ||
                        $user->can('transferBank-add') ||
                        $user->can('transferBank-edit') ||
                        $user->can('transferBank-delete'))
                    <li class="nav-item">
                        <a href="{{ route('transferBanks.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{__('messages.transferBanks')}}  </p>
                        </a>
                    </li>
                @endif

                   @if (
                    $user->can('wallet-table') ||
                        $user->can('wallet-add') ||
                        $user->can('wallet-edit') ||
                        $user->can('wallet-delete'))
                    <li class="nav-item">
                        <a href="{{ route('wallets.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{__('messages.wallets')}}  </p>
                        </a>
                    </li>
                @endif




                @if (
                $user->can('order-table') ||
                $user->can('order-add') ||
                $user->can('order-edit') ||
                $user->can('order-delete'))
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.Orders')}} </p>
                    </a>
                </li>
                @endif


                @if (
                    $user->can('noteVoucherType-table') ||
                        $user->can('noteVoucherType-add') ||
                        $user->can('noteVoucherType-edit') ||
                        $user->can('noteVoucherType-delete'))
                    <li class="nav-item">
                        <a href="{{ route('noteVoucherTypes.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{ __('messages.noteVoucherTypes') }} </p>
                        </a>
                    </li>
                @endif
                @php
                    $noteVouchertypes = App\Models\NoteVoucherType::get();
                @endphp
                @foreach ($noteVouchertypes as $noteVouchertype)
                    <li class="nav-item">
                        <a href="{{ route('noteVouchers.create', ['id' => $noteVouchertype->id]) }}"
                            class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{ $noteVouchertype->name }} </p>
                        </a>
                    </li>
                @endforeach

                @if (
                    $user->can('noteVoucher-table') ||
                        $user->can('noteVoucher-add') ||
                        $user->can('noteVoucher-edit') ||
                        $user->can('noteVoucher-delete'))
                    <li class="nav-item">
                        <a href="{{ route('noteVouchers.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> {{ __('messages.noteVouchers') }} </p>
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
                $user->can('notification-table') ||
                $user->can('notification-add') ||
                $user->can('notification-edit') ||
                $user->can('notification-delete'))
                <li class="nav-item">
                    <a href="{{ route('notifications.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> {{__('messages.notifications')}} </p>
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
                        <li class="nav-item">
                            <a href="{{ route('order_report') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> {{ __('messages.order_report') }} </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product_move') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> {{ __('messages.product_move') }} </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tax_report') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> {{ __('messages.tax_report') }} </p>
                            </a>
                        </li>

                    </ul>
                </li>

                @if (
                    $user->can('page-table') ||
                        $user->can('page-add') ||
                        $user->can('page-edit') ||
                        $user->can('page-delete'))
                    <li class="nav-item">
                        <a href="{{ route('pages.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('messages.Pages')}} </p>
                        </a>
                    </li>
                    @endif
          
                @if (
                    $user->can('question-table') ||
                        $user->can('question-add') ||
                        $user->can('question-edit') ||
                        $user->can('question-delete'))
                    <li class="nav-item">
                        <a href="{{ route('questions.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('messages.questions')}} </p>
                        </a>
                    </li>
                    @endif

                @if (
                    $user->can('banner-table') ||
                        $user->can('banner-add') ||
                        $user->can('banner-edit') ||
                        $user->can('banner-delete'))
                    <li class="nav-item">
                        <a href="{{ route('banners.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('messages.banners')}} </p>
                        </a>
                    </li>
                    @endif
                @if (
                    $user->can('receivable-table') ||
                        $user->can('receivable-add') ||
                        $user->can('receivable-edit') ||
                        $user->can('receivable-delete'))
                    <li class="nav-item">
                        <a href="{{ route('receivables.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('messages.receivables')}} </p>
                        </a>
                    </li>
                    @endif

                @if (
                    $user->can('categorySubscription-table') ||
                        $user->can('categorySubscription-add') ||
                        $user->can('categorySubscription-edit') ||
                        $user->can('categorySubscription-delete'))
                    <li class="nav-item">
                        <a href="{{ route('categorySubscriptions.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('messages.categorySubscriptions')}} </p>
                        </a>
                    </li>
                    @endif

                <li class="nav-item">
                    <a href="{{ route('admin.setting.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('messages.Settings')}} </p>
                    </a>
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
