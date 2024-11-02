<div class="navbar navbar-expand-lg navbar-dark navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-paragraph-justify3"></i>
        </button> --}}
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-transmission"></i>
        </button>
    </div>

    <div class="navbar-brand text-center text-lg-left">
        <a href="#!" class="d-inline-block">
            <img src="{{ asset('images/Logo-CNPT-Copy-removebg-preview.png') }}" class="d-none d-sm-block" alt="">
            <img src="{{ asset('images/Logo-CNPT-Copy-removebg-preview.png') }}" class="d-sm-none" alt="">
        </a>
    </div>

    <div class="collapse navbar-collapse order-2 order-lg-1" id="navbar-mobile">

    </div>

    <ul class="navbar-nav flex-row order-1 order-lg-2 flex-1 flex-lg-0 justify-content-end align-items-center">
        <li class="nav-item nav-item-dropdown-lg dropdown">
            <a href="{{ route('logout') }}" class="navbar-nav-link">
                <i class="icon-switch2"></i>
            </a>
        </li>

        {{-- <li class="nav-item nav-item-dropdown-lg dropdown dropdown-user h-100">
            <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle d-inline-flex align-items-center h-100" data-toggle="dropdown">
                <img src="{{ asset('images/clipart3643767.png') }}" class="rounded-pill mr-lg-2" height="34" alt="">
                <span class="d-none d-lg-inline-block">Victoria</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item"><i class="icon-switch2"></i> Đăng xuất</a>
            </div>
        </li> --}}
    </ul>
</div>