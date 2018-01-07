<div class="sidebar" data-active-color="carcoin" data-background-color="carcoin" data-image="/Carcoin/img/illu2.svg">
    <div class="logo">
        <a href="javascript:;" class="simple-text logo-mini">
            <img src="/Carcoin/img/zcoin-id-final_logo-rev.svg">
        </a>
        <a href="javascript:;" class="simple-text logo-normal">
            Car Coin
        </a>

    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="{{ Gravatar::get(Auth()->user()->email) }}" />
            </div>
            <div class="info">
                <span>{{ Auth::user()->name }}</span>
                <span>ID: {{  Auth::user()->uid }}</span>
                <span>Pack: @if(isset(Auth::user()->userData->package->name)){{ Auth::user()->userData->package->name }}@endif</span>
                <span>Rank: @if(Auth::user()->userData->loyaltyId){{ config('carcoin.listLoyalty')[Auth::user()->userData->loyaltyId] }} @else - @endif</span>
            </div>
        </div>
        <ul class="nav">
            <li>
                <a href="{{ url('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p> {{ trans('adminlte_lang::default.side_dashboard') }} </p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#pagesExamples">
                    <i class="material-icons">supervisor_account</i>
                    <p> 
                        Tree 
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="pagesExamples">
                    <ul class="nav">
                        <li>
                            <a href="{{url('members/genealogy')}}">
                                <span class="sidebar-mini"> GT </span>
                                <span class="sidebar-normal"> Genealogy Tree </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('members/binary')}}">
                                <span class="sidebar-mini"> BT </span>
                                <span class="sidebar-normal"> Binary Tree </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('members/referrals')}}">
                                <span class="sidebar-mini"> R </span>
                                <span class="sidebar-normal"> Referrals </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li>
                 <a data-toggle="collapse" href="#pagesExamples1">
                    <i class="material-icons">assignment_ind</i>
                    <p> Wallet 
                        <b class="caret"></b>
                    </p>

                </a>
                <div class="collapse" id="pagesExamples1">
                    <ul class="nav">
                        <li>
                            <a href="/wallets/btc">
                                <span class="sidebar-mini"> B </span>
                                <span class="sidebar-normal"> Bitcoin Wallet </span>
                            </a>
                        </li>
                        <li>
                            <a href="/wallets/car">
                                <span class="sidebar-mini"> C </span>
                                <span class="sidebar-normal"> Carcoin Wallet </span>
                            </a>
                        </li>
                        <li>
                            <a href="/wallets/reinvest">
                                <span class="sidebar-mini"> R </span>
                                <span class="sidebar-normal"> Reinvest Wallet </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#my_bonus">
                    <i class="material-icons">card_giftcard</i>
                    <p> My Bonus 
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="my_bonus">
                    <ul class="nav">
                        <li>
                            <a href="/mybonus/infinity">
                                <span class="sidebar-mini"> I </span>
                                <span class="sidebar-normal"> Infinity Bonus </span>
                            </a>
                        </li>
                        <li>
                            <a href="/mybonus/infinity-interest">
                                <span class="sidebar-mini"> I </span>
                                <span class="sidebar-normal"> Infinity Interest </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ url('packages/buy')}}">
                    <i class="material-icons">payment</i>
                    <p> Buy Package </p>
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
// Active Sidebar Class 
var sidebarNav = document.querySelectorAll('.sidebar-wrapper .nav > li > a');
for (let i = 0; i < sidebarNav.length; i++) {

    let href = sidebarNav[i].getAttribute("href");
    if (href == window.location.href || href == window.location.pathname) {

        sidebarNav[i].parentNode.classList.add("active");
        sidebarNav[i].setAttribute('aria-expanded', 'true');

        // If Sidebar is Submenu
        let subMenu = sidebarNav[i].parentNode.parentNode.parentNode;
        subMenu.getAttribute("class") == 'collapse' ?
            (subMenu.classList.add("in"), subMenu.parentNode.classList.add("active")) :
            subMenu


    }
}
</script>