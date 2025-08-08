<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil – Winni Code</title>
    <link rel="icon" href="{{ asset('frontend/assets/visi.png') }}" type="image/png">

    <!-- Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ikon & CSS kustom -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/style/profile.css') }}">
</head>
<body>

    <!-- TOP BAR -->
    <nav class="topbar">
        <div class="container d-flex justify-content-between align-items-center">
            <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo Winnicode">
            <span><i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}</span>
        </div>
    </nav>

    <!-- ALERTS -->
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- TITLE -->
    <div class="container text-white my-4">
        <a href="/" class="text-white me-2"><i class="bi bi-arrow-left fs-4"></i></a>
        <span class="fs-3 fw-semibold">Profil Saya</span>
    </div>

    <!-- PROFILE CARD -->
    <div class="container mb-5">
        <div class="profile-card">

            <h5 class="section-head">Informasi Profil</h5>
            <div class="row g-lg-4 align-items-start mb-4">

              @php
                // path tersimpan di kolom profile_picture, contoh: "profile_pictures/abc.jpg"
                $pic = Auth::user()->pelamarProfile->profile_picture ?? null;
            @endphp
                <!-- Avatar -->
                <div class="col-lg-3 text-center mb-3 mb-lg-0">
                    <div class="avatar-wrap mx-auto">
                        <img id="profilePicture" src="{{ $pic ? asset('storage/' . $pic) : asset('frontend/assets/profile.png') }}" alt="Foto Profil">
                    </div>
                </div>

                <!-- Kontak & Personal -->
                <div class="col-lg-9">
                    <div class="mb-3">
                        <span class="label">Nama Lengkap</span>
                        <span class="value">{{ Auth::user()->name }}</span>
                    </div>

                    <h6 class="fw-bold mb-3">Informasi Kontak & Personal</h6>
                    <div class="row gy-4">
                        <div class="col-md-4"><span class="label">Email</span><span class="value">{{ Auth::user()->email }}</span></div>
                        <div class="col-md-4"><span class="label">Phone</span><span class="value">{{ Auth::user()->pelamarProfile->phone ?? '-' }}</span></div>
                        <div class="col-md-4"><span class="label">Jurusan</span><span class="value">{{ Auth::user()->pelamarProfile->major ?? '-' }}</span></div>

                        <div class="col-md-4"><span class="label">Tempat Lahir</span><span class="value">{{ Auth::user()->pelamarProfile->birth_place ?? '-' }}</span></div>
                        <div class="col-md-4"><span class="label">Tanggal Lahir</span><span class="value">{{ Auth::user()->pelamarProfile->birth_date ?? '-' }}</span></div>
                        <div class="col-md-4"><span class="label">Jenis Kelamin</span><span class="value">{{ Auth::user()->pelamarProfile->gender ?? '-' }}</span></div>

                        <div class="col-md-4"><span class="label">No KTP</span><span class="value">{{ Auth::user()->pelamarProfile->id_number ?? '-' }}</span></div>
                        <div class="col-md-4"><span class="label">Pendidikan Terakhir</span><span class="value">{{ Auth::user()->pelamarProfile->education_level ?? '-' }}</span></div>
                        <div class="col-md-4"><span class="label">Alamat</span><span class="value">{{ Auth::user()->pelamarProfile->address ?? '-' }}</span></div>
                    </div>
                </div>
            </div>
            @php
    // helper cepat: ubah CSV -> array rapi
    $split = fn ($csv) => array_filter(array_map('trim', explode(',', $csv ?? '')));
@endphp

<div class="row">
            <div class="text-end">
                <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profil
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT PROFIL -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form  method="POST"
           action="{{ route('profile.update') }}"
           enctype="multipart/form-data"
           id="editProfileForm"
           class="modal-content">
      @csrf
      @method('PUT')

      <div class="modal-header" style="background-color: #eb44bb;">
        <h5 class="modal-title text-white">Edit Profil</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- FOTO PROFIL -->
        <div class="mb-3">
          <label class="form-label">Foto Profil <span class="text-danger">*</span></label>
          <input  type="file"
                  id="editProfileImage"
                  name="profile_picture"
                  accept="image/*"
                  class="form-control">
        </div>

        <!-- DATA DASAR -->
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap *</label>
            <input id="editUsername"
                   name="name"
                   class="form-control"
                   value="{{ old('name', Auth::user()->name) }}"
                   required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Email *</label>
            <input id="editEmail"
                   type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', Auth::user()->email) }}"
                   required>
          </div>

          <div class="col-md-6">
            <label class="form-label">No HP *</label>
            <input id="editPhone"
                   type="tel"
                   name="phone"
                   class="form-control"
                   value="{{ old('phone', Auth::user()->pelamarProfile->phone ?? '') }}"
                   required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Jurusan / Peminatan</label>
            <input name="major"
                   class="form-control"
                   value="{{ old('major', Auth::user()->pelamarProfile->major ?? '') }}">
          </div>
        </div>

        <!-- DATA PERSONAL -->
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label">Tempat Lahir *</label>
            <input id="birthPlace"
                   name="birth_place"
                   class="form-control"
                   value="{{ old('birth_place', Auth::user()->pelamarProfile->birth_place ?? '') }}"
                   required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Tanggal Lahir *</label>
            <input id="editDOB"
                   type="date"
                   name="birth_date"
                   class="form-control"
                   value="{{ old('birth_date', Auth::user()->pelamarProfile->birth_date ?? '') }}"
                   required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Jenis Kelamin *</label>
            <select id="gender"
                    name="gender"
                    class="form-select"
                    required>
              <option value="">Pilih…</option>
              <option value="laki-laki" {{ old('gender', Auth::user()->pelamarProfile->gender ?? '')=='laki-laki'?'selected':'' }}>Laki-Laki</option>
              <option value="perempuan"  {{ old('gender', Auth::user()->pelamarProfile->gender ?? '')=='perempuan'?'selected':'' }}>Perempuan</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">No KTP *</label>
            <input id="editKtp"
                   name="id_number"
                   class="form-control"
                   value="{{ old('id_number', Auth::user()->pelamarProfile->id_number ?? '') }}"
                   required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Pendidikan Terakhir *</label>
            <select id="editEducation"
                    name="education_level"
                    class="form-select"
                    required>
              <option value="">Pilih…</option>
              @foreach(['SMA/sederajat','D3','S1','S2','S3'] as $lvl)
                <option value="{{ $lvl }}"
                        {{ old('education_level', Auth::user()->pelamarProfile->education_level ?? '')==$lvl?'selected':'' }}>
                  {{ $lvl }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12">
            <label class="form-label">Alamat Lengkap</label>
            <textarea id="address"
                      name="address"
                      rows="2"
                      class="form-control autogrow">{{ old('address', Auth::user()->pelamarProfile->address ?? '') }}</textarea>
          </div>
        </div>

      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('frontend/js/profile.js') }}"></script>
</body>
</html>