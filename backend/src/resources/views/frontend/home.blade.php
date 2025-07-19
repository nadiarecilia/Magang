@extends('layouts.app')

@section('content')

<!-- Hero -->
  <section class="hero d-flex align-items-center text-white py-5"
  style="background-color: #eb44bb; min-height: 70vh; padding-top: 60px;" id="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-center text-md-start">
        <h6 class="text-uppercase mb-2 fs-5 text-center" style="color: #800080;text-shadow: 1px 1px 3px rgba(128, 0, 128, 0.4);">
          100% WORK FROM ANYWHERE SUPPORT!
        </h6>
        <h1 class="text-center fw-bold mb-4" style="
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        font-size: 3.5rem;
        line-height: 1.4;
        text-shadow: 2px 2px 4px #894ee7ff;">Bangun Masa Depan Teknologi Bersama<br />Winnicode Garuda
        </h1>
        <div class="d-flex justify-content-center">
          <a href="#tentang" class="btn rounded-pill px-4 py-2 mt-2 fw-bold text-white" style="background-color: transparent; border: 2px solid #894ee7ff;">
            Mulai
          </a>
        </div>
      </div>
      <div class="col-md-6 text-center mt-4 mt-md-0">
        <img src="{{ asset('frontend/assets/1.png') }}" alt="Ilustrasi Winnicode Hero" class="img-fluid rounded" style="max-height: 90vh; object-fit: contain;" loading="lazy" />
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
      <div class="col-md-6 text-center">
        <h3 class="fw-bold">Tentang PT Winnicode Garuda Teknologi</h3>
        <p class="text-muted">PT Winnicode Garuda Teknologi adalah perusahaan digital yang berfokus pada pengembangan solusi teknologi berbasis sistem informasi, dengan spesialisasi dalam platform rekrutmen dan sistem jurnalistik terpadu. Kami percaya bahwa teknologi harus mendukung kolaborasi, efisiensi, dan transparansi, terutama dalam proses kerja jarak jauh (remote) yang kini menjadi standar baru.</p>
        
        <p class="text-muted">Kami membangun sistem yang menyatukan proses dari awal hingga akhir, mulai dari pengumpulan data, penyaringan otomatis, penilaian terpusat, hingga notifikasi seleksi yang dikirimkan ke pelamar. Dengan pengalaman dalam pengembangan sistem digital, kami hadir sebagai mitra yang andal dalam dunia kerja modern.</p>
        <div class="mt-3">
          <a href="#visi" class="btn btn-primary rounded-pill px-4 py-2 mt-2" style="background-color: #eb44bb;">Lihat Visi</a>
          <a href="#misi" class="btn btn-primary rounded-pill px-4 py-2 mt-2" style="background-color: #894ee7ff;">Lihat Misi</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Cara Kerja -->
<section id="cara-kerja" class="py-5 bg-white text-dark">
  <div class="container bg-overlay">
    <!-- <h3 class="fw-bold text-center mb-4">Cara Kerja Kami</h3> -->
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
        <h4 class="fw-bold text-start">VISI KAMI</h4>
        <div class="text-center">
          <p class="text-muted">
            Menjadi pelopor dalam transformasi digital di bidang jurnalistik Indonesia dengan menghadirkan teknologi inovatif yang mendukung kolaborasi, akurasi, dan kecepatan informasi di era kerja jarak jauh, serta menciptakan ekosistem kerja yang inklusif, berkelanjutan, dan berorientasi pada pengembangan talenta digital lokal.
          </p>
          <a href="#misi" class="btn btn-primary rounded-pill px-4 py-2 mt-2" style="background-color: #894ee7ff; border: none;">Lihat Misi</a>
        </div>
      </div>
      <div class="col-md-6 text-center">
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
        <a href="#visi" class="btn btn-primary rounded-pill px-4 py-2 mt-2" style="background-color: #eb44bb; border: none;">Lihat Visi</a>
      </div>
    </div>
  </div>
</section>

@endsection