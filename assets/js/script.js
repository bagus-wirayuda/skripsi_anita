/**
 * SDN 1 UNDUOLO - Global Frontend Interactions
 * All scripts are lightweight and component-driven to keep the static prototype simple.
 */

document.addEventListener('DOMContentLoaded', () => {
  setupSidebarNavigation();
  setupPresenceButtons();
  setupTeacherPresenceActions();
  setupGradeInputs();
  setupAlertButtons();
  setupPrintButtons();
  renderProgressChart();
  setupPresensiRadioButtons();
  setupNotesForm();
  setupStarRating();
  setupLaporanCharts();
});

/**
 * Highlight active sidebar navigation link.
 * Works by toggling the `is-active` class on click.
 */
function setupSidebarNavigation() {
  const sidebar = document.querySelector('.sidebar');
  if (!sidebar) return;

  const links = sidebar.querySelectorAll('.sidebar__link');
  links.forEach((link) => {
    link.addEventListener('click', () => {
      links.forEach((item) => item.classList.remove('is-active'));
      link.classList.add('is-active');
    });
  });

  // Detect current page via data attribute and highlight by default
  const currentPage = document.body.dataset.page;
  if (currentPage) {
    const activeLink = sidebar.querySelector(`[data-nav="${currentPage}"]`);
    activeLink?.classList.add('is-active');
  }
}

/**
 * Simulate the public QR attendance scan using alerts.
 */
function setupPresenceButtons() {
  const startBtn = document.querySelector('[data-action="start-presence"]');
  const endBtn = document.querySelector('[data-action="end-presence"]');
  const scanBox = document.querySelector('[data-action="scan-box"]');

  startBtn?.addEventListener('click', () => {
    alert('Presensi dimulai. Silakan arahkan QR Code ke kamera.');
  });

  endBtn?.addEventListener('click', () => {
    alert('Presensi selesai. Data berhasil direkam.');
  });

  scanBox?.addEventListener('click', () => {
    alert('QR Code terdeteksi! Presensi siswa berhasil.');
  });
}

/**
 * Teacher presence table - dummy mark attendance action.
 */
function setupTeacherPresenceActions() {
  const markButtons = document.querySelectorAll('[data-action="mark-presence"]');
  markButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const name = button.dataset.studentName ?? 'Siswa';
      alert(`Presensi ${name} ditandai hadir.`);
    });
  });
}

/**
 * Provide instant feedback when teachers input grades.
 */
function setupGradeInputs() {
  const inputs = document.querySelectorAll('input[data-grade-input]');
  inputs.forEach((input) => {
    input.addEventListener('change', () => {
      if (input.value.trim() !== '') {
        input.classList.add('is-filled');
        input.setAttribute('title', `Nilai terbaru: ${input.value}`);
      } else {
        input.classList.remove('is-filled');
        input.removeAttribute('title');
      }
    });
  });
}

/**
 * Generic alert handler for demo buttons (manual attendance, etc).
 */
function setupAlertButtons() {
  const buttons = document.querySelectorAll('[data-alert]');
  buttons.forEach((btn) => {
    btn.addEventListener('click', () => {
      alert(btn.dataset.alert ?? 'Aksi simulasi dijalankan.');
    });
  });
}

/**
 * Trigger browser print dialog for marked action buttons.
 */
function setupPrintButtons() {
  document.querySelectorAll('[data-print]').forEach((btn) => {
    btn.addEventListener('click', () => window.print());
  });
}

/**
 * Draw a lightweight dummy chart on the perkembangan canvas for parents.
 */
function renderProgressChart() {
  const canvas = document.getElementById('perkembanganChart');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const labels = ['Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
  const values = [82, 84, 86, 88, 90, 92];

  const chartWidth = canvas.width - 80;
  const chartHeight = canvas.height - 100;
  const originX = 60;
  const originY = canvas.height - 40;
  const barWidth = chartWidth / values.length - 20;
  const maxValue = Math.max(...values) + 5;

  // Background
  ctx.fillStyle = '#f5f9ff';
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  // Axes
  ctx.strokeStyle = '#c62828';
  ctx.lineWidth = 2;
  ctx.beginPath();
  ctx.moveTo(originX, originY);
  ctx.lineTo(originX, originY - chartHeight);
  ctx.moveTo(originX, originY);
  ctx.lineTo(originX + chartWidth, originY);
  ctx.stroke();

  ctx.fillStyle = '#c62828';
  ctx.font = '14px Poppins';
  ctx.fillText('Nilai', originX - 36, originY - chartHeight - 10);

  // Draw bars and labels
  values.forEach((value, index) => {
    const scaledHeight = (value / maxValue) * chartHeight;
    const x = originX + index * (barWidth + 20) + 10;
    const y = originY - scaledHeight;

    const gradient = ctx.createLinearGradient(x, y, x, originY);
    gradient.addColorStop(0, '#ef9a9a');
    gradient.addColorStop(1, '#c62828');

    ctx.fillStyle = gradient;
    ctx.fillRect(x, y, barWidth, scaledHeight);

    ctx.fillStyle = '#333333';
    ctx.fillText(labels[index], x + barWidth / 2 - 12, originY + 20);
    ctx.fillText(`${value}`, x + barWidth / 2 - 12, y - 10);
  });

  // Title
  ctx.font = '18px Poppins';
  ctx.fillStyle = '#c62828';
  ctx.fillText('Perkembangan Nilai Semester', originX, 30);
}

/**
 * Handle presensi radio buttons - save attendance with Hadir, Izin, Sakit, Alpa options.
 */
function setupPresensiRadioButtons() {
  const saveBtn = document.getElementById('savePresensi');
  if (!saveBtn) return;

  saveBtn.addEventListener('click', () => {
    const allRadioGroups = document.querySelectorAll('input[type="radio"][class="presensi-radio"]');
    const selectedStatuses = {};

    allRadioGroups.forEach((radio) => {
      if (radio.checked) {
        const studentId = radio.name.split('_')[1];
        selectedStatuses[studentId] = radio.value;
      }
    });

    const count = Object.keys(selectedStatuses).length;
    if (count > 0) {
      alert(`Presensi ${count} siswa berhasil disimpan!`);
      // Simulate status update in UI
      updatePresensiBadges(selectedStatuses);
    } else {
      alert('Silakan pilih status presensi untuk minimal satu siswa.');
    }
  });
}

/**
 * Update presensi badges based on selected status.
 */
function updatePresensiBadges(selectedStatuses) {
  // This would update the UI in a real app
  console.log('Updated presensi statuses:', selectedStatuses);
}

/**
 * Handle notes form submission.
 */
function setupNotesForm() {
  const notesForm = document.getElementById('notesForm');
  if (!notesForm) return;

  notesForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(notesForm);
    const siswa = document.getElementById('selectSiswa');
    const kelas = document.getElementById('selectKelas');
    
    if (!siswa?.value) {
      alert('Silakan pilih siswa terlebih dahulu.');
      return;
    }

    const studentName = siswa.options[siswa.selectedIndex].text;
    const className = kelas?.value || '5A';
    
    alert(`Catatan untuk ${studentName} (${className}) berhasil dikirim. Catatan akan tampil di halaman orang tua.`);
    
    // Reset form but keep date
    const tanggalInput = document.getElementById('tanggalNote');
    const savedDate = tanggalInput?.value;
    notesForm.reset();
    if (tanggalInput && savedDate) {
      tanggalInput.value = savedDate;
    }
  });
}

/**
 * Handle star rating for daily assessment.
 */
function setupStarRating() {
  const saveBtn = document.getElementById('savePenilaian');
  if (!saveBtn) return;

  // Update status when star is clicked
  const starRatings = document.querySelectorAll('.star-rating input[type="radio"]');
  starRatings.forEach((star) => {
    star.addEventListener('change', (event) => {
      const ratingValue = event.target.value;
      const studentId = event.target.name.split('_')[1];
      const row = event.target.closest('tr');
      const statusCell = row.querySelector('td:last-child');
      
      if (statusCell) {
        const badge = statusCell.querySelector('.badge');
        if (badge) {
          badge.textContent = `Sudah dinilai (${ratingValue}★)`;
          badge.style.background = 'rgba(76, 175, 80, 0.15)';
          badge.style.color = '#2e7d32';
        }
      }
    });
  });

  saveBtn.addEventListener('click', () => {
    const allRatings = document.querySelectorAll('.star-rating input[type="radio"]:checked');
    const ratings = {};

    allRatings.forEach((radio) => {
      const studentId = radio.name.split('_')[1];
      ratings[studentId] = radio.value;
    });

    const count = Object.keys(ratings).length;
    if (count > 0) {
      alert(`Penilaian harian ${count} siswa berhasil disimpan!`);
      console.log('Ratings saved:', ratings);
    } else {
      alert('Silakan berikan penilaian untuk minimal satu siswa.');
    }
  });
}

/**
 * Render charts for laporan page.
 */
function setupLaporanCharts() {
  renderKehadiranChart();
  renderNilaiChart();
}

/**
 * Render kehadiran chart for laporan.
 */
function renderKehadiranChart() {
  const canvas = document.getElementById('chartKehadiran');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
  const values = [92, 94, 96, 94];

  const chartWidth = canvas.width - 80;
  const chartHeight = canvas.height - 60;
  const originX = 60;
  const originY = canvas.height - 30;
  const barWidth = chartWidth / values.length - 20;
  const maxValue = 100;

  // Background
  ctx.fillStyle = '#f5f9ff';
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  // Draw bars
  values.forEach((value, index) => {
    const scaledHeight = (value / maxValue) * chartHeight;
    const x = originX + index * (barWidth + 20) + 10;
    const y = originY - scaledHeight;

    const gradient = ctx.createLinearGradient(x, y, x, originY);
    gradient.addColorStop(0, '#81c784');
    gradient.addColorStop(1, '#4caf50');

    ctx.fillStyle = gradient;
    ctx.fillRect(x, y, barWidth, scaledHeight);

    ctx.fillStyle = '#333333';
    ctx.font = '12px Poppins';
    ctx.fillText(labels[index], x + barWidth / 2 - 30, originY + 15);
    ctx.fillText(`${value}%`, x + barWidth / 2 - 12, y - 5);
  });

  // Title
  ctx.font = '14px Poppins';
  ctx.fillStyle = '#c62828';
  ctx.fillText('Tren Kehadiran (%)', 10, 20);
}

/**
 * Render nilai chart for laporan.
 */
function renderNilaiChart() {
  const canvas = document.getElementById('chartNilai');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
  const values = [82, 84, 86, 85];

  const chartWidth = canvas.width - 80;
  const chartHeight = canvas.height - 60;
  const originX = 60;
  const originY = canvas.height - 30;
  const barWidth = chartWidth / values.length - 20;
  const maxValue = 100;

  // Background
  ctx.fillStyle = '#f5f9ff';
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  // Draw bars
  values.forEach((value, index) => {
    const scaledHeight = (value / maxValue) * chartHeight;
    const x = originX + index * (barWidth + 20) + 10;
    const y = originY - scaledHeight;

    const gradient = ctx.createLinearGradient(x, y, x, originY);
    gradient.addColorStop(0, '#ef9a9a');
    gradient.addColorStop(1, '#c62828');

    ctx.fillStyle = gradient;
    ctx.fillRect(x, y, barWidth, scaledHeight);

    ctx.fillStyle = '#333333';
    ctx.font = '12px Poppins';
    ctx.fillText(labels[index], x + barWidth / 2 - 30, originY + 15);
    ctx.fillText(`${value}`, x + barWidth / 2 - 12, y - 5);
  });

  // Title
  ctx.font = '14px Poppins';
  ctx.fillStyle = '#c62828';
  ctx.fillText('Tren Nilai Rata-rata', 10, 20);
}

