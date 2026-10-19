# Integrasi WhatsApp yang ditangguhkan

Sesuai permintaan pemilik, versi ini **tidak mengirim pesan** dan tidak memiliki
scheduler atau koneksi ke penyedia WhatsApp. Jangan menandai antrean sebagai
terkirim hanya karena tersimpan di database.

Yang sudah tersedia:

- `notification_queue`: satu antrean per siswa/tanggal saat petugas menyimpan alpa.
- Koreksi dari alpa membatalkan antrean berstatus pending; alpa kembali mengaktifkannya.
- Nomor orang tua dan teks pesan disiapkan; nomor kosong tetap terlihat untuk diperbaiki.
- Halaman Admin → Antrean Notifikasi menampilkan status sebenarnya.
- `services/WhatsAppGateway.php` menyediakan kontrak adapter. Implementasi bawaan
  sengaja melempar exception dan tidak mengirim apa pun.

Saat melanjutkan melalui AI, berikan nama penyedia dan dokumentasi resmi mengenai:

1. Base URL, endpoint pengiriman, metode autentikasi, dan contoh request/response.
2. Aturan format nomor, template yang disetujui, serta persetujuan penerima.
3. Webhook status, verifikasi signature, rate limit, retry, dan idempotency.
4. Nomor uji/sandbox. Simpan token di environment/config lokal, bukan di Git.

Instruksi lanjutan yang dapat digunakan:

> Hubungkan API WhatsApp [nama penyedia] sesuai dokumentasi terlampir ke antrean
> notification_queue dan interface WhatsAppGateway pada proyek ini. Pertahankan
> pembatalan akibat koreksi presensi. Buat worker CLI dengan locking, retry terbatas,
> verifikasi ulang status alpa dan nomor sebelum pengiriman, idempotency, log tanpa
> token, serta webhook bertanda tangan. Uji menggunakan sandbox terlebih dahulu.
> Jangan kirim ke nomor orang tua sebenarnya selama pengujian.

Worker berikutnya harus membedakan accepted/sent/delivered sesuai API, mencatat
provider_message_id, menangani timeout ambigu tanpa mengirim ulang secara buta,
dan tidak mengambil antrean cancelled. Jangan otomatis menganggap siswa yang belum
dipresensi sebagai alpa: petugas harus mengonfirmasi absensi terlebih dahulu.
