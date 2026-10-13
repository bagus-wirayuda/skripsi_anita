<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Profil Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body data-page="profil">
    <a class="btn btn--login btn--login-fixed" href="login.php">
      <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
      <span>Login</span>
    </a>
    <header class="profile-hero">
      <div class="profile-hero__content">
        <div class="profile-hero__header">
          <span class="profile-hero__tag">SDN 1 UNDUOLO</span>
        </div>
        
        <h1>Membangun Generasi Cerdas dan Berkarakter</h1>
        <p>
          SDN 1 UNDUOLO merupakan sekolah dasar unggulan yang mengedepankan pembelajaran aktif,
          karakter mulia, dan teknologi terintegrasi. Kami percaya setiap anak berhak mendapatkan
          pendampingan terbaik untuk meraih cita-citanya.
        </p>
        <div class="cta-group">
          <a class="btn" href="register.php">
            <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
            <span>Daftar Siswa Baru</span>
          </a>
          <a class="btn" href="register.php">
            <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
            <span>Daftar Siswa Pindahan</span>
          </a>
        </div>
      </div>
      <div class="profile-hero__visual card">
        <p class="card__title">
          <i class="fa-solid fa-school"></i> Sekilas Fasilitas
        </p>
        <ul class="profile-hero__list">
          <li><i class="fa-solid fa-check"></i> Kelas interaktif dengan perangkat multimedia.</li>
          <li><i class="fa-solid fa-check"></i> Perpustakaan dan laboratorium sains modern.</li>
          <li><i class="fa-solid fa-check"></i> Area bermain aman dan ruang kegiatan seni.</li>
        </ul>
        <p class="profile-hero__note">
          <i class="fa-solid fa-circle-info"></i>
          Kunjungan sekolah dapat dilakukan setiap Senin-Kamis pukul 09.00–12.00 WITA.
        </p>
      </div>
    </header>

    <main class="profile-main">
      <section class="profile-section" aria-labelledby="profil-unggulan">
        <h2 id="profil-unggulan" class="section-title">Mengapa Memilih SDN 1 UNDUOLO?</h2>
        <div class="profile-grid">
          <article class="card">
            <p class="card__title"><i class="fa-solid fa-graduation-cap"></i> Prestasi Akademik</p>
            <p>
              Rata-rata nilai ujian di atas standar nasional dengan dukungan program pengayaan
              individu untuk setiap siswa.
            </p>
          </article>
          <article class="card">
            <p class="card__title"><i class="fa-solid fa-handshake-angle"></i> Kolaborasi Orang Tua</p>
            <p>
              Sistem informasi orang tua memudahkan pemantauan presensi, nilai, dan laporan kegiatan
              harian secara real time.
            </p>
          </article>
          <article class="card">
            <p class="card__title"><i class="fa-solid fa-palette"></i> Pengembangan Bakat</p>
            <p>
              Ekstrakurikuler seni, olahraga, dan sains dirancang untuk menumbuhkan kreativitas dan
              kepercayaan diri siswa.
            </p>
          </article>
        </div>
      </section>

      <section class="profile-section" aria-labelledby="profil-visi">
        <div class="profile-feature">
          <div class="profile-feature__content card">
            <p class="card__title"><i class="fa-solid fa-bullseye"></i> Visi & Misi</p>
            <p>
              Menjadi sekolah dasar unggul, ramah anak, dan adaptif terhadap perkembangan teknologi,
              dengan fokus pada karakter religius, nasionalis, mandiri, gotong royong, dan integritas.
            </p>
            <ul class="profile-feature__list">
              <li>Mengembangkan pembelajaran berbasis proyek dan STEAM.</li>
              <li>Memperkuat sinergi dengan orang tua dan masyarakat sekitar.</li>
              <li>Menumbuhkan nilai kepemimpinan dan kemandirian sejak dini.</li>
            </ul>
          </div>
          <aside class="profile-stat card">
            <p class="card__title"><i class="fa-solid fa-chart-line"></i> Data Singkat</p>
            <dl>
              <div>
                <dt>Jumlah Siswa</dt>
                <dd>420 siswa aktif</dd>
              </div>
              <div>
                <dt>Jumlah Guru</dt>
                <dd>35 pendidik profesional</dd>
              </div>
              <div>
                <dt>Program Unggulan</dt>
                <dd>Literasi digital, green school, kelas bilingual</dd>
              </div>
            </dl>
          </aside>
        </div>
      </section>

      <section class="profile-section" aria-labelledby="profil-alur">
        <h2 id="profil-alur" class="section-title">Alur Pendaftaran Siswa Baru</h2>
        <div class="profile-steps">
          <article class="card">
            <p class="card__title"><span>1.</span> Isi Formulir Online</p>
            <p>Lengkapi data orang tua dan calon siswa melalui halaman pendaftaran.</p>
            <a class="btn" href="register.php">Buka Formulir</a>
          </article>
          <article class="card">
            <p class="card__title"><span>2.</span> Serahkan Berkas</p>
            <p>Bawa dokumen pendukung ke sekolah sesuai jadwal yang dikirim via email.</p>
          </article>
          <article class="card">
            <p class="card__title"><span>3.</span> Aktivasi Akun</p>
            <p>Admin akan membantu aktivasi akun orang tua untuk memantau perkembangan anak.</p>
          </article>
        </div>
      </section>
    </main>

    <footer class="profile-footer">
      <div class="profile-footer__content">
        <p>&copy; 2025 SDN 1 UNDUOLO. Seluruh hak cipta dilindungi.</p>
        <div class="profile-footer__links">
          <a href="register.php">Pendaftaran</a>
          <a href="presensi.php">Presensi</a>
          <a href="login.php">Login Sistem</a>
        </div>
      </div>
    </footer>

    <script src="assets/js/script.js"></script>
  </body>
</html>