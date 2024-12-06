<div class="block lg:flex">
    <div class="flex-none bg-indigo-500">
        <div class="mx-20 flex flex-col items-center min-h-screen items-center justify-center text-white">
            <div>
                <div class="my-10 font-bold text-5xl">
                    <img src="{{asset('assets/images/users/e-pap2-01.jpg')}}"" class="w-5" style="width: 200px"/>
                </div>
                <div>
                    <p>
                        Perangkat Lunak berbasis web yang<br>digunakan sebagai sarana pendukung<br>layanan Pajak Air Permukaan (PAP) dan<br>diakses melalui jaringan internet.
                    </p>
                </div>
            </div>
            
        </div>
        </div>
    <div class="flex-1 m-0 position-relative">
    <img src="{{asset('assets/images/users/bg-dark.jpeg')}}"" class="w-100 h-100 position-absolute bottom-0 end-0" style=""/>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="font-bold text-3xl" style="z-index: 99999; color: white">
                Login
            </div>
            <div class="my-5" style="z-index: 99999; color: white">
                Silakan Login untuk mulai menggunakan semua fitur aplikasi ini.
            </div>
            {{-- <div>
                {{ $logo }}
            </div> --}}
        
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" style="z-index: 99999">
                {{ $slot }}
            </div>
        </div>
    </div>
    
    
</div>

