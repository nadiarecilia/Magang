document.addEventListener('DOMContentLoaded', () => {
  // --- Bagian Job.js ---
  // Dropdown kategori filter
  const kategoriLinks = document.querySelectorAll(".dropdown-menu a.dropdown-item");
  const jobCards = document.querySelectorAll(".card[data-kategori]");
  const kategoriDropdown = document.getElementById("kategoriDropdown");

  function filterKategori(kategori) {
    jobCards.forEach(card => {
      const kategoriCard = card.getAttribute("data-kategori");
      if (kategori === "Semua" || kategoriCard === kategori) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
    kategoriDropdown.innerHTML = `<i class="bi bi-funnel-fill"></i> ${kategori}`;
  }

  kategoriLinks.forEach(link => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const selectedKategori = this.textContent.trim();
      filterKategori(selectedKategori);
    });
  });

  // Tampilkan semua job saat awal load
  filterKategori("Semua");

  // Handler tombol "Lamar"
  const applyButtons = document.querySelectorAll(".btn-lamar");
  applyButtons.forEach(btn => {
    btn.addEventListener("click", function (e) {
      const loggedInUser = JSON.parse(localStorage.getItem("loggedInUser"));
      if (!loggedInUser) {
        e.preventDefault();
        const loginModalEl = document.getElementById("loginModal");
        if (loginModalEl) {
          const loginModal = new bootstrap.Modal(loginModalEl);
          loginModal.show();
        }
      } else {
        const jobTitle = this.getAttribute("data-posisi");
        const posisiInput = document.getElementById("posisiInput");
        if (posisiInput) posisiInput.value = jobTitle;

        const applyModal = new bootstrap.Modal(document.getElementById("applyModal"));
        applyModal.show();
      }
    });
  });

  // --- Bagian script.js ---
  const navbar = document.querySelector('.navbar');
  const authMenu = document.getElementById('authMenu');
  const profileMenu = document.getElementById('profileMenu');
  const navbarUsername = document.getElementById('navbarUsername');
  const signupForm = document.getElementById('signupForm');
  const loginForm = document.getElementById('loginForm');
  const logoutBtn = document.getElementById('logoutBtn');
  const lihatLowonganNav = document.getElementById('lihatLowongan');
  const lihatLowonganFoot = document.getElementById('footerLowongan');

  // Underline menu aktif
  const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', function () {
      navLinks.forEach(l => l.classList.remove('underline'));
      this.classList.add('underline');
    });
  });

  // Navbar mengecil saat scroll
  window.addEventListener('scroll', () => {
    if (navbar) navbar.classList.toggle('shrink', window.scrollY > 50);
  });

  // Cek login
  let user = null;
  try {
    user = JSON.parse(localStorage.getItem('loggedInUser')) || null;
  } catch {
    localStorage.removeItem('loggedInUser');
  }

  if (user) {
    authMenu?.classList.add('d-none');
    profileMenu?.classList.remove('d-none');
    navbarUsername && (navbarUsername.textContent = user.username || 'Profil');
  } else {
    authMenu?.classList.remove('d-none');
    profileMenu?.classList.add('d-none');
  }

  // Form Signup
  signupForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const fullName = document.getElementById('fullName')?.value.trim();
    const email = document.getElementById('email')?.value.trim();
    const password = document.getElementById('signupPassword')?.value;
    const confirmPassword = document.getElementById('confirmPassword')?.value;

    if (!fullName || !email || !password || !confirmPassword)
      return alert('Mohon isi semua kolom!');

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) return alert('Format email tidak valid!');
    if (password !== confirmPassword) return alert('Password tidak cocok!');

    const users = JSON.parse(localStorage.getItem('users')) || [];
    if (users.some(u => u.email.toLowerCase() === email.toLowerCase()))
      return alert('Email sudah terdaftar.');

    const newUser = { username: fullName, email, password: hashPassword(password) };
    users.push(newUser);
    localStorage.setItem('users', JSON.stringify(users));
    localStorage.setItem('loggedInUser', JSON.stringify(newUser));
    window.location.href = 'index.html?registered=true';
  });

  // Form Login
  loginForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const username = document.getElementById('username')?.value.trim();
    const password = document.getElementById('loginPassword')?.value.trim();
    if (!username || !password) return alert('Harap isi semua kolom.');

    const users = JSON.parse(localStorage.getItem('users')) || [];
    const found = users.find(u =>
      (u.username === username || u.email === username) &&
      u.password === hashPassword(password)
    );

    if (found) {
      localStorage.setItem('loggedInUser', JSON.stringify(found));
      window.location.href = 'index.html';
    } else {
      alert('Email/username atau password salah.');
    }
  });

  // Logout
  logoutBtn?.addEventListener('click', () => {
    localStorage.removeItem('loggedInUser');
    window.location.href = 'index.html';
  });

  // Link ke lowongan
  const handleLihatLowongan = (e) => {
    e.preventDefault();
    window.location.href = 'find-job.html';
  };
  lihatLowonganNav?.addEventListener('click', handleLihatLowongan);
  lihatLowonganFoot?.addEventListener('click', handleLihatLowongan);

  // --- Form Lamaran ---
  const applyModal = document.getElementById('applyModal');
  if (applyModal) {
    applyModal.addEventListener('show.bs.modal', (event) => {
      const btn = event.relatedTarget;
      const pos = btn?.getAttribute('data-posisi') || '';
      document.getElementById('posisiInput').value = pos;
    });

    document.getElementById('applyForm')?.addEventListener('submit', (e) => {
      e.preventDefault();
      const logged = JSON.parse(localStorage.getItem('loggedInUser'));
      if (!logged) {
        alert("Anda harus login terlebih dahulu!");
        return;
      }

      const cv = e.target.cv.files[0];
      const fol = e.target.portfolio.files[0];
      if (cv && cv.size > 2 * 1024 * 1024) return alert('CV melebihi 2 MB');
      if (fol && fol.size > 5 * 1024 * 1024) return alert('Portofolio melebihi 5 MB');

      setTimeout(() => {
        bootstrap.Modal.getInstance(applyModal).hide();
        new bootstrap.Modal(document.getElementById('successModal')).show();
        e.target.reset();
      }, 500);
    });

    const profesiSelect = document.getElementById('profesiSelect');
    const profesiLainnyaField = document.getElementById('profesiLainnyaField');
    profesiSelect?.addEventListener('change', () => {
      if (profesiSelect.value === 'Lainnya') {
        profesiLainnyaField?.classList.remove('d-none');
        profesiLainnyaField?.querySelector('input')?.setAttribute('required', 'true');
      } else {
        profesiLainnyaField?.classList.add('d-none');
        profesiLainnyaField?.querySelector('input')?.removeAttribute('required');
      }
    });
  }

  // Tampilkan data profil
  const updateProfileDisplay = (cur) => {
    const g = (id) => document.getElementById(id);
    g('profileUsername') && (g('profileUsername').textContent = cur.username || '-');
    g('profileEmail') && (g('profileEmail').textContent = cur.email || '-');
    g('profilePhone') && (g('profilePhone').textContent = cur.phone || '-');
    g('profileDOB') && (g('profileDOB').textContent = cur.DOB || '-');
    g('profileLocation') && (g('profileLocation').textContent = cur.location || '-');
    g('profileEducation') && (g('profileEducation').textContent = cur.education || '-');
    g('profileSummary') && (g('profileSummary').textContent = cur.summary || '-');
    g('experienceText') && (g('experienceText').textContent = cur.experience || '-');
    g('educationDetail') && (g('educationDetail').textContent = cur.educationDetail || '-');
    g('achievementText') && (g('achievementText').textContent = cur.achievement || '-');
    g('certificateText') && (g('certificateText').textContent = cur.certificate || '-');
    fillTags('softwareTags', cur.software);
    fillTags('languageTags', cur.languages);
    fillTags('interestTags', cur.interests);
  };

  const fillTags = (id, txt) => {
    const c = document.getElementById(id);
    if (!c) return;
    c.innerHTML = '';
    const items = (txt || '').split(',').map(t => t.trim()).filter(Boolean);
    if (!items.length) return c.innerHTML = '<span class="text-muted">-</span>';
    items.forEach(item => {
      const tag = document.createElement('span');
      tag.className = 'badge rounded-pill text-bg-primary me-1 mb-1';
      tag.textContent = item;
      c.appendChild(tag);
    });
  };

  user && updateProfileDisplay(user);
});

// Preview foto profil
document.getElementById('editProfileImage')?.addEventListener('change', function () {
  const reader = new FileReader();
  reader.onload = (e) => {
    document.getElementById('previewProfileImage').src = e.target.result;
    document.getElementById('profilePicture').src = e.target.result;
  };
  this.files[0] && reader.readAsDataURL(this.files[0]);
});

// Password hash
function hashPassword(str) {
  return btoa(unescape(encodeURIComponent(str)));
}