 <!-- BEGIN Left Aside -->
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="<?= URL::to('admin'); ?>" class="page-logo-link press-scale-down d-flex align-items-center position-relative">
        <!-- {{ Auth::user()->photo }} -->
            <img src="{{ URL::asset('admin_assets/img/logo.png')}}" alt="Sebtember" aria-roledescription="logo">
            <span class="page-logo-text mr-1">{{ config('app.name') }}</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            {{-- <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i> --}}
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="{{ Auth::user()->photo }}" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                       {{ Auth::user()->first_name .' '. Auth::user()->last_name  }}
                    </span>
                </a>
                {{-- <span class="d-inline-block text-truncate text-truncate-sm">Toronto, Canada</span> --}}
            </div>
            <img src="{{ URL::asset('admin_assets/img/card-backgrounds/cover-2-lg.png')}}" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <!-- 
        TIP: The menu items are not auto translated. You must have a residing lang file associated with the menu saved inside dist/media/data with reference to each 'data-i18n' attribute.
        -->
        <ul id="js-nav-menu" class="nav-menu">
            <li class="{{ request()->is('admin')  ? 'active' : '' }}">
                <a href="{{ route('admin.home') }}" title="Dashboard" data-filter-tags="dashboard">
                    <i class="fal fa-tachometer "></i>
                    <span class="nav-link-text" data-i18n="nav.programs">Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/users')  ? 'active' : '' }}">
                <a href="{{ route('admin.user') }}" title="Users" data-filter-tags="user">
                    <i class="fal fa-user"></i>
                    <span class="nav-link-text" data-i18n="nav.users">Users</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/pages')  ? 'active' : '' }}">
                <a href="{{ route('admin.pages') }}" title="Pages" data-filter-tags="pages">
                    <i class="subheader-icon fal fa-file"></i>
                    <span class="nav-link-text" data-i18n="nav.pages">Pages</span>
                </a>
            </li>   
            <li class="{{ request()->is('admin/version')  ? 'active' : '' }}">
                <a href="{{ route('admin.version') }}" title="AppVersion" data-filter-tags="AppVersion">
                   <i class="fal fa-cog"></i>    
                    <span class="nav-link-text" data-i18n="nav.learner">App Version</span>
                </a>
            </li> 
            <li class="{{ request()->is('admin/setting')  ? 'active' : '' }}">
                <a href="{{ route('admin.setting') }}" title="App Setting" data-filter-tags="app setting">
                    <i class="fal fa-cogs"></i>
                    <span class="nav-link-text" data-i18n="nav.setting">App Setting</span>
                </a>
            </li>
            {{-- <li>
                <a href="#" title="Category" data-filter-tags="category">
                    <i class="fal fa-file"></i>
                    <span class="nav-link-text" data-i18n="nav.category">Category</span>
                </a>
                <ul>
                    <li>
                        <a href="javascript:void(0);" title="Menu child" data-filter-tags="utilities menu child">
                            <span class="nav-link-text" data-i18n="nav.utilities_menu_child">Sub-category</span>
                        </a>
                        <ul>
                            <li>
                                <a href="javascript:void(0);" title="Sublevel Item" data-filter-tags="utilities menu child sublevel item">
                                    <span class="nav-link-text" data-i18n="nav.utilities_menu_child_sublevel_item">Sublevel Item</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" title="Another Item" data-filter-tags="utilities menu child another item">
                                    <span class="nav-link-text" data-i18n="nav.utilities_menu_child_another_item">Another Item</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="disabled">
                        <a href="javascript:void(0);" title="Disabled item" data-filter-tags="utilities disabled item">
                            <span class="nav-link-text" data-i18n="nav.utilities_disabled_item">Disabled item</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
            <!-- Example of open and active states -->
            {{-- <li class="active open">
                <a href="#" title="Category" data-filter-tags="category">
                    <i class="fal fa-plus"></i>
                    <span class="nav-link-text" data-i18n="nav.category">Open Item</span>
                </a>
                <ul>
                    <li class="active open">
                        <a href="javascript:void(0);" title="Menu child" data-filter-tags="utilities menu child">
                            <span class="nav-link-text" data-i18n="nav.utilities_menu_child">Open Sub-category</span>
                        </a>
                        <ul>
                            <li class="active">
                                <a href="javascript:void(0);" title="Sublevel Item" data-filter-tags="utilities menu child sublevel item">
                                    <span class="nav-link-text" data-i18n="nav.utilities_menu_child_sublevel_item">Active Item</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> --}}
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    {{-- <div class="nav-footer shadow-top">
        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
            <i class="ni ni-chevron-right"></i>
            <i class="ni ni-chevron-right"></i>
        </a>
        <ul class="list-table m-auto nav-footer-buttons">
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Chat logs">
                    <i class="fal fa-comments"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Support Chat">
                    <i class="fal fa-life-ring"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
                    <i class="fal fa-phone"></i>
                </a>
            </li>
        </ul>
    </div> <!-- END NAV FOOTER --> --}}
</aside>
  <!-- END Left Aside -->