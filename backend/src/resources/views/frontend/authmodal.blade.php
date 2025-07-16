<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="row g-0">
        <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center text-white text-center p-4" style="background-color:#eb44bb;">
          <h3 class="fw-bold mb-3">WORK FROM ANYWHERE!</h3>
          <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo" class="mb-3" style="width:200px;">
          <img src="{{ asset('frontend/assets/form.png') }}" alt="Ilustrasi" class="img-fluid mt-3" style="max-height:300px;">
        </div>
        <div class="col-md-6 p-4">
          <div class="text-center mb-3">
            <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo" style="width:200px;">
            <h5 class="mt-2 text-primary fw-bold">Masuk</h5>
          </div>
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Nama Pengguna atau Email</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
          </form>
          <div class="text-center mt-3">
            <p class="mb-0">Belum punya akun?</p>
            <a href="#" class="fw-bold" style="color:#eb44bb;" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#signupModal">Daftar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Register -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="scroll-behavior:smooth;">
      <div class="row g-0">
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center align-items-center text-white text-center p-4" style="background-color:#eb44bb;">
          <h3 class="fw-bold mb-3 text-white">WORK FROM ANYWHERE!</h3>
          <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo" class="mb-3" style="width:180px;">
          <img src="{{ asset('frontend/assets/form.png') }}" alt="Ilustrasi" class="img-fluid mt-3" style="max-height:280px;" loading="lazy">
        </div>
        <div class="col-lg-6 p-4 bg-white overflow-auto" style="max-height:90vh;">
          <div class="text-center mb-3">
            <img src="{{ asset('frontend/assets/logo1.png') }}" alt="Logo" style="width:180px;">
            <h5 class="mt-2 fw-bold text-pink">Daftar</h5>
          </div>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-2">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="fullName" class="form-control form-control-sm" required>
            </div>
            <div class="row mb-2">
              <div class="col">
                <label class="form-label">Nama Depan</label>
                <input type="text" name="firstName" class="form-control form-control-sm" required>
              </div>
              <div class="col">
                <label class="form-label">Nama Belakang</label>
                <input type="text" name="lastName" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="mb-2">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control form-control-sm" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control form-control-sm" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="terms" required>
              <label class="form-check-label" for="terms">
                Saya telah membaca dan setuju dengan
                <a href="#">Privacy Policy</a>,
                <a href="#">Terms of Use</a>, dan
                <a href="#">Cookies Policy</a>.
              </label>
            </div>
            <button type="submit" class="btn w-100 mt-2 text-white" style="background-color:#eb44bb;">Buat Akun</button>
          </form>
          <p class="mt-3 text-center text-sm">
            Sudah punya akun?
            <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal" class="text-pink text-decoration-none">Masuk</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>