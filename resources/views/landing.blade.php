<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8" />
    <title>PMB Politeknik Negeri Banyuwangi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pendaftaran Mahasiswa Baru Politeknik Negeri Banyuwangi" name="description" />
    <meta content="Poliwangi" name="author" />
    
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        :root {
            --primary-color: #0056b3; /* Biru Poliwangi */
            --warning-color: #ffc107; /* Kuning/Warning untuk CTA */
        }
        
        .navbar {
            /* Membuat Navbar sedikit transparan dengan blur */
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(8px);
            transition: all 0.3s ease-in-out;
        }

        .hero-section {
            padding-top: 100px;
            padding-bottom: 70px;
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
            background-color: #f7f9fc; 
        }

        /* Card untuk Gelombang Pendaftaran (Horizontal/Modern) */
        .gelombang-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-left: 5px solid var(--primary-color); 
            margin-bottom: 20px;
            cursor: pointer;
        }

        .gelombang-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            font-size: 0.8em;
            padding: 5px 10px;
            border-radius: 50px;
        }
        
        /* Tambahan untuk tata cara (FAQ style) */
        .custom-accordion-border .accordion-button:not(.collapsed) {
            color: var(--primary-color);
            background-color: #eaf1fa;
            border-color: var(--primary-color);
        }
       .section {
        /* Tambahkan padding di bagian atas setiap section */
        padding-top: 50px !important; 
    }

    /* Mengganti ID target agar berada 80px di atas visual section */
    .section[id] {
        padding-top: 80px !important; /* Jarak agar konten di bawah navbar */
        margin-top: -80px !important; /* Tarik section ke atas untuk scrollspy */
    }

    /* Kecualikan Hero section agar tidak double padding */
    #hero {
        padding-top: 100px !important; /* Gunakan padding default yang tinggi */
        margin-top: 0 !important;
    }
    
    /* Perbaikan kecil pada navbar agar lebih solid */
    .navbar {
        min-height: 70px; /* Tambahkan sedikit tinggi agar offset stabil */
        background: rgba(255, 255, 255, 0.98) !important; 
        backdrop-filter: blur(8px);
    }
    }
    </style>

</head>

<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="0" tabindex="0">

    <div class="layout-wrapper landing">
        
        <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="assets/images/logo-dark.svg" class="card-logo card-logo-dark" alt="logo dark" height="40">
                </a>
                <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                        <li class="nav-item">
                            <a class="nav-link active" href="#hero">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#layanan">Gelombang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#alurpendaftaran">Alur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tata_cara">Tata Cara</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pendaftaran">Daftar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pengumuman">Pengumuman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tentang">Tentang</a>
                        </li>
                    </ul>

                    <div class="">
                        <a href="#pendaftaran" class="btn btn-warning shadow-sm me-2 fw-bold">Daftar PMB</a>
                        <a href="{{ url('login') }}" class="btn btn-outline-primary">Sign In</a>
                    </div>
                </div>

            </div>
        </nav>
        <section class="section hero-section" id="hero">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row align-items-center">
                    
                    <div class="col-lg-7 col-sm-12">
                        <div class="mt-lg-5 pt-5 text-center text-lg-start">
                            <h1 class="display-5 fw-bold mb-3 lh-base text-primary">
                                Pendaftaran Mahasiswa Baru 
                                <span class="d-block text-danger">POLITEKNIK NEGERI BANYUWANGI</span>
                            </h1>
                            <p class="lead text-muted mb-4">
                                Wujudkan karir cemerlang di industri. Kuliah Vokasi: Lulus Cepat, Siap Kerja!
                            </p>
                            
                            <a href="#layanan" class="btn btn-primary btn-lg shadow-sm">
                                Cek Gelombang Aktif <i class="ri-arrow-right-line align-middle ms-1"></i>
                            </a>
                            <a href="https://www.youtube.com/embed/bnbKP_R8uDg?autoplay=1&controls=0&start=0&end=0&modestbranding=1&wmode=transparent&enablejsapi=1&loop=1&rel=0&mute=1&playlist=bnbKP_R8uDg"
                                class="btn btn-link text-danger ms-2">
                                <i class="ri-play-circle-line me-1"></i> Lihat Video
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-5 col-sm-12 mt-4 mt-lg-0">
                        <div class="card shadow-lg p-3 border-0">
                            <div class="text-center mb-3">
                                <h5 class="fw-bold text-primary">Daftar Cepat</h5>
                            </div>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <input name="nama" type="text" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="mb-3">
                                    <input name="email" type="email" class="form-control" placeholder="Email Aktif" required>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="gelombang" id="gelombang_hero" required>
                                        <option value="" selected disabled>Pilih Gelombang Pendaftaran</option>
                                        @forelse($gelombang as $h)
                                            @if(strtolower(trim($h->status)) == 'active')
                                                <option value="{{ $h->id }}">{{ $h->nama_gelombang }}</option>
                                            @endif
                                        @empty
                                            <option disabled>Tidak ada gelombang aktif</option>
                                        @endforelse
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning w-100 fw-bold">LANJUTKAN PENDAFTARAN</button>
                            </form>
                            <small class="text-center text-muted mt-2">Daftar sekarang, lengkapi data nanti.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                        <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z"></path>
                    </g>
                </svg>
            </div>
        </section>
        <section class="section pt-5" id="layanan">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 ff-secondary fw-semibold lh-base text-primary">Gelombang Pendaftaran Aktif</h3>
                            <p class="text-muted">Poliwangi memegang teguh keyakinan bahwa kolaborasi penting dalam proses pembelajaran.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        @forelse ($gelombang as $h)
                        <div class='card gelombang-card shadow-sm'>
                            <div class="card-body d-md-flex align-items-center justify-content-between py-4 px-4">
                                <div class="flex-grow-1 me-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-calendar-event-line fs-4 me-2 text-primary"></i>
                                        <h4 class="card-title mb-0 fw-bold">
                                            {{ Str::upper($h->nama_gelombang) }}
                                        </h4>
                                        @if (strtolower(trim($h->status)) == 'active')
                                        <span class="badge bg-success ms-3 status-badge">
                                            {{ $h->status }}
                                        </span>
                                        @else
                                        <span class="badge bg-danger ms-3 status-badge">
                                            {{ $h->status }}
                                        </span>
                                        @endif
                                    </div>
                                    <h6 class="card-subtitle text-muted mb-2">{{ $h->tahun_ajaran }}</h6>
                                    <p class="card-text text-muted mb-md-0">
                                        <i class="ri-time-line me-1"></i>
                                        **Periode:** {{ Carbon\Carbon::parse($h->tanggal_mulai)->format('d M Y') . ' - ' . Carbon\Carbon::parse($h->tanggal_selesai)->format('d M Y') }}
                                    </p>
                                </div>
                                
                                <div class="flex-shrink-0 text-md-end mt-3 mt-md-0">
                                    @if (strtolower(trim($h->status)) == 'active')
                                    <a href="#pendaftaran" class="btn btn-primary shadow" 
                                        onclick="document.getElementById('gelombang').value='{{ $h->id }}'; document.getElementById('gelombang_hero').value='{{ $h->id }}';">
                                        Daftar Sekarang <i class="ri-arrow-right-line align-middle ms-1"></i>
                                    </a>
                                    @else
                                    <button class="btn btn-secondary" disabled>Telah Ditutup</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-info text-center">
                            Saat ini tidak ada gelombang pendaftaran yang aktif.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            </section>
        <section class="section py-5 bg-light" id="alurpendaftaran">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">Alur Pendaftaran</h3>
                            @if($alurPendaftaran)
                            <p class="text-muted mb-4 ff-secondary">{{ $alurPendaftaran->keterangan }}</p>
                            <img src="{{ asset('storage/' . $alurPendaftaran->gambar) }}" alt="alur pendaftaran"
                                class="img-fluid rounded shadow-lg">
                            @else
                            <p class="text-muted mb-4 ff-secondary">Gambar atau informasi alur pendaftaran tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-10">
                        <div class="text-center mb-4">
                            <h4 class="fw-semibold text-primary">Tanggal Penting Pendaftaran</h4>
                        </div>
                        @if($tanggal_penting->isEmpty())
                        <div class="alert alert-warning text-center">
                            Tanggal penting pendaftaran masih belum ada.
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-start">Nama Kegiatan</th>
                                        <th class="text-center">Tanggal Mulai</th>
                                        <th class="text-center">Tanggal Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tanggal_penting as $key => $item)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-start">{{ $item->nama_kegiatan }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') : '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
                </div>
        </section>
        <section class="section" id="tata_cara">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">Tata Cara Pendaftaran</h3>
                            <p class="text-muted mb-4 ff-secondary">Bacalah langkah-langkah penting sebelum mendaftar.</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 me-1">
                                <i class="ri-question-line fs-24 align-middle text-primary me-1"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fw-semibold text-dark">Langkah-langkah Pendaftaran</h5>
                            </div>
                        </div>
                        <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box" id="genques-accordion">
                            @forelse ($tata_cara as $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ 'collapse-header-' . $loop->iteration }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#{{ 'collapse-' . $loop->iteration }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                        aria-controls="{{ 'collapse-' . $loop->iteration }}">
                                        {{ $loop->iteration . '. ' . $item->title }}
                                    </button>
                                </h2>
                                <div id="{{ 'collapse-' . $loop->iteration }}"
                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                    aria-labelledby="{{ 'collapse-header-' . $loop->iteration }}"
                                    data-bs-parent="#genques-accordion">
                                    <div class="accordion-body ff-secondary">
                                        {!! $item->deskripsi !!}
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="alert alert-info text-center">
                                Tata cara pendaftaran sedang disusun. Silahkan cek berkala.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            </section>
        <section class="section bg-light" id="pendaftaran">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">Formulir Pendaftaran Lengkap</h3>
                            <p class="text-muted mb-4 ff-secondary">Silahkan mengisi form pendaftaran dibawah ini dengan data yang sebenar-benarnya untuk mendapatkan Virtual Account.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card p-4 shadow">
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <h5 class="mb-4 text-primary">Data Diri Calon Mahasiswa</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="nama" class="form-label fs-13">Nama Lengkap</label>
                                            <input name="nama" id="nama" type="text" class="form-control" placeholder="Masukkan Nama" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="email" class="form-label fs-13">Email Aktif</label>
                                            <input name="email" id="email" type="email" class="form-control" placeholder="Masukkan Email" required>
                                            <small class="form-text text-success"> *Kode VA akan dikirim ke email ini.</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="nik" class="form-label fs-13">NIK (Nomor Induk Kependudukan)</label>
                                            <input name="nik" id="nik" type="number" class="form-control" placeholder="Masukkan NIK" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="no_hp" class="form-label fs-13">No HP/WhatsApp</label>
                                            <input name="no_hp" id="no_hp" type="number" class="form-control" placeholder="Masukkan No HP" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <label for="sekolah" class="form-label fs-13">Asal Sekolah</label>
                                            <input type="text" class="form-control" placeholder="Masukkan Asal Sekolah" id="sekolah" name="sekolah" required/>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mb-4 mt-3 text-primary">Pilihan Pendaftaran</h5>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <label for="gelombang" class="form-label fs-13">Gelombang Pendaftaran</label>
                                            <select class="form-select" name="gelombang" id="gelombang" required>
                                                <option value="" selected disabled>Pilih Gelombang Pendaftaran</option>
                                                @forelse($gelombang as $h)
                                                @if(strtolower(trim($h->status)) == 'active')
                                                <option value="{{ $h->id }}">{{ $h->nama_gelombang }} - {{ Carbon\Carbon::parse($h->tanggal_mulai)->format('d/m') . ' s.d. ' . Carbon\Carbon::parse($h->tanggal_selesai)->format('d/m') }}</option>
                                                @endif
                                                @empty
                                                <option disabled>Tidak ada gelombang aktif</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label for="prodi" class="form-label fs-12">Pilihan Program Studi 1</label>
                                            <select class="form-select" name="program_studi" id="prodi">
                                                <option selected disabled>Pilih Program Studi</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label for="programStudi2" class="form-label fs-12">Pilihan Program Studi 2</label>
                                            <select class="form-select" name="program_studi_2" id="programStudi2">
                                                <option value="" selected>Pilih Program Studi (Opsional)</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label for="prodiLain" class="form-label fs-12">Pilihan Program Studi Lain</label>
                                            <select class="form-select" name="prodi_lain" id="prodiLain">
                                                <option value="">Pilih Program Studi Lain (Opsional)</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                        <a data-bs-toggle="modal" data-bs-target="#forgetcode" class="btn btn-outline-warning">Lupa Kode Virtual Account?</a>
                                        <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary btn-lg px-5" value="DAFTAR & DAPATKAN VA">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </section>
        <section class="section bg-primary" id="pengumuman">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="text-center text-white mb-5">
                            <i class="ri-megaphone-line display-4"></i>
                            <h4 class="mt-2 text-white">Pengumuman Terbaru</h4>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        @forelse ($pengumuman as $item)
                        <div class="col-sm-6 col-xl-4 mb-4">
                            <div class="card shadow h-100">
                                <img class="card-img-top img-fluid" src="{{ URL::asset('assets/images/small/img-2.jpg') }}" alt="Card image cap">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-2 text-dark">{{ $item->judul_pengumuman }}</h5>
                                    <p class="card-text mb-3 fs-6 flex-grow-1">
                                        {!! Str::limit(strip_tags($item->isi_pengumuman), 100) !!}
                                    </p>
                                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                        <small class="text-muted"><i class="ri-calendar-line me-1"></i>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</small>
                                        <a href="{{ url('pengumuman/' . $item->id) }}" class="card-link link-primary fw-bold">Baca Selengkapnya <i class="ri-arrow-right-s-line ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-lg-8">
                             <div class="alert alert-light text-center">
                                 Belum ada pengumuman terbaru saat ini.
                             </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            </section>
        <section class="section" id="tentang">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">Mengapa Bergabung dengan Poliwangi?</h3>
                            <p class="text-muted mb-4 ff-secondary">Dengan arsitektur pembelajaran giat Poliwangi, kami membangun dan membina bangunan pembelajaran universitas yang kedepannya dapat membantu memperkuat berbasis ilmu pengetahuan bisnis di Indonesia.</p>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-4">
                        <div class="process-card mt-4">
                            <div class="process-arrow-img d-none d-lg-block">
                                <img src="assets/images/landing/process-arrow-img.svg" alt="" class="img-fluid">
                            </div>
                            <div class="avatar-sm icon-effect mx-auto mb-4">
                                <div class="avatar-title bg-soft-primary text-primary rounded-circle h1">
                                    <i class="ri-quill-pen-line"></i>
                                </div>
                            </div>
                            <h5>Kegiatan Belajar Mengajar yang baik</h5>
                            <p class="text-muted ff-secondary">Diampu langsung oleh tenaga pendidik dan tenaga operasional yang profesional dan ahli di bidangnya masing masing.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="process-card mt-4">
                            <div class="process-arrow-img d-none d-lg-block">
                                <img src="assets/images/landing/process-arrow-img.svg" alt="" class="img-fluid">
                            </div>
                            <div class="avatar-sm icon-effect mx-auto mb-4">
                                <div class="avatar-title bg-soft-warning text-warning rounded-circle h1">
                                    <i class="ri-group-line"></i>
                                </div>
                            </div>
                            <h5>Kerja Sama Industri Luas</h5>
                            <p class="text-muted ff-secondary">Memiliki jejaring kerjasama yang luas dengan berbagai perusahaan nasional dan multinasional untuk penempatan magang dan karir.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="process-card mt-4">
                            <div class="avatar-sm icon-effect mx-auto mb-4">
                                <div class="avatar-title bg-soft-danger text-danger rounded-circle h1">
                                    <i class="ri-graduation-cap-line"></i>
                                </div>
                            </div>
                            <h5>Fokus Vokasi (Siap Kerja)</h5>
                            <p class="text-muted ff-secondary">Pendidikan yang fokus pada keterampilan praktis, memastikan lulusan siap kerja dan dibutuhkan di dunia industri.</p>
                        </div>
                    </div>
                    </div>
                </div>
            </section>
        <div class="modal fade" id="forgetcode" tabindex="-1" aria-labelledby="forgetcodeLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgetcodeLabel">Lupa Kode Virtual Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Masukkan Email yang Anda gunakan saat pendaftaran untuk mendapatkan kembali Kode Virtual Account Anda.</p>
                        <form action="/lupa-va" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="recovery-email" class="form-label">Email Pendaftaran</label>
                                <input type="email" class="form-control" id="recovery-email" name="email" placeholder="Masukkan email Anda" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim Ulang Kode VA</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-dark py-4">
            <div class="container text-center text-white-50">
                <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> PMB Politeknik Negeri Banyuwangi. All rights reserved.</p>
            </div>
        </footer>

    </div>
    <script>
        function show(id) {
            // Logika untuk menampilkan deskripsi penuh (tidak digunakan di layout baru ini)
            // Namun, jika ingin mempertahankannya:
            // document.getElementById('card-text' + id).style.display = 'none';
            // document.getElementById('more' + id).style.display = 'block';
            // document.getElementById('close' + id).style.display = 'inline-block';
            // event.target.style.display = 'none'; // Sembunyikan 'Read More'
            
            // Karena menggunakan Horizontal Card, fungsi ini mungkin tidak lagi relevan kecuali untuk Read More yang terpisah.
        }

        function hide(id) {
            // Logika untuk menyembunyikan deskripsi penuh
            // document.getElementById('card-text' + id).style.display = 'block';
            // document.getElementById('more' + id).style.display = 'none';
            // document.getElementById('close' + id).style.display = 'none';
            // document.querySelector('#layanan .card-footer a[onclick="show(\'' + id + '\')"]').style.display = 'inline-block';
        }
        
        function daftar(id) {
            // Fungsi untuk mengarahkan pilihan gelombang di form pendaftaran
            document.getElementById('gelombang').value = id;
            document.getElementById('gelombang_hero').value = id;
        }

        // Contoh inisialisasi Swiper/Carousel jika diperlukan
        // var swiper = new Swiper(".demo-carousel", { 
        //     loop: true, 
        //     autoplay: { delay: 2000 },
        // });
    </script>

</body>

</html>