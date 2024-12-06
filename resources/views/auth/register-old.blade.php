<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Nama Perusahaan')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email Yang Aktif')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            {{-- no_telp --}}
            <div class="mt-4">
                <x-label for="no_telp" :value="__('No. telepon Yang Aktif')" />

                <x-input id="no_telp" class="block mt-1 w-full" type="text" name="no_telp" :value="old('no_telp')" required />
            </div>
            {{-- Alamat --}}
            <div class="mt-4">
                <x-label for="no_telp" :value="__('Alamat')" />

                <x-input id="no_telp" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>
                    <div class="mt-4">
                        <select class="form-control select2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" name="kategori_npa" id="kategori_npa">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori_npas as $kategori_npa)
                                <option value="{{ $kategori_npa->id }}">{{ $kategori_npa->kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4">
                        <select class="form-control select2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" name="upt_daerah" id="upt_daerah">
                            <option value="">-- Pilih Wilayah --</option>
                            @foreach ($upt_daerahs as $upt_daerah)
                                <option value="{{ $upt_daerah->id }}">{{ $upt_daerah->nama_daerah }}</option>
                            @endforeach
                        </select>
                    </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah Daftar?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Daftar') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
