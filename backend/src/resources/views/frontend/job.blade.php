@extends('layouts.index')

@section('content')
<div class="container my-5">

  <div class="dropdown mb-4">
    <button class="btn btn-filter-white dropdown-toggle" type="button" id="kategoriDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="bi bi-funnel-fill"></i> Kategori
    </button>
    <ul class="dropdown-menu shadow rounded-4 p-2" aria-labelledby="kategoriDropdown">
      <li><h6 class="dropdown-header">Kategori</h6></li>
      <li><a class="dropdown-item" href="#" data-kategori="Semua">Semua</a></li>
      @foreach ($categories as $category)
        <li>
          <a class="dropdown-item" href="#" data-kategori="{{ $category->category_name }}">
            {{ $category->category_name }}
          </a>
        </li>
    @endforeach
  </ul>
  </div>

  <div class="row g-4 job-section justify-content-center">
    @foreach ($jobs as $job)
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm bg-white" data-kategori="{{ $job->category->category_name }}">
          <div class="card-body">
            <h5 class="card-title text-purple d-flex align-items-center gap-2">
              <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo" style="height: 24px;">
              {{ $job->title }}
            </h5>
            <div class="job-meta small mb-2 d-flex flex-wrap gap-3">
              <span class="fw-bold"><i class="bi bi-briefcase-fill me-1"></i>{{ $job->employment_type }}</span>
              <span class="fw-bold"><i class="bi {{ $job->location == 'Remote' ? 'bi-wifi' : ($job->location == 'Onsite' ? 'bi-building' : 'bi-house-door-fill') }} me-1"></i>{{ $job->location }}</span>
              <span class="fw-bold"><i class="bi bi-geo-alt-fill me-1"></i>{{ $job->work_location }}</span>
              <span class="fw-bold text-info"><i class="bi bi-cash-coin me-1"></i>{{ $job->salary }}</span>
            </div>
            <p class="small text-muted mb-4">Penutupan: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}</p>
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
            <div class="modal-header bg-light">
              <h5 class="modal-title job-title-pink" id="modalLabel{{ $job->id }}">{{ $job->title }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <h6 class="fw-bold text-purple">Deskripsi Pekerjaan</h6>
              <div>{!! $job->description !!}</div>

              <h6 class="fw-bold text-purple mt-4">Persyaratan</h6>
              <div>{!! $job->requirement !!}</div>

              @php
                $skills = $job->skills ?? '';
                $skillBadges = collect(explode(',', $skills))->map(fn($s) => '<span class="badge bg-primary">'.trim($s).'</span>')->implode(' ');
              @endphp

              @if ($skillBadges)
              <div class="mt-3">
                <h6 class="fw-semibold text-purple">Skill:</h6>
                <div class="d-flex flex-wrap gap-2">{!! $skillBadges !!}</div>
              </div>
              @endif
            </div>
            <div class="modal-footer">
              @auth
              <button 
              class="btn btn-primary btn-sm btn-apply"
              data-bs-toggle="modal" 
              data-bs-target="#applyModal"
              data-posisi="{{ $job->title }}"
            >
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

  <!-- Modal Form Lamaran -->
<div class="modal fade" id="applyModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="applyForm" class="modal-content" action="{{ route('application.submit') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Form Lamaran</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <!-- Posisi -->
        <div class="mb-3">
          <label class="form-label">Posisi yang Dilamar</label>
          <input id="posisiInput" name="posisi" class="form-control" readonly>
        </div>

        <!-- Kontak -->
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap *</label>
            <input name="nama" class="form-control" required
            value="{{ old('nama', $profile?->first_name . ' ' . $profile?->last_name ?? $user?->name) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email Aktif *</label>
            <input type="email" name="email" class="form-control" required
            value="{{ old('email', $user?->email) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">No. HP / WhatsApp *</label>
            <input name="telepon" class="form-control" required
            value="{{ old('telepon', $profile?->phone ?? '') }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Domisili *</label>
            <input name="domisili" class="form-control" required
              value="{{ old('domisili', $profile?->address ?? '') }}">
          </div>
        </div>

        <!-- Profesi -->
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

        <!-- Instansi -->
        <div class="mt-3">
          <label class="form-label">Kampus / Kantor</label>
          <input name="instansi" class="form-control">
        </div>

        <!-- Pendidikan dan Pengalaman -->
        <div class="row g-3 mt-2">
          <div class="col-md-6">
            <label class="form-label">Pendidikan Terakhir *</label>
            <select name="pendidikan" class="form-select" required>
            <option value="" disabled {{ old('pendidikan', $profile?->education_level) ? '' : 'selected' }}>Pilih</option>
            <option value="SMA/SMK" {{ old('pendidikan', $profile?->education_level) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
            <option value="D3" {{ old('pendidikan', $profile?->education_level) == 'D3' ? 'selected' : '' }}>D3</option>
            <option value="S1" {{ old('pendidikan', $profile?->education_level) == 'S1' ? 'selected' : '' }}>S1</option>
            <option value="S2" {{ old('pendidikan', $profile?->education_level) == 'S2' ? 'selected' : '' }}>S2</option>
          </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Pengalaman kerja dalam posisi ini *</label>
            <select name="pengalaman" class="form-select" required>
            <option value="" selected disabled>Pilih</option>
            <option value="<1 tahun"><1 tahun</option>
            <option value="1-2 tahun">1–2 tahun</option>
            <option value="3-5 tahun">3–5 tahun</option>
            <option value=">5 tahun">>5 tahun</option>
          </select>

          </div>
        </div>

        <!-- Proyek -->
        <div class="mt-3">
          <label class="form-label">Proyek/tugas paling berdampak *</label>
          <textarea name="proyek" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Upload -->
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

        <!-- Persetujuan -->
        <div class="form-check mt-4">
          <input class="form-check-input" type="checkbox" id="agree" required>
          <label class="form-check-label" for="agree">
            Saya menyetujui <a href="#">Privacy Policy</a>.
          </label>
        </div>
      </div>

      <div class="modal-footer">
        <button id="btnSubmitLamaran" class="btn btn-primary" type="submit">Kirim Lamaran</button>

      </div>
    </form>
  </div>
</div>


<!-- Modal Sukses -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Lamaran Berhasil Dikirim</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-4">Terima kasih! Lamaran kamu sudah kami terima.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
          <a href="{{ url('/') }}" class="btn btn-primary">Kunjungi Beranda</a>
          <a href="{{ route('application.status') }}" class="btn btn-outline-secondary">Lihat Status Lamaran</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection