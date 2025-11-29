@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.signin')
@endsection
@section('content')
    <div class="auth-page-wrapper pt-5" style="background: linear-gradient(145deg, #1f4287 0%, #3e64ff 100%);  min-height: 100vh; 
background-blend-mode: multiply; /* Memadukan pola dengan warna gradien */">

        <div class="auth-page-content d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white">
                            <div>
                                <a href="index" class="d-inline-block auth-logo">
                                    {{-- Sesuaikan ukuran logo di sini --}}
                                    <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="85">
                                </a>
                            </div>
                            <h1 class="mt-3 display-6 fw-bold text-white">PMB Poliwangi</h1>
                            <p class="fs-16 fw-medium text-white-75">Sistem Pendaftaran Mahasiswa Baru</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-lg border-0 rounded-4"> {{-- Card lebih rounded dan shadow lebih kuat --}}
                            <div class="card-body p-4 p-md-5">
                                <div class="text-center mb-4">
                                    <h4 class="text-primary fw-bold">Selamat Datang Kembali!</h4>
                                    <p class="text-muted">Masuk untuk melanjutkan ke dashboard PMB.</p>
                                </div>
                                
                                @if(session('loginError'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="ri-error-warning-line me-2"></i> {{ session('loginError') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('login') }}" method="POST" class="mt-4">
                                    @csrf

                                    {{-- Email Input --}}
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                            value="{{ old('email') }}" id="email" name="email" 
                                            placeholder="Masukkan Email" required autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Password Input --}}
                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="{{ route('password.request') }}" class="text-muted fs-13">Lupa Password?</a>
                                        </div>
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-0">
                                            <input type="password"
                                                class="form-control form-control-lg pe-5 @error('password') is-invalid @enderror"
                                                name="password" placeholder="Masukkan password" id="password-input" required>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                                type="button" id="password-addon" onclick="togglePassword()">
                                                <i class="ri-eye-fill align-middle" id="password-icon"></i>
                                            </button>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Gelombang Pendaftaran Dropdown --}}
                                    <div class="mb-4">
                                        <label for="gelombang" class="form-label fs-13">Gelombang Pendaftaran</label>
                                        <select class="form-select form-select-lg @if(Session::has('error_gelombang')) is-invalid @endif" 
                                            aria-label="Gelombang Pendaftaran" name="gelombang" id="gelombang">>
                                            
                                            <option value="" selected disabled>Pilih Gelombang</option>
                                            @php
                                                // Pastikan model sudah di-import di controller atau menggunakan fully qualified name
                                                $gelombang = App\Models\GelombangPendaftaran::get(); 
                                            @endphp
                                            @forelse($gelombang as $h)
                                                <option value="{{ $h->id }}" {{ old('gelombang') == $h->id ? 'selected' : '' }}>
                                                    {{ $h->nama_gelombang }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Tidak ada Gelombang tersedia</option>
                                            @endforelse
                                        </select>
                                        
                                        @if(Session::has('error_gelombang'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ Session::get('error_gelombang') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100 btn-lg" type="submit">
                                            <i class="ri-login-box-line me-1"></i> Masuk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-white-50">&copy; 
                                <script>document.write(new Date().getFullYear())</script> Crafted with <i class="mdi mdi-heart text-danger"></i> by PMB Poliwangi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

@section('script')
    {{-- Hapus particles.js karena kita menggunakan background solid --}}
    {{-- <script src="assets/libs/particles.js/particles.js.min.js"></script> --}}
    {{-- <script src="assets/js/pages/particles.app.js"></script> --}}
    <script>
        // Mempertahankan fungsi togglePassword
        function togglePassword() {
            const passwordInput = document.getElementById('password-input');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('ri-eye-fill');
                passwordIcon.classList.add('ri-eye-close-fill');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('ri-eye-close-fill');
                passwordIcon.classList.add('ri-eye-fill');
            }
        }

        // Script untuk menjaga nilai input (old()) setelah validasi gagal
        document.addEventListener('DOMContentLoaded', function() {
            const oldEmail = "{{ old('email') }}";
            if (oldEmail) {
                document.getElementById('email').value = oldEmail;
            }
        });
    </script>
    {{-- Jika password-addon.init.js berisi fungsi togglePassword, Anda bisa menghapusnya dan gunakan fungsi di atas. --}}
    {{-- <script src="assets/js/pages/password-addon.init.js"></script> --}}
@endsection