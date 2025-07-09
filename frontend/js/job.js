document.addEventListener("DOMContentLoaded", function () {
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
});