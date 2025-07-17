document.addEventListener('DOMContentLoaded', () => {
  // Data aplikasi
  const applications = [
    {
      title: 'Web Developer',
      status: 'Lamaran Diterima',
      location: 'Bandung',
      employment_type: 'Full-Time',
      salary: 'Negotiable',
      timeline: [
        { status: 'Lamaran Diterima', date: '13 Feb 2025, 10:44 WIB', badgeClass: 'bg-primary' },
        { status: 'Lamaran Diproses', date: '27 Feb 2025, 00:04 WIB', badgeClass: 'bg-warning text-dark' }
      ],
      modal_target: '#modal-template'
    },
    {
      title: 'UI/UX Designer Intern',
      status: 'Lamaran Diproses',
      location: 'Bandung',
      employment_type: 'Full-Time',
      salary: 'Negotiable',
      timeline: [
        { status: 'Lamaran Diproses', date: '28 Feb 2025, 10:00 WIB', badgeClass: 'bg-warning text-dark' },
        { status: 'Ditolak', date: '02 Mar 2025, 13:40 WIB', badgeClass: 'bg-danger' }
      ],
      modal_target: '#modal-template'
    },
    {
      title: 'Content Writer Freelance',
      status: 'Wawancara HR',
      location: 'Bandung',
      employment_type: 'Freelance',
      salary: 'Negotiable',
      timeline: [
        { status: 'Wawancara HR', date: '28 Feb 2025, 09:30 WIB', badgeClass: 'bg-info' }
      ],
      modal_target: '#modal-template'
    },
    {
      title: 'Marketing Specialist',
      status: 'Wawancara Pengguna',
      location: 'Bandung',
      employment_type: 'Full-Time',
      salary: 'Negotiable',
      timeline: [
        { status: 'Wawancara Pengguna', date: '26 Mar 2025, 10:15 WIB', badgeClass: 'bg-success' }
      ],
      modal_target: '#modal-template'
    },
    {
      title: 'Data Scientist',
      status: 'Diterima',
      location: 'Bandung',
      employment_type: 'Full-Time',
      salary: 'Negotiable',
      timeline: [
        { status: 'Diterima', date: '28 Mar 2025, 09:30 WIB', badgeClass: 'bg-success' }
      ],
      modal_target: '#modal-template'
    }
  ];

  // Kelas badge berdasarkan status
  const statusClass = {
    'Lamaran Diterima': 'bg-primary text-light',
    'Lamaran Diproses': 'bg-warning text-dark',
    'Wawancara HR': 'bg-info text-light',
    'Wawancara Pengguna': 'bg-success',
    'Ditolak': 'bg-danger'
  };

  // Ambil container untuk daftar lamaran
  const jobList = document.querySelector('#job-list');

  // Looping melalui aplikasi untuk menambahkannya ke daftar
  applications.forEach((application) => {
    const listItem = document.createElement('a');
    listItem.href = '#';
    listItem.classList.add('list-group-item', 'list-group-item-action', 'd-flex', 'justify-content-between', 'align-items-center');
    listItem.setAttribute('data-bs-toggle', 'modal');
    listItem.setAttribute('data-bs-target', application.modal_target);

    // Membuat markup untuk setiap lamaran
    listItem.innerHTML = `
      <div>
        <h6 class="mb-1 fw-semibold">${application.title}</h6>
        <small class="text-muted d-flex align-items-center gap-2 flex-wrap">
          <span><i class="bi bi-geo-alt-fill me-1"></i>${application.location}</span>
          <span><i class="bi bi-briefcase-fill me-1"></i>${application.employment_type}</span>
          <span><i class="bi bi-house-door-fill me-1"></i>Hybrid</span>
          <span><i class="bi bi-cash-stack me-1"></i>${application.salary}</span>
        </small>
      </div>
      <span class="badge ${statusClass[application.status]}">${application.status}</span>
    `;

    // Tambahkan item ke dalam list
    jobList.appendChild(listItem);
  });

  // Event listener untuk menampilkan detail modal
  const modalTemplate = document.getElementById('modal-template');
  modalTemplate.addEventListener('show.bs.modal', (event) => {
    const application = applications.find((app) => app.modal_target === event.relatedTarget.getAttribute('data-bs-target'));

    // Mengisi data modal
    modalTemplate.querySelector('#modal-title').textContent = application.title;
    modalTemplate.querySelector('#modal-location').innerHTML = `
      <span><i class="bi bi-geo-alt-fill me-1"></i>${application.location}</span>
      <span><i class="bi bi-briefcase-fill me-1"></i>${application.employment_type}</span>
      <span><i class="bi bi-cash-stack me-1"></i>${application.salary}</span>
    `;

    const timelineContainer = modalTemplate.querySelector('#modal-timeline');
    timelineContainer.innerHTML = ''; // Clear previous timeline

    // Menambahkan langkah timeline ke dalam modal
    application.timeline.forEach((step) => {
      const timelineStep = document.createElement('div');
      timelineStep.classList.add('timeline-step');

      timelineStep.innerHTML = `
        <span class="badge ${step.badgeClass} rounded-pill px-3 py-2 fw-semibold">${step.status}</span>
        <div class="text-muted mt-1">${step.date}</div>
      `;

      timelineContainer.appendChild(timelineStep);
    });
  });
});