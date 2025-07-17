<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Winnicode Garuda Teknologi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('frontend/style/style.css') }}" />
  <!-- <link rel="stylesheet" href="{{ asset('frontend/style/job.css') }}" /> -->
</head>
<body>

  {{-- Notifikasi --}}
  <div id="notif" class="alert alert-success alert-dismissible fade show d-none text-center mb-0 rounded-0" role="alert">
    Akun berhasil dibuat! <a href="profile.html" class="alert-link">Kunjungi Profile</a>.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <div id="notifLamaran" class="alert alert-success alert-dismissible fade show d-none text-center mb-0 rounded-0" role="alert">
    Lamaran berhasil dikirim! <a href="profile.html" class="alert-link">Lihat Status Lamaran</a>.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/">
      <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo PT Winnicode Garuda Teknologi" width="300">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav me-3">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#tentang">Tentang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('jobs.index') ? 'active' : '' }}" href="{{ route('jobs.index') }}">Lihat Lowongan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#footer">Kontak Kami</a>
        </li>
      </ul>

      @guest
      <div id="authMenu" class="d-flex gap-2">
        <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#signupModal">Daftar</button>
        <button class="btn btn-outline-blue" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</button>
      </div>
      @endguest

      @auth
      <div id="profileMenu" class="d-flex align-items-center gap-3">
        <a href="{{ route('profile') }}" class="me-2 text-dark text-decoration-none d-flex align-items-center">
          <i class="bi bi-person-circle me-1 fs-5"></i>
          <span id="navbarUsername" class="fw-semibold">{{ auth()->user()->name }}</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
      </div>
      @endauth
    </div>
  </div>
</nav>
@include('frontend.authmodal')

  {{-- Konten --}}
  @yield('content')

  {{-- Footer --}}
  <footer id="footer" class="footer-section py-5 bg-light">
    <div class="container">
      <div class="row text-start">
        <div class="col-md-4 mb-4">
          <h6 class="fw-bold mb-3">COMPANY</h6>
          <ul class="list-unstyled">
            <li><a href="#cara-kerja" class="text-decoration-none text-dark">Cara Kerja Kami</a></li>
            <li><a href="#hero" class="text-decoration-none text-dark">Beranda</a></li>
            <li><a href="#tentang" class="text-decoration-none text-dark">Tentang Kami</a></li>
            <li><a href="find-job.html" class="text-decoration-none text-dark" id="footerLowongan">Lowongan Aktif</a></li>
            <li><a href="#" class="text-decoration-none text-dark">Privacy & Policy</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-4">
          <h6 class="fw-bold mb-3">TAUTAN</h6>
          <ul class="list-unstyled">
            <li><i class="bi bi-globe2 me-2"></i><a href="https://www.winnicode.com" target="_blank" class="text-decoration-none text-dark">www.winnicode.com</a></li>
            <li><i class="bi bi-instagram me-2"></i><a href="https://instagram.com/winnicode" target="_blank" class="text-decoration-none text-dark">Instagram</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-4">
          <h6 class="fw-bold mb-3">KONTAK KAMI</h6>
          <ul class="list-unstyled text-dark">
            <li><i class="bi bi-envelope me-2"></i><a href="mailto:winnicodegarudaofficial@gmail.com" class="text-decoration-none text-dark">winnicodegarudaofficial@gmail.com</a></li>
            <li><i class="bi bi-geo-alt me-2"></i>Jl. Asia Afrika No.158. Kb. Pisang, Kec. Sumur Bandung, Kota Bandung</li>
            <li><i class="bi bi-telephone me-2"></i>Hubungi: +6285159932501</li>
          </ul>
        </div>
      </div>
      <div class="text-center mt-4">
        <p class="mb-0 small text-muted">&copy; 2025 PT Winnicode Garuda Teknologi.</p>
      </div>
    </div>
  </footer>

  {{-- Script --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('frontend/js/script.js') }}"></script>
  <script src="{{ asset('frontend/js/profile.js') }}"></script>
</body>
</html>
