@extends('layouts.navbar')

@section('title', 'Aktivitas Saya')

@section('content')
<section class="py-5" style="background-color: #d94eb3; min-height: 100vh;">
  <div class="container">
    <h3 class="text-white fw-bold mb-4">Aktivitas Saya</h3>

    @if ($applications->isEmpty())
      <div class="bg-white rounded-4 shadow-sm p-4 text-center">
        <p class="mb-0 text-muted">Belum ada aktivitas lamaran.</p>
      </div>
    @else
      <div class="row g-4"> <!-- Mulai grid baris -->
        @foreach ($applications as $app)
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm p-4">
              <!-- Judul Pekerjaan -->
              <h5 class="fw-bold text-purple">{{ $app->jobPosting->title ?? 'Judul Tidak Ditemukan' }}</h5>

              <!-- Status Lamaran -->
              <p class="mb-2">Status: 
                <span class="fw-bold 
                  @if($app->status == 'Ditolak') text-danger
                  @elseif($app->status == 'Interview') text-primary
                  @elseif($app->status == 'Lamaran Dikirim') text-warning
                  @elseif($app->status == 'Diterima') text-success
                  @else text-dark
                  @endif
                ">
                  {{ ucfirst($app->status) }}
                </span>
              </p>

              <!-- Tipe Pekerjaan, Lokasi, dan Gaji Negotiable -->
              <div class="job-meta small mb-2 d-flex flex-wrap gap-3">
                <span class="fw-bold"><i class="bi bi-briefcase-fill me-1"></i>{{ $app->jobPosting->employment_type ?? 'Tipe Tidak Ditemukan' }}</span>
                <span class="fw-bold"><i class="bi {{ $app->jobPosting->location == 'Remote' ? 'bi-wifi' : ($app->jobPosting->location == 'Onsite' ? 'bi-building' : 'bi-house-door-fill') }} me-1"></i>{{ $app->jobPosting->location ?? 'Lokasi Tidak Ditemukan' }}</span>
                <span class="fw-bold text-info"><i class="bi bi-cash-coin me-1"></i>{{ $app->jobPosting->salary ?? 'Gaji Tidak Ditemukan' }}</span>
              </div>

              <button class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#modalLogs{{ $app->id }}">
                Lihat Riwayat Aktivitas
              </button>
            </div>
          </div>

          <!-- Modal Riwayat Aktivitas -->
          <div class="modal fade" id="modalLogs{{ $app->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title fw-bold text-purple">Riwayat Aktivitas - {{ $app->jobPosting->title ?? 'Judul Tidak Ditemukan' }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  @if($app->logs->isEmpty())
                    <p class="text-muted">Belum ada aktivitas.</p>
                  @else
                    <ul class="list-group">
                      @foreach ($app->logs as $log)
                        <li class="list-group-item">
                          <strong>{{ $log->action }}</strong><br>
                          <small class="text-muted">{{ $log->created_at->format('d M Y H:i') }}</small>
                          @if($log->message)
                            <p class="mb-0">{{ $log->message }}</p>
                          @endif
                        </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div> <!-- Akhir grid -->
    @endif
  </div>
</section>
@endsection
@include('frontend.authmodal')
