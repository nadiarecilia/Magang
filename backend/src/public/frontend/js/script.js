// === Ambil CSRF Token dari meta tag ===
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

document.addEventListener('DOMContentLoaded', () => {

  // === 1. Filter Kategori Lowongan ===
  const kategoriDropdown = document.getElementById("kategoriDropdown");
  const kategoriLinks = document.querySelectorAll(".dropdown-menu a.dropdown-item");
  const jobCols = document.querySelectorAll(".job-section .col-md-6, .job-section .col-lg-4");

  const filterKategori = (kategori) => {
    jobCols.forEach(col => {
      const card = col.querySelector(".card[data-kategori]");
      const kategoriCard = card?.getAttribute("data-kategori");

      if (kategori === "Semua" || kategoriCard === kategori) {
        col.classList.remove("d-none");
      } else {
        col.classList.add("d-none");
      }
    });

    if (kategoriDropdown) {
      kategoriDropdown.innerHTML = `<i class="bi bi-funnel-fill"></i> ${kategori}`;
    }
  };

  kategoriLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      filterKategori(link.textContent.trim());
    });
  });

  filterKategori("Semua");

  // === 2. Navbar Underline dan Shrink saat Scroll ===
  const navbar = document.querySelector('.navbar');
  const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navLinks.forEach(l => l.classList.remove('underline'));
      link.classList.add('underline');
    });
  });

  window.addEventListener('scroll', () => {
    if (navbar) navbar.classList.toggle('shrink', window.scrollY > 50);
  });

  // === 3. Navigasi ke Halaman Lowongan ===
  const goToLowongan = () => window.location.href = 'find-job.html';
  document.getElementById('lihatLowongan')?.addEventListener('click', e => { e.preventDefault(); goToLowongan(); });
  document.getElementById('footerLowongan')?.addEventListener('click', e => { e.preventDefault(); goToLowongan(); });

  // === 4. Toggle Field "Profesi Lainnya" ===
  const profesiSelect = document.getElementById('profesiSelect');
  const profesiLainnyaField = document.getElementById('profesiLainnyaField');

  profesiSelect?.addEventListener('change', () => {
    const isLainnya = profesiSelect.value === 'Lainnya';
    profesiLainnyaField?.classList.toggle('d-none', !isLainnya);
    const input = profesiLainnyaField?.querySelector('input');
    if (input) {
      isLainnya ? input.setAttribute('required', 'true') : input.removeAttribute('required');
    }
  });

  // === 5. Preview Gambar Foto Profil ===
  const previewImage = document.getElementById('editProfileImage');
  previewImage?.addEventListener('change', function () {
    const reader = new FileReader();
    reader.onload = (e) => {
      const result = e.target.result;
      document.getElementById('previewProfileImage').src = result;
      document.getElementById('profilePicture').src = result;
    };
    if (this.files[0]) reader.readAsDataURL(this.files[0]);
  });

  // === 6. Submit Lamaran via Fetch ===
  const applyForm = document.getElementById('applyForm');
  const applyModal = document.getElementById('applyModal');
  const successModal = document.getElementById('successModal');

  applyForm?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(applyForm);
    const cv = formData.get('cv');
    const portfolio = formData.get('portfolio');

    if (cv && cv.size > 2 * 1024 * 1024) {
      alert('Ukuran CV melebihi 2 MB.');
      return;
    }
    if (portfolio && portfolio.size > 5 * 1024 * 1024) {
      alert('Ukuran portofolio melebihi 5 MB.');
      return;
    }

    try {
      const response = await fetch(applyForm.action, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        }
      });

      const isJson = response.headers.get('content-type')?.includes('application/json');
      const data = isJson ? await response.json() : {};

      if (response.ok) {
        bootstrap.Modal.getInstance(applyModal)?.hide();
        const successInstance = new bootstrap.Modal(successModal);
        successInstance.show();
        applyForm.reset();
      } else if (response.status === 401) {
        alert('Anda harus login terlebih dahulu.');
      } else if (response.status === 422 && data.errors) {
        const messages = Object.values(data.errors).flat().join('\n');
        alert(`Validasi gagal:\n${messages}`);
      } else {
        alert(data.message || 'Terjadi kesalahan saat mengirim lamaran.');
      }

    } catch (err) {
      console.error('Gagal kirim lamaran:', err);
      alert('Gagal mengirim lamaran. Silakan coba lagi nanti.');
    }
  });

  // === 7. Auto Isi "Posisi yang Dilamar" (Versi yang Benar) ===
  const applyModalElement = document.getElementById('applyModal');
  applyModalElement?.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const posisi = button?.getAttribute('data-posisi');
    const posisiInput = document.getElementById('posisiInput');
    if (posisi && posisiInput) {
      posisiInput.value = posisi;
    }
  });

  // === 8. ScrollSpy Aktif untuk Navbar ===
  const sectionObserver = () => {
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".nav-link[data-scroll]");

  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.6
  };

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      const id = entry.target.getAttribute("id");
      const link = document.querySelector(`.nav-link[data-scroll="${id}"]`);
      if (link && entry.isIntersecting) {
        document.querySelectorAll('.nav-link[data-scroll]').forEach(el => el.classList.remove('active'));
        link.classList.add('active');
      }
    });
  }, observerOptions);

  sections.forEach(section => observer.observe(section));

  // Tambahan: langsung aktifkan saat klik
  navLinks.forEach(link => {
    link.addEventListener('click', function () {
      navLinks.forEach(el => el.classList.remove('active'));
      this.classList.add('active');
    });
  });
};

sectionObserver();
});