<main>

    <div id="main-wrapper" class=" flex p-5 xl:pr-0">
        <aside id="application-sidebar-brand"
            class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full  transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed xl:top-5 xl:left-auto top-0 left-0 with-vertical h-screen z-[999] shrink-0  w-[270px] shadow-md xl:rounded-md rounded-none bg-white left-sidebar   transition-all duration-300">

            <div class="p-4">

                <div class="flex justify-center items-center h-full">
                    <div class="flex justify-center items-center h-full">
                        <img src="{{ asset('img/Artboard.png') }}" alt="Stunting Check Logo" class="h-10 w-auto">
                    </div>
                </div>


            </div>
            <div class="scroll-sidebar" data-simplebar="">
                <nav class=" w-full flex flex-col sidebar-nav px-4 mt-5">
                    <ul id="sidebarnav" class="text-gray-600 text-sm">
                        <li class="text-xs font-bold pb-[5px]">
                            <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                            <span class="text-xs text-gray-400 font-semibold">HOME</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-green-700  w-full"
                                href="{{ route('dashboard') }}">
                                <i class="ti ti-layout-dashboard ps-2  text-2xl"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="text-xs font-bold mb-4 mt-6">
                            <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                            <span class="text-xs text-gray-400 font-semibold">DATA STUNTING</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2.5 my-1 text-base   flex items-center relative  rounded-md text-green-700  w-full"
                                href="{{ route('status.index') }}">
                                <i class="ti ti-activity ps-2 text-2xl"></i> <span>Status</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2.5 my-1 text-base   flex items-center relative  rounded-md text-green-700  w-full"
                                href="{{ route('article.index') }}">
                                <i class="ti ti-file-description ps-2 text-2xl"></i> <span>Article</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2.5 my-1 text-base   flex items-center relative  rounded-md text-green-700  w-full"
                                href="{{ route('message.index') }}">
                                <i class="ti ti-mail-forward ps-2 text-2xl"></i> <span>Message</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link gap-3 py-2.5 my-1 text-base   flex items-center relative  rounded-md text-green-700  w-full"
                                href="{{ route('faq.index') }}">
                                <i class="ti ti-zoom-question ps-2 text-2xl"></i> <span>FAQ</span>
                            </a>
                        </li>



                        @role('superadmin')
                            <li class="text-xs font-bold mb-4 mt-8">
                                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                                <span class="text-xs text-gray-400 font-semibold">PERMISSION</span>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link gap-3 py-2.5 my-1 text-base   flex items-center relative  rounded-md text-green-700  w-full"
                                    href="{{ route('admin.user.index') }}">
                                    <i class="ti ti-user-plus ps-2 text-2xl"></i> <span>User</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link gap-3 py-2.5 my-1 text-base   flex items-center relative  rounded-md text-green-700  w-full"
                                    href="{{ route('admin.permission.index') }}">
                                    <i class="ti ti-lock-plus ps-2 text-2xl"></i> <span>Permission</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link gap-3 py-2.5 my-1 text-base   flex items-center relative  rounded-md text-green-700  w-full"
                                    href="{{ route('admin.role.index') }}">
                                    <i class="ti ti-user-check ps-2 text-2xl"></i> <span>Role</span>
                                </a>
                            </li>
                        @endrole

                    </ul>
                </nav>
            </div>
            <!-- </aside> -->
        </aside>
        <div class=" w-full page-wrapper xl:px-6 px-0">

            <!-- Main Content -->
            <main class="h-full  max-w-full">
                <div class="container full-container p-0 flex flex-col gap-6">
                    <!--  Header Start -->
                    <header class=" bg-white shadow-md rounded-md w-full text-sm py-4 px-6">


                        <!-- ========== HEADER ========== -->

                        <nav class=" w-ful flex items-center justify-between" aria-label="Global">
                            <ul class="icon-nav flex items-center gap-4">
                                <li class="relative xl:hidden">
                                    <a class="text-xl  icon-hover cursor-pointer text-heading" id="headerCollapse"
                                        data-hs-overlay="#application-sidebar-brand"
                                        aria-controls="application-sidebar-brand" aria-label="Toggle navigation"
                                        href="javascript:void(0)">
                                        <i class="ti ti-menu-2 relative z-1"></i>
                                    </a>
                                </li>

                                <li class="relative">

                                    <div
                                        class="hs-dropdown relative inline-flex [--placement:bottom-left] sm:[--trigger:hover]">
                                        <a class="relative hs-dropdown-toggle inline-flex hover:text-gray-500 text-gray-300"
                                            href="#">
                                            <i class="ti ti-bell-ringing text-xl relative z-[1]"></i>
                                            <div
                                                class="absolute inline-flex items-center justify-center  text-white text-[11px] font-medium  bg-blue-600 w-2 h-2 rounded-full -top-[1px] -right-[6px]">
                                            </div>
                                        </a>
                                        <div class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[300px] hidden z-[12]"
                                            aria-labelledby="hs-dropdown-custom-icon-trigger">
                                            <div>
                                                <h3 class="text-gray-500 font-semibold text-base px-6 py-3">
                                                    Notification
                                                </h3>
                                                <ul class="list-none flex flex-col">
                                                    @if (auth()->check())
                                                        <li>
                                                            <a href="#" class="py-3 px-6 block hover:bg-gray-200">
                                                                <p class="text-sm text-gray-500 font-medium">
                                                                    Anda login sebagai
                                                                    {{ auth()->user()->roles->first()->display_name }}
                                                                </p>
                                                                <p class="text-xs text-gray-400 font-medium">
                                                                    Congratulate {{ auth()->user()->name }}
                                                                </p>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="#" class="py-3 px-6 block hover:bg-gray-200">
                                                                <p class="text-sm text-gray-500 font-medium">
                                                                    Anda belum login.
                                                                </p>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>

                                            </div>

                                        </div>
                                    </div>

                                </li>
                            </ul>
                            <div class="flex items-center gap-4">
                                <div
                                    class="hs-dropdown relative inline-flex [--placement:bottom-right] sm:[--trigger:hover]">
                                    <a class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
                                        <img class="object-cover w-9 h-9 rounded-full"
                                            src="{{ auth()->check() && auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('./img/default-avatar.jpeg') }}"
                                            alt="User Avatar" aria-hidden="true">


                                    </a>
                                    <div class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max  w-[200px] hidden z-[12]"
                                        aria-labelledby="hs-dropdown-custom-icon-trigger">
                                        <div class="card-body p-0 py-2">
                                            <a href="{{ route('profile.edit') }}"
                                                class="flex gap-2 items-center font-medium px-4 py-1.5 hover:bg-gray-200 text-gray-400">
                                                <i class="ti ti-user text-xl"></i>
                                                <p class="text-sm">My Profile</p>
                                            </a>

                                            <div class="px-4 mt-[7px] grid">
                                                <form method="POST" action="{{ route('logout') }}" id="logout-form"
                                                    style="display: none;">
                                                    @csrf
                                                </form>

                                                <a href="#"
                                                    class="btn-outline-primary font-medium text-[15px] w-full hover:bg-blue-600 hover:text-white"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>
                                            </div>


                                        </div>
                                    </div>
                                </div>


                            </div>
                        </nav>


                    </header>
                    <!--  Header End -->
