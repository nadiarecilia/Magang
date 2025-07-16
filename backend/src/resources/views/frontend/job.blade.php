@extends('layouts.index')

@section('content')
<!-- Main Content -->
  <div class="container my-5">
   @php
      // Misal kolom skill disimpan CSV, jika tidak punya → kosong
      $skills = $job->skill ?? ''; // atau $job->skills tergantung nama kolom

      $skillBadges = collect(explode(',', $skills))
          ->map(function($s) {
              return '<span class="badge bg-secondary">'.trim($s).'</span>';
          })
          ->implode(' ');
  @endphp
  <div class="row justify-content-center g-4" id="jobContainer">
    <!-- Filter Kategori Pekerjaan -->
    <div class="dropdown mb-4">
      <button class="btn btn-filter-white dropdown-toggle" type="button" id="kategoriDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-funnel-fill"></i> Kategori
      </button>
      <ul class="dropdown-menu shadow rounded-4 p-2" aria-labelledby="kategoriDropdown" style="min-width: 200px;">
        <li><h6 class="dropdown-header">Kategori</h6></li>
        <li><a class="dropdown-item" href="#">Semua</a></li>
        <li><a class="dropdown-item" href="#">IT</a></li>
        <li><a class="dropdown-item" href="#">Media</a></li>
        <li><a class="dropdown-item" href="#">Design</a></li>
        <li><a class="dropdown-item" href="#">Marketing</a></li>
      </ul>
    </div>
    
    <div class="row g-4 job-section justify-content-center">
  @foreach ($jobs as $job)
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm bg-white" data-kategori="{{ $job->category->name }}">
        <div class="card-body">
          <h5 class="card-title text-purple d-flex align-items-center gap-2">
            <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo" class="img-fluid" style="height: 24px;">
            {{ $job->title }}
          </h5>
          <div class="job-meta d-flex flex-wrap align-items-center gap-3 small mb-2">
            <span class="fw-bold"><i class="bi bi-briefcase-fill me-1"></i>{{ $job->employment_type }}</span>
            <span class="fw-bold">
              <i class="bi {{ $job->location == 'Remote' ? 'bi-wifi' : ($job->location == 'Onsite' ? 'bi-building' : 'bi-house-door-fill') }} me-1"></i>
              {{ $job->location }}
            </span>
            <span class="fw-bold"><i class="bi bi-geo-alt-fill me-1"></i>{{ $job->work_location }}</span>
            <span class="fw-bold text-info"><i class="bi bi-cash-coin me-1"></i>{{ $job->salary }}</span>
          </div>
          <p class="small text-muted mb-4">Penutupan: {{ \Carbon\Carbon::parse($job->deadline)->format('m/d/Y') }}</p>
          <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#jobModal{{ $job->id }}">
            Lihat Detail Pekerjaan
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $job->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header {{ $loop->iteration % 2 == 0 ? 'bg-pink text-white' : '' }}">
            <h5 class="modal-title" id="modalLabel{{ $job->id }}">{{ $job->title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
           <p><strong>Deskripsi Pekerjaan:</strong></p>
           <div>{!! $job->description !!}</div>
           
           <p><strong>Persyaratan:</strong></p>
           <div>{!! $job->requirement !!}</div>

          @php
            $skills = $job->skills ?? ''; // pakai 'skills' (bukan 'skill')
            $skillBadges = collect(explode(', ', $skills))
                ->map(function($s) {
                    return '<span class="badge bg-secondary">'.trim($s).'</span>';
                })
                ->implode(' ');
          @endphp

          @if ($skillBadges)
            <div class="mb-3">
              <h6 class="fw-semibold text-purple">Skill:</h6>
              <div class="d-flex flex-wrap gap-2">{!! $skillBadges !!}</div>
            </div>
          @endif

          </div>
          <div class="modal-footer">
            @auth
              <button class="btn btn-primary btn-lamar" 
                      data-bs-toggle="modal" 
                      data-bs-target="#applyModal"
                      data-job-id="{{ $job->id }}" 
                      data-posisi="{{ $job->title }}">
                Lamar
              </button>
            @else
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                Login untuk Lamar
              </button>
            @endauth
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>

<!-- Form Lamaran -->
<div class="modal fade" id="applyModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="applyForm" class="modal-content" enctype="multipart/form-data" method="POST" action="{{ route('job.apply') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Form Lamaran</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- ID Lowongan (input hidden) -->
        <input type="hidden" name="job_posting_id" id="jobPostingId">

        <!-- Data Kontak & CV -->
        <div class="mb-3">
          <label class="form-label">Posisi yang Dilamar</label>
          <input id="posisiInput" name="name" class="form-control" readonly>
        </div>

        <!-- Informasi Kontak -->
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap *</label>
            <input name="nama" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email Aktif *</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">No. HP / WhatsApp *</label>
            <input name="telepon" class="form-control" placeholder="+62 812…" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Domisili *</label>
            <input name="domisili" class="form-control" placeholder="Jakarta, Bandung…" required>
          </div>
        </div>

        <!-- Profesi Saat Ini -->
        <div class="row g-3 mt-2">
          <div class="col-md-6">
            <label class="form-label">Profesi Saat Ini *</label>
            <select name="profesi" class="form-select" id="profesiSelect" required>
              <option value="" selected disabled>Pilih</option>
              <option value="Mahasiswa">Mahasiswa</option>
              <option value="SMA/SMK">SMA/SMK</option>
              <option value="Fresh Graduate">Fresh Graduate</option>
              <option value="Bekerja">Bekerja</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="col-md-6 d-none" id="profesiLainnyaField">
            <label class="form-label">Tuliskan Profesi Anda *</label>
            <input name="profesi_lainnya" class="form-control">
          </div>
        </div>

        <!-- Kampus / Kantor -->
        <div class="mt-3">
          <label class="form-label">Kampus / Kantor</label>
          <input name="instansi" class="form-control" placeholder="Contoh: Universitas Esa Unggul / PT ABC Digital">
        </div>

        <!-- Pendidikan & Pengalaman -->
        <div class="row g-3 mt-2">
          <div class="col-md-6">
            <label class="form-label">Pendidikan Terakhir *</label>
            <select name="education_level" class="form-select" required>
              <option value="" selected disabled>Pilih</option>
              <option value="SMA/SMK">SMA/SMK</option>
              <option value="D3">D3</option>
              <option value="S1">S1</option>
              <option value="S2">S2</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Pengalaman kerja dalam posisi ini *</label>
            <select name="position_experience" class="form-select" required>
              <option value="" selected disabled>Pilih</option>
              <option>&lt; 1 tahun</option>
              <option>1–2 tahun</option>
              <option>3–5 tahun</option>
              <option>&gt; 5 tahun</option>
            </select>
          </div>
        </div>

        <!-- Proyek -->
        <div class="mt-3">
          <label class="form-label">Proyek/tugas paling berdampak *</label>
          <textarea name="impactful_project" rows="3" class="form-control" required></textarea>
        </div>

        <!-- Upload CV & Portofolio -->
        <div class="row g-3 mt-1">
          <div class="col-md-6">
            <label class="form-label">Upload CV (PDF, ≤2 MB) *</label>
            <input name="cv" type="file" accept="application/pdf" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Upload Portofolio (PDF/PPT/ZIP) *</label>
            <input name="portfolio" type="file" accept=".pdf,.ppt,.pptx,.zip,.rar" class="form-control" required>
          </div>
        </div>

        <!-- Privacy Policy -->
        <div class="form-check mt-4">
          <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
          <label class="form-check-label" for="agree">
            Saya menyetujui <a href="#">Privacy Policy</a>.
          </label>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Kirim Lamaran</button>
      </div>
    </form>
  </div>
</div>

 <!-- ========= MODAL SUKSES ========= -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-blue">
        <h5 class="modal-title">Lamaran Berhasil Dikirim</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-4">Terima kasih! Lamaran kamu sudah kami terima.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
          <a href="index.html" class="btn btn-primary">Kunjungi Beranda</a>
          <a href="application-status.html" class="btn btn-outline-pink">Lihat Status Lamaran</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection