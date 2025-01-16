<div class="header">
			
    <!-- Logo -->
     <div class="header-left active">
        <a href="{{ url ('home') }}" class="logo logo-normal">
            <img src="{{ url ('') }}/assets/img/logo.png"  alt="">
        </a>
        <a href="{{ url ('home') }}" class="logo logo-white">
            <img src="{{ url ('') }}/assets/img/logo-white.png"  alt="">
        </a>
        <a href="{{ url ('home') }}" class="logo-small">
            <img src="{{ url ('') }}/assets/img/logo-small.png"  alt="">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->
    
    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
    
    <!-- Header Menu -->
    <ul class="nav user-menu">
    
        <!-- Search -->
        <li class="nav-item nav-searchinputs">
            <div class="top-nav-search">
                
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
                </a>
                <form action="#">
                    <div class="searchinputs">
                        <input type="text" placeholder="Search">
                        <div class="search-addon">
                            <span><i data-feather="search" class="feather-14"></i></span>
                        </div>
                    </div>
                    <!-- <a class="btn"  id="searchdiv"><img src="{{ url ('') }}/assets/img/icons/search.svg" alt="img"></a> -->
                </form>
            </div>
        </li>
        <!-- /Search -->
 
        
        <li class="nav-item nav-item-box">
            <a href="generalsettings.html"><i data-feather="settings"></i></a>
        </li>
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-info">
                   {{--  <span class="user-letter">
                        <img src="{{ url ('') }}/assets/img/profiles/avator1.jpg" alt="" class="img-fluid">
                    </span> --}}
                    <span class="user-detail">
                        <span class="user-name">Admin User</span>
                        <span class="user-role">Super Admin</span>
                    </span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                  
                    <a class="dropdown-item" href="profile.html"> <i class="me-2"  data-feather="user"></i> My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html"><i class="me-2" data-feather="settings"></i>Settings</a>
                    <hr class="m-0">
                    <a class="dropdown-item logout pb-0" href="signin.html"><img src="{{ url ('') }}/assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                </div>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->
    
    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="generalsettings.html">Settings</a>
            <a class="dropdown-item" href="signin.html">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>