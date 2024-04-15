<aside class="left-sidebar text-capitalize" data-sidebarbg="skin5">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <li class="sidebar-item">
                    <a
                            class="sidebar-link {{ request()->is('/') ? 'active' : '' }} waves-effect waves-dark sidebar-link"
                            href="{{ route('agency_user.dashboard') }}"
                    ><i class="mdi mdi-view-dashboard"></i
                        ><span class="hide-menu">Tổng quan</span></a
                    >
                </li>
                <li class="sidebar-item">
                    <a
                            class="sidebar-link {{ request()->is('agency/list-order-sim') ? 'active' : '' }} waves-effect waves-dark sidebar-link"
                            href="{{ route('agency_user.list_order_sim') }}"
                            aria-expanded="false"
                    ><i class="mdi mdi-account"></i
                        ><span class="hide-menu">Lô sim</span></a
                    >
                </li>
                <li class="sidebar-item">
                    <a
                            class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="#"
                            aria-expanded="false"
                    ><i class="mdi mdi-reorder-horizontal"></i
                        ><span class="hide-menu">Danh Sách Giao Dịch</span></a
                    >
                </li>
                <li class="sidebar-item">
                    <a
                            class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="#"
                            aria-expanded="false"
                    ><i class="mdi mdi-border-inside"></i
                        ><span class="hide-menu">Danh Sách Đơn Hàng</span></a
                    >
                </li>

                <li class="sidebar-item">
                    <a
                            class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('agency/withdraw') ? 'active' : '' }}"
                            href="{{ route('agency_user.withdraw') }}"
                            aria-expanded="false"
                    ><i class="mdi mdi-relative-scale"></i
                        ><span class="hide-menu">thanh toán</span></a
                    >
                </li>

                <li class="sidebar-item">
                    <a
                            class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="#"
                            aria-expanded="false"
                    ><i class="mdi mdi-pencil"></i
                        ><span class="hide-menu">Elements</span></a
                    >
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
