document.addEventListener('DOMContentLoaded', () => {
  // === Filter Kategori Lowongan ===
  const kategoriLinks = document.querySelectorAll(".dropdown-menu a.dropdown-item");
  const jobCards = document.querySelectorAll(".card[data-kategori]");
  const kategoriDropdown = document.getElementById("kategoriDropdown");

  function filterKategori(kategori) {
    jobCards.forEach(card => {
      const kategoriCard = card.getAttribute("data-kategori");
      card.style.display = (kategori === "Semua" || kategoriCard === kategori) ? "block" : "none";
    });
    kategoriDropdown.innerHTML = `<i class="bi bi-funnel-fill"></i> ${kategori}`;
  }

  kategoriLinks.forEach(link => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      filterKategori(this.textContent.trim());
    });
  });

  filterKategori("Semua"); // Tampilkan semua kategori default

  // === Navbar underline dan shrink saat scroll ===
  const navbar = document.querySelector('.navbar');
  const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

  navLinks.forEach(link => {
    link.addEventListener('click', function () {
      navLinks.forEach(l => l.classList.remove('underline'));
      this.classList.add('underline');
    });
  });

  window.addEventListener('scroll', () => {
    navbar?.classList.toggle('shrink', window.scrollY > 50);
  });

  // === Link ke Lihat Lowongan (jika digunakan di halaman lain) ===
  document.getElementById('lihatLowongan')?.addEventListener('click', (e) => {
    e.preventDefault();
    window.location.href = 'find-job.html';
  });

  document.getElementById('footerLowongan')?.addEventListener('click', (e) => {
    e.preventDefault();
    window.location.href = 'find-job.html';
  });

  // === Modal Lamar: Isi Otomatis Posisi & Job ID ===
  const lamarButtons = document.querySelectorAll('.btn-lamar');
  lamarButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const posisi = btn.getAttribute('data-posisi');
      const jobId = btn.getAttribute('data-job-id');

      document.getElementById('posisiInput').value = posisi;
      document.getElementById('jobPostingId').value = jobId;
    });
  });

  // === Submit Lamaran via fetch() ===
  const applyForm = document.getElementById('applyForm');
  const applyModalEl = document.getElementById('applyModal');
  const successModalEl = document.getElementById('successModal');

  applyForm?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const cv = form.cv.files[0];
    const fol = form.portfolio.files[0];

    // Validasi ukuran file
    if (cv && cv.size > 2 * 1024 * 1024) {
      alert('CV melebihi 2 MB');
      return;
    }
    if (fol && fol.size > 5 * 1024 * 1024) {
      alert('Portofolio melebihi 5 MB');
      return;
    }

    const formData = new FormData(form);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    try {
      const response = await fetch(form.action, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        }
      });

      const isJson = response.headers.get('content-type')?.includes('application/json');
      const data = isJson ? await response.json() : {};

      if (response.ok) {
        bootstrap.Modal.getInstance(applyModalEl)?.hide();
        new bootstrap.Modal(successModalEl).show();
        form.reset();
      } else if (response.status === 422 && data.errors) {
        const messages = Object.values(data.errors).flat().join('\n');
        alert(`Validasi Gagal:\n${messages}`);
      } else if (response.status === 401) {
        alert('Anda harus login terlebih dahulu.');
      } else {
        alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
      }
    } catch (err) {
      console.error('Gagal mengirim lamaran:', err);
      alert('Terjadi kesalahan saat mengirim lamaran. Coba lagi nanti.');
    }
  });

  // === Toggle Field "Profesi Lainnya" ===
  const profesiSelect = document.getElementById('profesiSelect');
  const profesiLainnyaField = document.getElementById('profesiLainnyaField');

  profesiSelect?.addEventListener('change', () => {
    const isOther = profesiSelect.value === 'Lainnya';
    profesiLainnyaField?.classList.toggle('d-none', !isOther);
    const input = profesiLainnyaField?.querySelector('input');
    if (input) {
      isOther ? input.setAttribute('required', 'true') : input.removeAttribute('required');
    }
  });

  // === Preview Foto Profil ===
  document.getElementById('editProfileImage')?.addEventListener('change', function () {
    const reader = new FileReader();
    reader.onload = (e) => {
      document.getElementById('previewProfileImage').src = e.target.result;
      document.getElementById('profilePicture').src = e.target.result;
    };
    if (this.files[0]) reader.readAsDataURL(this.files[0]);
  });
});