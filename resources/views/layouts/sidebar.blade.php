<style type="text/css">
#b1, #b2, #b3 {
display: none;
}

</style>

<div class="side-content-wrap">
    {{-- @php if(session()->get('user')->role_id == 1) echo 'id="hide_menu_admin"'; @endphp --}}
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true" >
        <ul class="navigation-left">
            <li class="nav-item {{ (request()->is('dashboard') || request()->is('dashboard/*')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('dashboard')}}">
                <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/dashboard.png')}}" alt="">
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <!-- <li class="nav-item {{ (request()->is('new_features') || request()->is('new_features/*')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('new_features')}}">
                <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/new_features.png')}}" alt="">
                    <span class="nav-text">New Features</span>
                </a>
                <div class="triangle"></div>
            </li> -->
            <li class="nav-item {{ (request()->is('transaction') || request()->is('transaction/*')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('transaction')}}">
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/transaction.png')}}"alt="">
                    <span class="nav-text">Transaction Laku Pandai</span>
                </a>
                <div class="triangle"></div>
            </li>
            <!-- <li class="nav-item {{ (request()->is('transactionBJB') || request()->is('transactionBJB/*')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('transactionBJB')}}">
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/transactionbjb.png')}}"alt="">
                    <span class="nav-text">Transaction BJB (PPOB)</span>
                </a>
                <div class="triangle"></div>
            </li> -->
	    <li class="nav-item {{ (request()->is('terminal') || request()->is('terminal/*')) ? 'active' : '' }}" @php if(session()->get('user')->role_id == 2) echo 'id="b1"'; @endphp>
                <a class="nav-item-hold" href="{{route('terminal')}}" >
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/terminal.png')}}" alt="">
                    <span class="nav-text">Terminal</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->is('agen') || request()->is('agen/*')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('agen')}}">
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/agent.png')}}" alt="">
                    <span class="nav-text">Agen</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->is('nasabah') || request()->is('nasabah/*')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('nasabah')}}">
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/nasabah.png')}}" alt="">
                    <span class="nav-text">Nasabah</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->is('masterdata') || request()->is('masterdata/*')) ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('masterdata')}}">
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/masterdata.png')}}" alt="">
                    <span class="nav-text">Master Data</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->is('message') || request()->is('message/*')) ? 'active' : '' }}" @php if(session()->get('user')->role_id == 2) echo 'id="b1"'; @endphp>
                <a class="nav-item-hold" href="{{route('message_log')}}">
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/log.png')}}" alt="">
                    <span class="nav-text">Message Log</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ (request()->is('biller') || request()->is('biller/*')) ? 'active' : '' }}" @php if(session()->get('user')->role_id == 2) echo 'id="b1"'; @endphp>
                <a class="nav-item-hold" href="{{route('biller')}}">
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/biller.png')}}" alt="">
                    <span class="nav-text">Biller</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('extrakits/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('dashboard_version_11')}}">
                 
                    <img class="img_bintang_sidebar" src="{{asset('/assets/images/sidebar_icon/version.png')}}" alt="">
                    <span class="nav-text">Version</span>
                </a>
                <div class="triangle"></div>
            </li>
          
        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="Transaksi">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='dashboard_version_1' ? 'open' : '' }}"
                    href="{{route('dashboard_version_1')}}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">Distributor Utama</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('dashboard_version_2')}}"
                    class="{{ Route::currentRouteName()=='dashboard_version_2' ? 'open' : '' }}">
                    <i class="nav-icon i-Clock-4"></i>
                    <span class="item-name">Distributor</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='dashboard_version_3' ? 'open' : '' }}"
                    href="{{route('dashboard_version_3')}}">
                    <i class="nav-icon i-Over-Time"></i>
                    <span class="item-name">Agen</span>
                </a>
            </li>
           
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>

<!--=============== Left side End ================-->
