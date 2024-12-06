<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Daftar - PAP</title>
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

</head>

<body>

    <!-- END HOME -->
    <section class="bg-home" id="home" style="min-height: 100vh; padding: 30px 0 80px 0;">
        <div class="bg-overlay"></div>

        <div class="container slidero">
            <div class="row align-items-center">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                    <div class="home-registration-form bg-white p-5 mt-5">
                        <div class="text-center">
                            <img src="../assets/logo kaltim.png" alt="" height="120px">
                            <h5>Aplikasi Elektronik Pajak Air Permukaan</h5>
                        </div>
                        <x-auth-validation-errors class="my-3 text-danger" :errors="$errors" />
                        <form class="registration-form" action="{{ route('register') }}" method="POST">
                            @csrf

                            <label class="text-muted">Nama Perusahaan</label>
                            <input type="text" id="email" name="name"
                                class="form-control mb-3" required autofocus value="{{ old('name') }}">

                            <label class="text-muted">Email yang aktif</label>
                            <input type="email" id="email" name="email"
                                class="form-control mb-3" required value="{{ old('email') }}">

                            <label class="text-muted">No. Telepon yang aktif</label>
                            <input type="text" id="no_telp" name="no_telp"
                                class="form-control mb-3" required value="{{ old('no_telp') }}">

                            <label class="text-muted">Alamat</label>
                            <input type="text" id="email" name="alamat"
                                class="form-control mb-3" required value="{{ old('alamat') }}">

                            <label class="text-muted">Pemakaian Penggunaan Air Untuk Apa?</label>
                            <textarea name="alasan" id="" cols="30" rows="10" class="form-control mb-3"></textarea>

                                <label class="text-muted">Mulai mengunakan dan / memanfaatkan air permukaan</label>
                                <div class="d-flex">
                                    <select class="form-control mb-3 mx-3" name="date" id="date">
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach ($dates as $date)
                                            <option value="{{ $date }}">{{ $date }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control mb-3 mx-3" name="year" id="date">
                                        <option value="">-- Pilih Tahun --</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <label class="text-muted">Password</label>
                            <input type="password" id="password" name="password" class="form-control mb-3" required autocomplete="new-password">

                            <label class="text-muted">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control mb-3" required>

                            {{-- <select class="form-control mb-3 kategori" name="kategori_npa" id="kategori_npa">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori_npas as $kategori_npa)
                                    <option value="{{ $kategori_npa->id }}">{{ $kategori_npa->kategori }}</option>
                                @endforeach
                            </select>
                            <div class="container2" id="container2">
                                <label for="text-muted">Keterangan Kategori</label>
                                <h6 id="keterangan_text-alt">-</h6>
                                <h6 id="keterangan_text" hidden="true"></h6>
                            </div> --}}
                            <select class="form-control mb-3" name="upt_daerah" id="upt_daerah">
                                <option value="">-- Pilih Wilayah --</option>
                                @foreach ($upt_daerahs as $upt_daerah)
                                    <option value="{{ $upt_daerah->id }}">{{ $upt_daerah->nama_daerah }}</option>
                                @endforeach
                            </select>

                            <button class="btn btn-primary w-100" type="submit">Daftar</button>
                            <!-- register -->
                            <div class="mt-3">
                                <a href="{{ route('login') }}" class="text-muted">Sudah Daftar?</a>
                            </div>
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
    <script src="{{ asset('assets_login/js/particles.js') }}"></script>
    <script src="{{ asset('assets_login/js/particles.app.js') }}"></script>
    <script src="{{ asset('assets_login/js/jquery.mb.YTPlayer.js') }}"></script>
    <!--flex slider plugin-->
    <script src="{{ asset('assets_login/js/jquery.flexslider-min.js') }}"></script>
    <!-- counter init -->
    <script src="{{ asset('assets_login/js/counter.init.js') }}"></script>
    <!-- contact init -->
    <script src="{{ asset('assets_login/js/contact.init.js') }}"></script>
    <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
    <script src="{{ asset('assets_login/js/app.js') }}"></script>

    <script>
        let kategori = document.querySelector(".kategori");
        let kategori_npas = @json($kategori_npas);
        console.log(kategori_npas);
        kategori.addEventListener("change", (e) => {
            const h6 = document.querySelector("#keterangan_text");
            const text_alt = document.querySelector("#keterangan_text-alt")
            const container = document.querySelector("#container2");
            for(i = 0; i < kategori_npas.length; i++){
                if(kategori_npas[i].id == kategori.value){
                    if(kategori_npas[i].keterangan){
                        h6.innerText = kategori_npas[i].keterangan;
                        text_alt.hidden = true;
                        h6.hidden = false; 
                        break;
                    } else {
                        text_alt.hidden = false;
                        h6.hidden = true;
                    }
                }
            }
        })
    </script>
</body>

</html>
