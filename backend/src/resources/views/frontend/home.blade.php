@extends('layouts.app')

@section('content')

<!-- Hero -->
<section class="hero d-flex align-items-center text-white py-5" style="background-color: #d153a1; min-height: 100vh; padding-top: 100px;" id="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-center text-md-start">
        <h6 class="text-uppercase mb-2 fs-5" style="color: #FFFFFF;">100% WORK FROM ANYWHERE SUPPORT!</h6>
        <h1 class="fw-bold mb-4 display-3" style="color: #0086CA;"> Bangun Masa Depan Teknologi Bersama<br />Winnicode Garuda</h1>
        <a href="#tentang" class=" col-md-6 text-center btn btn-light">Mulai</a>
      </div>
      <div class="col-md-6 text-center mt-4 mt-md-0">
        <img src="{{ asset('frontend/assets/hero.png') }}" alt="Ilustrasi Winnicode Hero" class="img-fluid" loading="lazy" style="max-height: 1000px;" />
      </div>
    </div>
  </div>
</section>

<!-- Tentang Kami -->
<section id="tentang" class="py-5 bg-white text-dark">
  <div class="container bg-overlay">
    <div class="row align-items-center">
      <div class="col-md-6 text-center mb-4 mb-md-0">
        <img src="{{ asset('frontend/assets/visi.png') }}" alt="Ilustrasi Tentang Winnicode" class="img-fluid rounded shadow" loading="lazy" style="max-height: 400px;" />
      </div>
      <div class="col-md-6">
        <h3 class="fw-bold">Tentang PT Winnicode Garuda Teknologi</h3>
        <p class="text-muted">PT Winnicode Garuda Teknologi adalah perusahaan digital yang berfokus pada pengembangan solusi teknologi berbasis sistem informasi...</p>
        <div class="mt-3">
          <a href="#visi" class="btn btn-outline-secondary me-2" style=" color: #eb44bb;">Lihat Visi</a>
          <a href="#misi" class="btn btn-outline-secondary" style="color: #eb44bb;">Lihat Misi</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Cara Kerja -->
<section id="cara-kerja" class="py-5 bg-white text-dark">
  <div class="container bg-overlay">
    <h3 class="fw-bold text-center mb-4">Cara Kerja Kami</h3>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/9244/9244649.png" width="60" loading="lazy" />
        <h5 class="fw-semibold">Discover</h5>
        <p>Pelamar menemukan dan mendaftar lowongan sesuai minat dan keahlian.</p>
      </div>
      <div class="col-md-4 mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" width="60" loading="lazy" />
        <h5 class="fw-semibold">Screen</h5>
        <p>Sistem menyaring lamaran otomatis berdasarkan kriteria yang ditentukan.</p>
      </div>
      <div class="col-md-4 mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/2972/2972557.png" width="60" loading="lazy" />
        <h5 class="fw-semibold">Decide</h5>
        <p>HR menilai dan memutuskan hasil seleksi, sistem mengirimkan email notifikasi.</p>
      </div>
    </div>
  </div>
</section>

<!-- Visi -->
<section class="py-5 bg-light" id="visi">
  <div class="container bg-overlay">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4">
        <h4 class="fw-bold">VISI KAMI</h4>
        <p>Menjadi pelopor dalam transformasi digital di bidang jurnalistik Indonesia dengan menghadirkan teknologi inovatif...</p>
        <a href="#misi" class="btn btn-primary">Misi</a>
      </div>
      <div class="col-md-6">
        <img src="{{ asset('frontend/assets/visi.png') }}" alt="Visi Winnicode" class="img-fluid" loading="lazy" />
      </div>
    </div>
  </div>
</section>

<!-- Misi -->
<section class="py-5 bg-white" id="misi">
  <div class="container bg-overlay">
    <h4 class="text-center fw-bold mb-4">MISI KAMI</h4>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/270/270014.png" width="60" loading="lazy" />
        <p>Membangun platform digital yang mudah diakses dan digunakan kandidat pelamar</p>
      </div>
      <div class="col-md-4 mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/1046/1046857.png" width="60" loading="lazy" />
        <p>Menyediakan sistem otomatisasi untuk mempercepat proses seleksi dan komunikasi</p>
      </div>
      <div class="col-md-4 mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/3875/3875152.png" width="60" loading="lazy" />
        <p>Mendorong budaya kerja berbasis digital yang fleksibel dan produktif</p>
        <a href="#visi" class="btn btn-primary">Visi</a>
      </div>
    </div>
  </div>
</section>

@endsection