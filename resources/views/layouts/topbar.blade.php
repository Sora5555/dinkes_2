<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex" >
            <!-- LOGO -->

            <div class="navbar-brand-box text-center" style="background-color: #23e283 !important;">
                 <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img class="" src="{{asset('assets/images/users/e-pap2-01.jpg')}}"
                        alt="Header Avatar">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/users/e-pap2-01.jpg')}}" alt="logo-dark" height="70" width="100">
                    </span>
                </a> 

                {{-- <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('logo.png')}}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('logo.png')}}" alt="logo-light" height="70" width="100">
                    </span>
                </a> --}}
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn" >
                <i class="ri-menu-2-line align-middle"  style="color:black !important"></i>
            </button>
        </div>
        <select name="tahun" id="tahun" class="form-control mb-3">
            <option value="2023" {{Session::get("year") == 2023?"selected":0}}>2023</option>
            <option value="2024" {{Session::get("year") == 2024?"selected":0}}>2024</option>
        </select>


        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-search-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
        
                    <form class="p-3">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="dropdown d-inline-block">
                {{-- <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                      data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line"  style="color:black !important"></i>
                    <span class="noti-dot"></span>
                </button> --}}
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Terlambat Bayar </h6>
                            </div>
                            {{-- <div class="col-auto">
                                <a href="#!" class="small"> View All</a>
                            </div> --}}
                        </div>
                    </div>
                    <a href="" class="text-reset notification-item" style="display: none;" id="notification-item-empty">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-xs">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="ri-shopping-cart-line"></i>
                                    </span>
                                </div>
                            </div>                                
                            <div class="flex-grow-1">
                                <h6 class="mb-1 nama">Your order is placed</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1 jumlah_pembayaran">If several languages coalesce the grammar</p>
                                    <p class="mb-0 hari"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div style="max-height: 230px;" id="notification-list">
                        
                        {{-- <a href="" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{asset('assets/images/users/avatar-3.jpg')}}" class="rounded-circle avatar-xs" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">It will seem like simplified English.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                            <i class="ri-checkbox-circle-line"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your item is shipped</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{asset('assets/images/users/avatar-4.jpg')}}" class="rounded-circle avatar-xs" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Salena Layfield</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </a> --}}
                    </div>
                    {{-- <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/avatar-2.jpg')}}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->username }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="/profile"><i class="ri-user-line align-middle me-1"></i>Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" onclick="formSubmit()" style="cursor:pointer;"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                    <form method="POST" action="{{ route('user.logout') }}" style="display:none;" id='logoutForm'>
                        @csrf
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-cog"></i>
                </button>
            </div>

        </div>
    </div>
</header>

@push('scripts')
<script>
    function formSubmit(){
        event.preventDefault();
        document.getElementById("logoutForm").submit();
        return false;
    }
</script>
@endpush