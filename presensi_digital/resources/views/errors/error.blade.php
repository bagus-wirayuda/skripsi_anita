<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Error {{ $statusCode ?? 'Sistem' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <style>
      .error-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f9ff 0%, #e8f4f8 100%);
        padding: 20px;
      }
      .error-card {
        background: white;
        border-radius: 16px;
        padding: 48px;
        max-width: 600px;
        width: 100%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
      }
      .error-icon {
        font-size: 80px;
        color: #c62828;
        margin-bottom: 24px;
      }
      .error-code {
        font-size: 72px;
        font-weight: bold;
        color: #c62828;
        margin: 0 0 16px 0;
        line-height: 1;
      }
      .error-title {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin: 0 0 16px 0;
      }
      .error-message {
        font-size: 16px;
        color: #666;
        margin: 0 0 32px 0;
        line-height: 1.6;
      }
      .error-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
      }
      .btn-error {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #c62828;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
      }
      .btn-error:hover {
        background: #b71c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(198, 40, 40, 0.3);
      }
      .btn-error-secondary {
        background: #f5f5f5;
        color: #333;
      }
      .btn-error-secondary:hover {
        background: #e0e0e0;
      }
    </style>
  </head>
  <body>
    <div class="error-container">
      <div class="error-card">
        <div class="error-icon">
          @if(($statusCode ?? 500) == 404)
            <i class="fa-solid fa-file-circle-question"></i>
          @elseif(($statusCode ?? 500) == 419)
            <i class="fa-solid fa-clock-rotate-left"></i>
          @elseif(($statusCode ?? 500) == 403)
            <i class="fa-solid fa-lock"></i>
          @elseif(($statusCode ?? 500) == 500)
            <i class="fa-solid fa-triangle-exclamation"></i>
          @else
            <i class="fa-solid fa-circle-exclamation"></i>
          @endif
        </div>
        
        <h1 class="error-code">{{ $statusCode ?? 'Error' }}</h1>
        
        <h2 class="error-title">
          @if(($statusCode ?? 500) == 404)
            Halaman Tidak Ditemukan
          @elseif(($statusCode ?? 500) == 419)
            Sesi Telah Berakhir
          @elseif(($statusCode ?? 500) == 403)
            Akses Ditolak
          @elseif(($statusCode ?? 500) == 500)
            Kesalahan Server
          @else
            Terjadi Kesalahan
          @endif
        </h2>
        
        <p class="error-message">
          @if(($statusCode ?? 500) == 404)
            Maaf, halaman yang Anda cari tidak ditemukan. Halaman mungkin telah dipindahkan atau dihapus.
          @elseif(($statusCode ?? 500) == 419)
            Sesi Anda telah berakhir karena tidak ada aktivitas dalam waktu yang lama. Silakan login kembali untuk melanjutkan.
          @elseif(($statusCode ?? 500) == 403)
            Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
          @elseif(($statusCode ?? 500) == 500)
            Terjadi kesalahan pada server. Tim teknis telah diberitahu dan sedang memperbaikinya. Silakan coba lagi nanti.
          @else
            Terjadi kesalahan pada sistem. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.
          @endif
        </p>
        
        <div class="error-actions">
          <a href="{{ route('index') }}" class="btn-error">
            <i class="fa-solid fa-house"></i>
            <span>Kembali ke Beranda</span>
          </a>
          
          @if(($statusCode ?? 500) == 419 || ($statusCode ?? 500) == 403)
            <a href="{{ route('login') }}" class="btn-error btn-error-secondary">
              <i class="fa-solid fa-right-to-bracket"></i>
              <span>Login Kembali</span>
            </a>
          @else
            <a href="javascript:history.back()" class="btn-error btn-error-secondary">
              <i class="fa-solid fa-arrow-left"></i>
              <span>Kembali</span>
            </a>
          @endif
        </div>
      </div>
    </div>
  </body>
</html>






