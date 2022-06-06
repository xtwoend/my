<header class="navbar navbar-header navbar-header-fixed">
    <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
    <div class="navbar-brand">
        <a href="#" class="df-logo">
            <img src="{{ asset('img/mayora.png') }}" alt="PT. Mayora Indah Tbk">
        </a>
    </div><!-- navbar-brand -->
    <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
            <a href="#" class="df-logo">
                <img src="{{ asset('img/mayora.png') }}" alt="PT. Mayora Indah Tbk">
            </a>
            <a id="mainMenuClose" href="#"><i data-feather="x"></i></a>
        </div><!-- navbar-menu-header -->
        <ul class="nav navbar-menu">
            <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
            <li class="nav-item active">
                <a href="{{ route('home') }}" class="nav-link"><i data-feather="pie-chart"></i> Dashboard</a>
            </li>
            <li class="nav-item with-sub">
                <a href="" class="nav-link"><i data-feather="home"></i> Inventory</a>
                <ul class="navbar-menu-sub">
                    <li class="nav-sub-item"><a href="{{ url('/line-in') }}" class="nav-sub-link"><i data-feather="log-in"></i>Line In</a></li>
                    <li class="nav-sub-item"><a href="{{ url('/recapitulation') }}" class="nav-sub-link"><i data-feather="clipboard"></i>Form Pallet</a></li>
                    <li class="nav-sub-item"><a href="{{ url('/report') }}" class="nav-sub-link"><i data-feather="clipboard"></i>Rekapitulasi</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('product') }}" class="nav-link"><i data-feather="package"></i> Product</a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ route('schedule') }}" class="nav-link"><i data-feather="calendar"></i> Schedule</a>
            </li> --}}
            <li class="nav-item with-sub">
                <a href="" class="nav-link"><i data-feather="settings"></i> Setting</a>
                <ul class="navbar-menu-sub">
                    <li class="nav-sub-item"><a href="{{ route('shift') }}" class="nav-sub-link"><i data-feather="calendar"></i>Shifts</a></li>
                    <li class="nav-sub-item"><a href="{{ route('location') }}" class="nav-sub-link"><i data-feather="map-pin"></i>Location</a></li>
                    <li class="nav-sub-item"><a href="{{ route('reason') }}" class="nav-sub-link"><i data-feather="clipboard"></i>Reject Reason</a></li>
                    <li class="nav-sub-item"><a href="{{ route('sync') }}" class="nav-sub-link"><i data-feather="refresh-cw"></i> SAP Sync</a></li>
                </ul>
            </li>
        </ul>
    </div><!-- navbar-menu-wrapper -->

    <div class="navbar-right">
        {{-- <div class="dropdown dropdown-notification">
            <a href="" class="dropdown-link new-indicator" data-toggle="dropdown">
                <i data-feather="bell"></i>
                <span>2</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">Notifications</div>
                <a href="" class="dropdown-item">
                    <div class="media">
                        <div class="avatar avatar-sm avatar-online"><img src="https://via.placeholder.com/350" class="rounded-circle" alt=""></div>
                        <div class="media-body mg-l-15">
                            <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                            <span>Mar 15 12:32pm</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
                <div class="dropdown-footer"><a href="">View all Notifications</a></div>
            </div><!-- dropdown-menu -->
        </div><!-- dropdown --> --}}
        @if(Auth::user())
        <div class="dropdown dropdown-profile">
            <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                <div class="avatar avatar-sm"><img src="https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
            </a><!-- dropdown-link -->
            <div class="dropdown-menu dropdown-menu-right tx-13">
                <div class="avatar avatar-lg mg-b-15">
                    <img src="https://via.placeholder.com/500" class="rounded-circle" alt="">
                </div>

                <h6 class="tx-semibold mg-b-5">{{ Auth::user()->name }}</h6>
                <p class="mg-b-25 tx-12 tx-color-03">{{ Auth::user()->email }}</p>

                <a href="{{ route('edit-profile') }}" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
                {{-- <a href="page-profile-view.html" class="dropdown-item"><i data-feather="user"></i> View Profile</a> --}}
                <a href="{{ route('logout') }}"  class="dropdown-item"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i data-feather="log-out"></i> <span>Sign Out</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
        @endif
    </div><!-- navbar-right -->
</header><!-- navbar -->