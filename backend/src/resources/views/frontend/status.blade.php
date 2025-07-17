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
      @foreach ($applications as $app)
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
          <h5 class="fw-bold">{{ $app->jobPosting->title ?? 'Judul Tidak Ditemukan' }}</h5>

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

          <p class="mb-1"><strong>Email:</strong> {{ $app->email }}</p>
          <p class="mb-1"><strong>Telepon:</strong> {{ $app->phone ?? '-' }}</p>
          <p class="mb-1"><strong>Domisili:</strong> {{ $app->domicile ?? '-' }}</p>
          <p class="mb-1"><strong>Instansi:</strong> {{ $app->instansi ?? '-' }}</p>
          <p class="mb-1"><strong>Pendidikan Terakhir:</strong> {{ $app->education_level ?? '-' }}</p>
          <p class="mb-1"><strong>Pengalaman Posisi:</strong> {{ $app->position_experience ?? '-' }}</p>

          <button class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#modalLogs{{ $app->id }}">
            Lihat Riwayat Aktivitas
          </button>
        </div>

        <!-- Modal Riwayat -->
        <div class="modal fade" id="modalLogs{{ $app->id }}" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Riwayat Aktivitas - {{ $app->jobPosting->title ?? 'Judul Tidak Ditemukan' }}</h5>
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
    @endif
  </div>
</section>
@endsection