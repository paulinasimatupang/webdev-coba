    <div class="main-header">
            <div class="logo_bintang_header">
                <img src="{{asset('assets/images/icon_bintang/ntbs-transparan.png')}}" alt="">
            </div>

            <div class="menu-toggle">
                <div></div>
                        <div></div>
                <div></div>
            </div>


            <div style="margin: auto"></div>

            <div class="header-part-right">
                <!-- Full screen toggle -->
                <!-- <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i> -->
              
                <!-- Notificaiton -->
              
                <!-- Notificaiton End -->

                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div  class="user col align-self-end">
                        <img src="{{ asset('assets/images/sidebar_icon/profile.png') }}" style="width:24px; height:24px;" class="nav-icon cursor-pointer" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                               {{ Auth::user()->fullname }}
                            </div>
                            <!-- <a class="dropdown-item" href="{{route('user-profile')}}">Ubah Profile</a> -->
                           
                            <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- header top menu end -->
