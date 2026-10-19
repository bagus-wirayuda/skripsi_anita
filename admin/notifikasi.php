<?php
require __DIR__.'/../includes/ui.php';requireRole(['admin']);pageStart('Antrean Notifikasi','Pengiriman WhatsApp ditangguhkan. API penyedia belum dihubungkan.');
echo '<div class="message">Entri alpa menyiapkan satu notifikasi per siswa per tanggal. Tidak ada pesan yang dikirim. Koreksi status membatalkan antrean yang belum dikirim.</div>';
tableView(['Tanggal','Siswa','Nomor HP','Pesan','Status'],array_map('array_values',dbAll('SELECT q.tanggal,s.nama_lengkap,q.nomor_hp,q.pesan,q.status FROM notification_queue q JOIN siswa s ON s.id=q.siswa_id ORDER BY q.created_at DESC')));pageEnd();
