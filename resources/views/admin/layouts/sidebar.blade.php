<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sidebar-user-material">
                <div class="sidebar-section-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <button type="button" class="btn btn-outline-light border-transparent btn-icon btn-sm rounded-pill">
                                <i class="icon-wrench"></i>
                            </button>
                        </div>
                        <a href="#" class="flex-1 text-center">
                            <img src="{{ asset('images/clipart3643767.png') }}" 
                            class="img-fluid rounded-circle shadow-sm" width="80" height="80" alt="">
                        </a>
                        <div class="flex-1 text-right">
                            <button type="button" class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>

                            <button type="button" class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center">
                        <h6 class="mb-0 text-white text-shadow-dark mt-3">{{ auth()->user()->username }}</h6>
                        {{-- <span class="font-size-sm text-white text-shadow-dark">Santa Ana, CA</span> --}}
                    </div>
                </div>

            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Menu</div> 
                    <i class="icon-menu" title="Main"></i>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link dashboard">
                        <i class="icon-home4"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('schools.index') }}" class="nav-link schools">
                        <i class="icon-office"></i>
                        <span>Trường học</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('subjects.index') }}" class="nav-link subjects">
                        <i class="icon-books"></i>
                        <span>Môn học</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('vnedu-files.index') }}" class="nav-link vnedu-files">
                        <i class="icon-file-spreadsheet"></i>
                        <span>Bảng điểm</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ asset('pdf/hdsd_edu_cnpt.pdf') }}" class="nav-link" target="_blank">
                        <i class="icon-file-text2"></i> 
                        <span>Hướng dẫn</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->
    
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        let menu = {{ Js::from($menu['sidebar'] ?? '') }};
        $('.nav-link.'+menu).addClass('active');
    })
</script>
@endpush