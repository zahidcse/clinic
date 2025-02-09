<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ url('/dashboard') }}"><img class="img-fluid"
                    src="{{ asset('assets/images/logo/logo_light.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
                </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ url('/dashboard') }}"><img class="img-fluid"
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>


                    <li class="dashboard-menu sidebar-list">
                        <a class="sidebar-link sidebar-title fs1" href="{{ url('/dashboard') }}">
                            <i class="fa fa-tachometer f-20" aria-hidden="true"></i> Dashboard

                        </a>
                    </li>

                   
                    <li class="all-appointments-menu sidebar-list">
                        <a class="sidebar-link sidebar-title fs1" href="{{ url('/all-appointments') }}">
                            <i class="fa fa-calendar f-20" aria-hidden="true"></i>
                            Appointments

                        </a>
                    </li>
                    

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
