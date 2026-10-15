<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SDN 1 UNDUOLO - Presensi Digital</title>
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
  </head>
  <body data-page="presensi">
    <main class="attendance-layout">
      <section class="attendance-wrapper">
        
        <!-- Header Section -->
        <header class="presensi-header">
          <div class="presensi-header__content">
            <div>
              <h1 class="presensi-header__title">
                <i class="fa-solid fa-qrcode"></i>
                Presensi Digital
              </h1>
              <p class="presensi-header__subtitle">Sistem Presensi QR Code SDN 1 UNDUOLO</p>
            </div>
            <!-- Tombol Input Manual -->
            <div class="manual-input-container">
              <button 
                type="button" 
                id="btn-open-manual-modal"
                class="btn"
              >
                <i class="fa-solid fa-keyboard"></i> 
                <span>Input Manual QR Code</span>
              </button>
            </div>
          </div>
        </header>

        <!-- Attendance Panel - Grid Layout -->
        <div class="attendance-panel">
          <!-- Kamera Section (Kiri) -->
          <div class="attendance-camera card" data-action="scan-box">
            <h3>
              <i class="fa-solid fa-qrcode"></i> 
              <span>Scanner QR Code</span>
            </h3>
            <!-- QR Scanner Container -->
            <div id="qr-reader"></div>
            
            <!-- Loading/Status Message (Processing) -->
            <div id="qr-status">
              <p id="qr-status-text"></p>
            </div>

            <!-- Fallback placeholder (hidden when camera is active) -->
            <div id="qr-placeholder">
              <i class="fa-solid fa-camera-rotate"></i>
              <p>Area Kamera Pendeteksi QR/Barcode</p>
              <small>Memuat kamera...</small>
            </div>
          </div>

          <!-- Status Section (Kanan) -->
          <div class="attendance-status card">
            <h3>
              <i class="fa-solid fa-clipboard-check"></i> 
              <span>Status Presensi</span>
            </h3>
            <div id="status-container">
              <div id="status-placeholder">
                <i class="fa-solid fa-qrcode"></i>
                <p>Status presensi akan muncul di sini</p>
                <small>Scan QR code atau input manual untuk mulai</small>
              </div>
              
              <!-- Status Success (Hidden by default) -->
              <div id="status-success">
                <div>
                  <div id="status-icon-container">
                    <i class="fa-solid fa-check-circle" id="status-icon"></i>
                  </div>
                  <h2 id="status-title">Absen Berhasil</h2>
                  <p class="status-hadir">Status: Hadir</p>
                  <p id="status-message"></p>
                </div>
                <div class="status-data-container">
                  <!-- Data Items - Stack vertical for better mobile experience -->
                  <div class="status-data-item">
                    <span>Nama Siswa</span>
                    <span id="status-nama-siswa">-</span>
                  </div>
                  
                  <div class="status-data-item">
                    <span>NISN</span>
                    <span id="status-nisn">-</span>
                  </div>
                  
                  <div class="status-data-item">
                    <span>Kelas</span>
                    <span id="status-kelas">-</span>
                  </div>
                  
                  <div class="status-data-item">
                    <span>Waktu Absen</span>
                    <span id="status-waktu">-</span>
                  </div>
                  
                  <div class="status-data-item">
                    <span>Tanggal</span>
                    <span id="status-tanggal">-</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Manual Input Modal -->
    <div id="manual-input-modal" class="presensi-modal">
      <div class="presensi-modal-overlay" id="manual-modal-overlay"></div>
      <div class="presensi-modal-content">
        <div class="form-group">
          <h2>
            <i class="fa-solid fa-keyboard"></i> Input Manual QR Code
          </h2>
          <p>Masukkan kode QR Code secara manual</p>
        </div>
        <div class="form-group">
          <label for="manualCode">
            Kode QR Code
          </label>
          <input
            id="manualCode"
            type="text"
            class="input-inline"
            placeholder="Contoh: SDN1-UNDUOLO-2024001"
            aria-label="Kode presensi manual"
          />
        </div>
        <div class="presensi-modal-actions">
          <button 
            type="button" 
            class="btn" 
            id="btn-submit-manual"
          >
            <span>Kirim</span>
          </button>
          <button 
            type="button" 
            class="btn btn--ghost" 
            id="btn-close-manual-modal"
          >
            <span>Batal</span>
          </button>
        </div>
      </div>
    </div>

    <!-- html5-qrcode library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    <script>
      (function() {
        'use strict';

        // Get CSRF token from meta tag or cookie
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
          || document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1];

        let html5QrCode = null;
        let isScanning = false;
        let isProcessing = false;
        let lastScannedCode = null;
        let lastScanTime = 0;
        let scanDebounceTimer = null;

        // QR Scanner container elements
        const qrReader = document.getElementById('qr-reader');
        const qrPlaceholder = document.getElementById('qr-placeholder');
        const qrStatus = document.getElementById('qr-status');
        const qrStatusText = document.getElementById('qr-status-text');

        /**
         * Initialize QR Code Scanner
         */
        function initQRScanner() {
          // Reset state before initializing
          isProcessing = false;
          lastScannedCode = null;
          lastScanTime = 0;
          
          if (scanDebounceTimer) {
            clearTimeout(scanDebounceTimer);
            scanDebounceTimer = null;
          }

          // If already initialized and scanning, don't reinitialize
          if (html5QrCode && isScanning) {
            console.log('Scanner already initialized and scanning');
            return;
          }

          // Clear existing scanner if any
          if (html5QrCode) {
            try {
              html5QrCode.clear();
            } catch (e) {
              console.warn('Error clearing existing scanner:', e);
            }
            html5QrCode = null;
          }

          // Create new scanner instance
          html5QrCode = new Html5Qrcode("qr-reader");
          console.log('QR Scanner initialized');

          // Configuration for QR scanning - responsive qrbox size (LEBIH LEBAR)
          const qrReaderElement = document.getElementById('qr-reader');
          // Perbesar kotak scanning: 85% lebar layar, maksimal 500px, minimal 350px
          const qrBoxSize = Math.max(350, Math.min(500, Math.min(window.innerWidth * 0.85, window.innerHeight * 0.6)));
          
          const config = {
            fps: 10, // Frames per second
            qrbox: { width: qrBoxSize, height: qrBoxSize }, // Scanning box size - lebih lebar untuk banyak siswa
            aspectRatio: 1.0, // Aspect ratio
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
            videoConstraints: {
              facingMode: "environment" // Use back camera on mobile
            },
            disableFlip: false // Allow flipping camera
          };

          // Start scanning - try environment first, fallback to user
          html5QrCode.start(
            { facingMode: "environment" }, // Prefer back camera
            config,
            onScanSuccess,
            onScanError
          ).then(() => {
            // Camera started successfully
            console.log('Back camera started successfully');
            isScanning = true;
            qrPlaceholder.style.display = 'none';
            qrReader.style.display = 'block';
            qrStatus.style.display = 'none';
          }).catch((err) => {
            // Try with user camera (front camera) as fallback
            console.warn('Back camera failed, trying front camera:', err);
            html5QrCode.start(
              { facingMode: "user" }, // Front camera fallback
              config,
              onScanSuccess,
              onScanError
            ).then(() => {
              isScanning = true;
              qrPlaceholder.style.display = 'none';
              qrReader.style.display = 'block';
              qrStatus.style.display = 'none';
            }).catch((fallbackErr) => {
              // Both cameras failed
              console.error('Camera initialization error:', fallbackErr);
              qrStatus.style.display = 'block';
              showStatus('Gagal mengakses kamera. Pastikan izin kamera telah diberikan.', 'error');
              qrPlaceholder.className = 'qr-error-placeholder';
              qrPlaceholder.innerHTML = `
                <i class="fa-solid fa-camera-slash"></i>
                <p>Gagal mengakses kamera</p>
                <small>${fallbackErr.message || 'Pastikan izin kamera telah diberikan'}</small>
                <button onclick="location.reload()" class="btn">
                  <i class="fa-solid fa-refresh"></i> Coba Lagi
                </button>
              `;
            });
          });
        }

        /**
         * Handle successful QR code scan with debouncing and validation
         */
        function onScanSuccess(decodedText, decodedResult) {
          // Clean and trim QR data
          if (!decodedText || typeof decodedText !== 'string') {
            console.warn('Invalid QR data received:', decodedText);
            return;
          }

          const cleanedQRData = decodedText.trim();
          
          if (!cleanedQRData) {
            console.warn('Empty QR data after trimming');
            return;
          }

          console.log('QR Code scanned:', cleanedQRData);

          // Prevent multiple scans of the same QR code within 2 seconds
          // (Lebih pendek karena banyak siswa akan scan berturut-turut)
          const now = Date.now();
          const timeSinceLastScan = now - lastScanTime;
          
          // If same QR code and less than 2 seconds, ignore (untuk mencegah scan ganda dari siswa yang sama)
          if (cleanedQRData === lastScannedCode && timeSinceLastScan < 2000) {
            console.log('Ignoring duplicate scan of same QR code');
            return;
          }

          // If already processing, ignore
          if (isProcessing) {
            console.log('Already processing a scan, ignoring');
            return;
          }

          // Clear any existing debounce timer
          if (scanDebounceTimer) {
            clearTimeout(scanDebounceTimer);
            scanDebounceTimer = null;
          }

          // Debounce: wait 300ms to ensure this is a stable scan (lebih cepat untuk multiple scans)
          scanDebounceTimer = setTimeout(() => {
            // Double-check we're not processing
            if (isProcessing) {
              console.log('Processing flag set during debounce, ignoring');
              return;
            }

            // Update last scanned code and time BEFORE processing
            lastScannedCode = cleanedQRData;
            lastScanTime = Date.now();
            
            // Set processing flag immediately to prevent duplicate processing
            isProcessing = true;

            console.log('Processing QR code:', cleanedQRData);

            // Clear previous status (data siswa sebelumnya akan diganti)
            clearStatus();

            // Show processing status
            showStatus('Memproses QR code...', 'processing');

            // KAMERA TETAP HIDUP - Tidak perlu stop scanner
            // Langsung kirim data ke server tanpa menghentikan kamera
            console.log('Sending QR data to server (camera stays active)');
            sendQRData(cleanedQRData);
          }, 300);
        }

        /**
         * Handle scan errors (not critical, just for logging)
         */
        function onScanError(errorMessage) {
          // Ignore common scanning errors (they're expected during scanning)
          // Only log if it's a critical error
          if (errorMessage && !errorMessage.includes('NotFoundError')) {
            // console.log('Scan error:', errorMessage);
          }
        }

        /**
         * Stop QR scanner - Return promise for better control
         */
        function stopScanner() {
          if (html5QrCode && isScanning) {
            isScanning = false; // Set flag immediately to prevent new scans
            return html5QrCode.stop().then(() => {
              console.log('Scanner stopped successfully');
              return Promise.resolve();
            }).catch((err) => {
              console.error('Error stopping scanner:', err);
              // Even if stop fails, mark as not scanning
              isScanning = false;
              return Promise.reject(err);
            });
          }
          return Promise.resolve();
        }

        /**
         * Send QR data to Laravel backend
         */
        async function sendQRData(qrData) {
          // Trim and clean QR data
          qrData = (qrData || '').toString().trim();
          
          if (!qrData) {
            console.error('QR data is empty');
            isProcessing = false;
            showStatus('QR Code kosong atau tidak valid', 'error');
            clearStatus();
            
            // Reset last scanned code agar bisa scan lagi
            lastScannedCode = null;
            lastScanTime = 0;
            
            // KAMERA TETAP HIDUP - Hanya reset error status
            setTimeout(() => {
              qrStatus.style.display = 'none';
              // Status error akan hilang, kamera tetap aktif untuk scan lagi
            }, 3000);
            return;
          }

          console.log('Sending QR data to server:', qrData);

          try {
            const response = await fetch('{{ route("presensi.scan") }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
              },
              body: JSON.stringify({
                qr_data: qrData
              })
            });

            // Check if response is ok
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response from server:', data);

            if (data.success) {
              // Show success status in right panel (data akan update otomatis)
              const alreadyPresent = data.already_present || false;
              showSuccessStatus(data.data, alreadyPresent);
              
              // KAMERA TETAP HIDUP - Tidak perlu reset lastScannedCode di sini
              // Biarkan reset di showSuccessStatus dengan delay
            } else {
              // Server returned error
              isProcessing = false;
              const errorMessage = data.message || 'Terjadi kesalahan saat memproses presensi.';
              console.error('Server error:', errorMessage);
              showStatus(errorMessage, 'error');
              
              // Keep status cleared (show placeholder)
              clearStatus();
              
              // Reset last scanned code on error agar bisa coba lagi
              lastScannedCode = null;
              lastScanTime = 0;
              
              // KAMERA TETAP HIDUP - Hanya reset error status setelah beberapa detik
              // Tidak perlu restart scanner, biarkan user scan lagi
              setTimeout(() => {
                qrStatus.style.display = 'none';
                // Status error akan hilang, kamera tetap aktif
              }, 3000);
            }
          } catch (error) {
            console.error('Error sending QR data:', error);
            isProcessing = false;
            
            // More detailed error message
            let errorMessage = 'Gagal mengirim data. ';
            if (error.message) {
              errorMessage += error.message;
            } else {
              errorMessage += 'Periksa koneksi internet.';
            }
            
            showStatus(errorMessage, 'error');
            
            // Keep status cleared (show placeholder)
            clearStatus();
            
            // Reset last scanned code on error agar bisa coba lagi
            lastScannedCode = null;
            lastScanTime = 0;
            
            // KAMERA TETAP HIDUP - Hanya reset error status
            // Tidak perlu restart scanner
            setTimeout(() => {
              qrStatus.style.display = 'none';
              // Status error akan hilang, kamera tetap aktif untuk scan lagi
            }, 3000);
          }
        }

        /**
         * Show status message
         */
        function showStatus(message, type = 'info') {
          qrStatus.style.display = 'block';
          qrStatusText.textContent = message;
          
          // Remove previous type classes
          qrStatus.className = 'qr-status';
          
          // Add type-specific styling
          switch(type) {
            case 'success':
              qrStatusText.style.color = '#28a745';
              break;
            case 'error':
              qrStatusText.style.color = '#dc3545';
              break;
            case 'processing':
              qrStatusText.style.color = '#007bff';
              break;
            default:
              qrStatusText.style.color = '#6c757d';
          }
        }

        /**
         * Reset scanner to initial state
         */
        function resetScanner() {
          qrStatus.style.display = 'none';
          isProcessing = false;
          
          // Clear debounce timer
          if (scanDebounceTimer) {
            clearTimeout(scanDebounceTimer);
            scanDebounceTimer = null;
          }
          
          // Reset last scanned code after delay
          setTimeout(() => {
            lastScannedCode = null;
            lastScanTime = 0;
          }, 3000);
          
          // Don't clear and reinitialize if already scanning
          if (isScanning) {
            return; // Scanner is already running
          }
          
          // Reinitialize scanner only if not scanning
          if (html5QrCode) {
            html5QrCode.clear().catch(err => {
              console.warn('Error clearing scanner:', err);
            });
            html5QrCode = null;
          }
          
          // Restart after a brief delay
          setTimeout(() => {
            if (!isScanning && !isProcessing) {
              initQRScanner();
            }
          }, 1000);
        }

        // Initialize scanner when page loads
        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', initQRScanner);
        } else {
          initQRScanner();
        }

        /**
         * Show success status in right panel (not modal)
         */
        function showSuccessStatus(studentData, alreadyPresent = false) {
          const statusPlaceholder = document.getElementById('status-placeholder');
          const statusSuccess = document.getElementById('status-success');
          const statusTitle = document.getElementById('status-title');
          const statusMessage = document.getElementById('status-message');
          const statusNama = document.getElementById('status-nama-siswa');
          const statusNisn = document.getElementById('status-nisn');
          const statusKelas = document.getElementById('status-kelas');
          const statusWaktu = document.getElementById('status-waktu');
          const statusTanggal = document.getElementById('status-tanggal');

          // Populate status with data
          statusNama.textContent = studentData.nama_siswa || '-';
          statusNisn.textContent = studentData.nisn || '-';
          statusKelas.textContent = studentData.kelas || '-';
          
          // Format waktu: HH:MM:SS -> HH:MM
          const waktuFormatted = studentData.waktu_presensi 
            ? studentData.waktu_presensi.substring(0, 5) 
            : '-';
          statusWaktu.textContent = waktuFormatted;
          
          // Tanggal - tampilkan waktu absen lengkap jika ada
          const tanggalDisplay = studentData.waktu_absen_lengkap 
            ? studentData.waktu_absen_lengkap 
            : (studentData.tanggal_full || studentData.tanggal || '-');
          statusTanggal.textContent = tanggalDisplay;

          // Update title, icon, and message based on whether already present
          const statusIcon = document.getElementById('status-icon');
          const statusHadirP = statusSuccess.querySelector('.status-hadir');
          
          if (alreadyPresent) {
            statusTitle.textContent = 'Sudah Absen';
            statusTitle.className = 'status-already-present';
            if (statusIcon) {
              statusIcon.className = 'fa-solid fa-info-circle';
            }
            if (statusHadirP) {
              statusHadirP.classList.add('status-warning');
            }
            statusMessage.textContent = 'Presensi untuk hari ini sudah tercatat sebelumnya';
            statusMessage.style.color = '#856404';
          } else {
            statusTitle.textContent = 'Absen Berhasil';
            statusTitle.className = '';
            if (statusIcon) {
              statusIcon.className = 'fa-solid fa-check-circle';
            }
            if (statusHadirP) {
              statusHadirP.classList.remove('status-warning');
            }
            statusMessage.textContent = 'Presensi baru berhasil direkam';
            statusMessage.style.color = '#155724';
          }

          // Hide placeholder, show success status
          statusPlaceholder.style.display = 'none';
          statusSuccess.style.display = 'block';

          // Hide processing status message
          qrStatus.style.display = 'none';

          // Reset processing flag agar bisa scan siswa berikutnya
          isProcessing = false;
          
          // Reset lastScannedCode setelah delay singkat agar siswa yang sama bisa scan lagi nanti
          // Tapi siswa berbeda bisa langsung scan
          setTimeout(() => {
            // Reset last scanned code setelah 1.5 detik
            // Ini memungkinkan siswa berbeda untuk scan langsung
            lastScannedCode = null;
            lastScanTime = 0;
          }, 1500);
          
          // KAMERA TETAP HIDUP - Tidak perlu restart scanner
          // Scanner tetap aktif untuk scan siswa berikutnya
          console.log('Presensi berhasil, kamera tetap aktif untuk scan berikutnya');
        }

        /**
         * Clear status (when new scan starts)
         */
        function clearStatus() {
          const statusPlaceholder = document.getElementById('status-placeholder');
          const statusSuccess = document.getElementById('status-success');
          
          statusPlaceholder.style.display = 'block';
          statusSuccess.style.display = 'none';
        }

        /**
         * Open manual input modal
         */
        function openManualModal() {
          const modal = document.getElementById('manual-input-modal');
          const input = document.getElementById('manualCode');
          
          if (!modal) {
            console.error('Manual input modal not found');
            return;
          }
          
          modal.style.display = 'flex';
          
          // Clear any previous input and errors
          if (input) {
            input.value = '';
            input.style.borderColor = '#ced4da';
            
            // Focus input after modal animation
            setTimeout(() => {
              input.focus();
              input.select();
            }, 150);
          }
          
          // Remove any error messages
          const errorMsg = document.getElementById('manual-error-msg');
          if (errorMsg) {
            errorMsg.remove();
          }
        }

        /**
         * Close manual input modal
         */
        function closeManualModal() {
          const modal = document.getElementById('manual-input-modal');
          const input = document.getElementById('manualCode');
          if (modal) {
            modal.style.display = 'none';
          }
          if (input) {
            input.value = '';
            input.style.borderColor = '#ced4da';
          }
          
          // Remove error messages
          const errorMsg = document.getElementById('manual-error-msg');
          if (errorMsg) {
            errorMsg.remove();
          }
        }

        /**
         * Handle manual input submission
         */
        function handleManualInput() {
          const manualCodeInput = document.getElementById('manualCode');
          
          if (!manualCodeInput) {
            console.error('Manual code input not found');
            return;
          }

          const manualCode = manualCodeInput.value.trim();

          if (!manualCode) {
            // Show error message - don't close modal, let user fix it
            manualCodeInput.style.borderColor = '#dc3545';
            manualCodeInput.focus();
            
            // Show error indicator in modal
            let errorMsg = document.getElementById('manual-error-msg');
            if (!errorMsg) {
              errorMsg = document.createElement('p');
              errorMsg.id = 'manual-error-msg';
              errorMsg.style.color = '#dc3545';
              errorMsg.style.fontSize = '0.875rem';
              errorMsg.style.marginTop = '0.5rem';
              manualCodeInput.parentNode.appendChild(errorMsg);
            }
            errorMsg.textContent = 'Masukkan kode QR Code terlebih dahulu';
            
            // Remove error after 3 seconds
            setTimeout(() => {
              if (errorMsg) {
                errorMsg.remove();
              }
              manualCodeInput.style.borderColor = '#ced4da';
            }, 3000);
            
            return;
          }

          if (isProcessing) {
            // Show error indicator
            manualCodeInput.style.borderColor = '#ffc107';
            let errorMsg = document.getElementById('manual-error-msg');
            if (!errorMsg) {
              errorMsg = document.createElement('p');
              errorMsg.id = 'manual-error-msg';
              errorMsg.style.color = '#ffc107';
              errorMsg.style.fontSize = '0.875rem';
              errorMsg.style.marginTop = '0.5rem';
              manualCodeInput.parentNode.appendChild(errorMsg);
            }
            errorMsg.textContent = 'Sedang memproses presensi sebelumnya. Tunggu sebentar...';
            
            setTimeout(() => {
              if (errorMsg) {
                errorMsg.remove();
              }
              manualCodeInput.style.borderColor = '#ced4da';
            }, 3000);
            return;
          }

          // Clear previous status
          clearStatus();

          // Remove any error messages
          const errorMsg = document.getElementById('manual-error-msg');
          if (errorMsg) {
            errorMsg.remove();
          }
          manualCodeInput.style.borderColor = '#ced4da';

          // Close manual modal first
          closeManualModal();

          // Process after a short delay to allow modal to close
          setTimeout(() => {
            isProcessing = true;
            qrStatus.style.display = 'block';
            showStatus('Memproses kode presensi...', 'processing');

            // Send manual code to server (same endpoint as QR scan)
            sendQRData(manualCode);
          }, 300);
        }

        // Attach manual modal handlers
        function attachManualHandlers() {
          const btnOpenManual = document.getElementById('btn-open-manual-modal');
          const btnCloseManual = document.getElementById('btn-close-manual-modal');
          const btnSubmitManual = document.getElementById('btn-submit-manual');
          const manualModalOverlay = document.getElementById('manual-modal-overlay');

          if (btnOpenManual) {
            btnOpenManual.onclick = function(e) {
              e.preventDefault();
              e.stopPropagation();
              openManualModal();
              return false;
            };
          }

          if (btnCloseManual) {
            btnCloseManual.onclick = function(e) {
              e.preventDefault();
              e.stopPropagation();
              closeManualModal();
              return false;
            };
          }

          if (btnSubmitManual) {
            btnSubmitManual.onclick = function(e) {
              e.preventDefault();
              e.stopPropagation();
              handleManualInput();
              return false;
            };
          }

          if (manualModalOverlay) {
            manualModalOverlay.onclick = function(e) {
              e.preventDefault();
              e.stopPropagation();
              closeManualModal();
              return false;
            };
          }

          // Allow Enter key to submit manual input (attach when modal opens)
          document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('manual-input-modal');
            if (modal && modal.style.display === 'flex') {
              const manualCodeInput = document.getElementById('manualCode');
              if (manualCodeInput && document.activeElement === manualCodeInput && e.key === 'Enter') {
                e.preventDefault();
                e.stopPropagation();
                handleManualInput();
                return false;
              }
            }
          });
        }

        // Attach handlers when DOM is ready
        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', attachManualHandlers);
        } else {
          attachManualHandlers();
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
          stopScanner();
        });
      })();
    </script>
  </body>
</html>
