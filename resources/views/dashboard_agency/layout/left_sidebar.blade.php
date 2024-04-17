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

                @php
                    $agencyUser = session('agency_user');
                @endphp
                @if($agencyUser->agency_level == 1)
                    <li class="sidebar-item">
                        <a
                                class="sidebar-link {{ request()->is('agency/list-order-sim') ? 'active' : '' }} waves-effect waves-dark sidebar-link"
                                href="{{ route('agency_user.list_order_sim') }}"
                                aria-expanded="false"
                        ><i class="mdi mdi-sim"></i
                            ><span class="hide-menu">Lô sim</span></a
                        >
                    </li>
                @endif

                <li class="sidebar-item">
                    <a
                            class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('agency/withdraw') ? 'active' : '' }}"
                            href="{{ route('agency_user.withdraw') }}"
                            aria-expanded="false"
                    ><i class="mdi mdi-bank"></i
                        ><span class="hide-menu">thanh toán</span></a
                    >
                </li>
                @if($agencyUser->agency_level == 1)
                <li class="sidebar-item">
                    <a
                            class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->is('agency/agency-child') ? 'active' : '' }}"
                            href="{{ route('agency_child.index') }}"
                            aria-expanded="false"
                    ><i class="mdi mdi-pencil"></i
                        ><span class="hide-menu">Tạo mới một cấp đại lý</span></a
                    >
                </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
