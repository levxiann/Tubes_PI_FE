<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Hita Do</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{url('/')}}">
                <span>Dashboard</span></a>
        </li>

        <!-- Shop -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Shop
        </div>

        <!-- Nav Item - Shop List -->
        @if (Session::get('user')->data->level == 'SA' || Session::get('user')->data->level == 'C')
            <li class="nav-item">
                <a class="nav-link" href="{{url('/shop')}}">
                    <span>Shop List</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{url('/shops/detail')}}">
                    <span>Shop Detail</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/product')}}">
                    <span>Product List</span>
                </a>
            </li>
        @endif

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Payment
        </div>

        <!-- Nav Item - Report -->
        @if (Session::get('user')->data->level != 'C')
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <span>Payment Report</span></a>
            </li>
        @else
            <!-- Nav Item - History -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <span>Payment History</span></a>
            </li>
        @endif
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            User
        </div>

        @if (Session::get('user')->data->level == 'SA')
            <!-- Nav Item - Report -->
            <li class="nav-item">
                <a class="nav-link" href="{{url('/user')}}">
                    <span>User List</span></a>
            </li>
        @elseif (Session::get('user')->data->level == 'A')
            <!-- Nav Item - Report -->
            <li class="nav-item">
                <a class="nav-link" href="{{url('/user/admin')}}">
                    <span>User List</span></a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link" href="{{url('/user/profile')}}">
                <span>User Profile</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>

                    <!-- Nav Item - Logout -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link" href="{{url('/logout')}}">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->