<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lowongan Aktif - Winni Code</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('frontend/style/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/style/job.css') }}" />
</head>

<body>

<!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">
      <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo Winni Code - Digital Recruitment Platform" width="300">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav me-3">
          <li class="nav-item">
            <a class="nav-link" href="/">Beranda</a>
          </li>
          <li class="nav-item">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('jobs.index') ? 'active' : '' }}" href="{{ route('jobs.index') }}" id="lihatLowongan">Lihat Lowongan</a></li>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="application-status.html">Aktivitas Saya</a>
          </li>
        </ul>
      @guest
<div id="authMenu" class="d-flex">
    <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</button>
</div>
@endguest
       @auth
<div id="profileMenu" class="d-flex align-items-center">
    <a href="{{ route('profile') }}" class="me-2 text-dark text-decoration-none d-flex align-items-center">
        <i class="bi bi-person-circle me-1 fs-5"></i>
        <span id="navbarUsername" class="fw-semibold">{{ auth('web')->user()->name }}</span>
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
@yield('content')

  <!-- Bootstrap & Custom Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('frontend/js/script.js') }}"></script>

</body>
</html>