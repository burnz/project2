<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{ Gravatar::get(Auth()->user()->email) }}" alt="user" /> </div>
            <!-- User profile text-->
            <div class="profile-text"> <a href="#" class="dropdown-toggle link u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ Auth()->user()->name }} <span class="caret"></span></a>
                <div class="dropdown-menu animated flipInY">
                    <a href="{{ url('profile') }}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                    {{--<a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>--}}
                    {{--<a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>--}}
                    {{--<div class="dropdown-divider"></div> <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>--}}
                    <div class="dropdown-divider"></div> <a href="{{ url('logout') }}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                </div>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">MENU</li>
                <li>
                    <a class="" href="{{ url('home') }}" aria-expanded="false"><i class="mdi mdi-home"></i><span class="hide-menu">Dashboard </span></a>
                </li>
                <li>
                    <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-human"></i><span class="hide-menu">{{ trans('adminlte_lang::default.side_member') }} <span class="label label-rounded label-success">3</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ url('members/genealogy') }}">{{ trans('adminlte_lang::default.side_member_genealogy') }}</a></li>
                        <li><a href="{{ url('members/binary') }}">{{ trans('adminlte_lang::default.side_member_binary') }}</a></li>
                        <li><a href="{{ url('members/referrals') }}">{{ trans('adminlte_lang::default.side_member_refferals') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-wallet"></i><span class="hide-menu">{{ trans('adminlte_lang::default.side_wallet') }} <span class="label label-rounded label-success">4</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ url('wallets/btc') }}">{{ trans('adminlte_lang::default.side_wallet_btc') }}</a></li>
                        <li><a href="{{ url('wallets/clp') }}">{{ trans('adminlte_lang::default.side_wallet_clp') }}</a></li>
                        <li><a href="{{ url('wallets/reinvest') }}">{{ trans('adminlte_lang::default.side_wallet_reinvest') }}</a></li>
                        <li><a href="{{ url('wallets/buypackage') }}">{{ trans('adminlte_lang::default.buy_package') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-flower"></i><span class="hide-menu">{{ trans('adminlte_lang::default.side_mybonus') }} <span class="label label-rounded label-success">3</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ url('mybonus/faststart') }}">{{ trans('adminlte_lang::default.side_mybonust_fast') }}</a></li>
                        <li><a href="{{ url('mybonus/binary') }}">{{ trans('adminlte_lang::default.side_mybonus_binary') }}</a></li>
                        <li><a href="{{ url('mybonus/loyalty') }}">{{ trans('adminlte_lang::default.side_mybonus_loyalty') }}</a></li>
                    </ul>
                </li>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    {{--<div class="sidebar-footer">--}}
        {{--<!-- item-->--}}
        {{--<a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>--}}
        {{--<!-- item-->--}}
        {{--<a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>--}}
        {{--<!-- item-->--}}
        {{--<a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>--}}
    {{--</div>--}}
    <!-- End Bottom points-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->