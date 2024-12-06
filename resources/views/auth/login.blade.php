<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dinkes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets_login/images/favicon.ico') }}">
    <!-- css -->
    <link href="{{ asset('assets_login/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets_login/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- magnific pop-up -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/css/magnific-popup.css') }}" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('assets_login/css/swiper.min.css') }}">

    <!--Slider-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/css/owl.carousel.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/css/owl.theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/css/owl.transitions.css') }}" />
    <link href="{{ asset('assets_login/css/style.css') }}" rel="stylesheet" type="text/css" />
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>


    <!-- END HOME -->
    <section class="bg-home" id="home" style="min-height: 100vh; padding: 30px 0 80px 0;">
        <div class="container slidero position-relative">
            @if(session()->has('success'))
        <div x-data="{show: true}" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="container p-5 position-absolute start-50" style="z-index: 9999">
            <div class="row no-gutters">
                <div class="col-lg-6 col-md-12 m-auto">
                    <div class="alert alert-success fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="True">&times;</span>
                          </button>
                         <h4 class="alert-heading">Success!</h4>
                          <p>{{session('success')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
            <div class="row align-items-center">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                    <div class="home-registration-form bg-white p-5 mt-5">
                        <div class="text-center">
                            <img src="../assets/Lambang_Kabupaten_Kutai_Timur.png" alt="" height="120px">
                            <h5>Pemerintah Kutai Timur</h5>
                        </div>
                        <x-auth-validation-errors class="my-3 text-danger" :errors="$errors" />
                        <form class="registration-form" action="{{ route('login') }}" method="POST">
                            @csrf
                            <label class="text-muted">username</label>
                            {{-- value old email --}}

                            <input type="text" id="username" name="username"
                                class="form-control mb-3" required autofocus value="{{ old('email') }}">
                            <label class="text-muted">Password</label>
                            <input type="password" id="password" name="password" class="form-control mb-3" required autocomplete="current-password">
                            
                            <label class="text-muted">Filter Tahun</label>
                            <select name="tahun" id="tahun" class="form-control mb-3">
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>

                            <!-- remember me -->
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                                <label class="custom-control-label" for="remember_me">Ingat Saya</label>
                            </div>
                            <button class="btn w-100" style=" background: linear-gradient(to top, #4fffa4, #61ffa5); border-radius: 10px" type="submit">Login</button>
                            <!-- register -->
                        </form>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>
    </section>
    <!-- END HOME -->


    <!-- javascript -->
    <script src="{{ asset('assets_login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_login/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_login/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets_login/js/scrollspy.min.js') }}"></script>
    <!-- olw- carousel -->
    <script src="{{ asset('assets_login/js/owl.carousel.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('assets_login/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- swipper js -->
    <script src="{{ asset('assets_login/js/swiper.min.js') }}"></script>
    <!--Partical js-->
    {{-- <script src="{{ asset('assets_login/js/particles.js') }}"></script>
    <script src="{{ asset('assets_login/js/particles.app.js') }}"></script>
    <script src="{{ asset('assets_login/js/jquery.mb.YTPlayer.js') }}"></script> --}}
    <!--flex slider plugin-->
    <script src="{{ asset('assets_login/js/jquery.flexslider-min.js') }}"></script>
    <!-- counter init -->
    <script src="{{ asset('assets_login/js/counter.init.js') }}"></script>
    <!-- contact init -->
    <script src="{{ asset('assets_login/js/contact.init.js') }}"></script>
    <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
    <script src="{{ asset('assets_login/js/app.js') }}"></script>

</body>

</html>
