(() => {
  const root = document.getElementById('scanner');
  if (!root) return;
  const video = document.getElementById('qrVideo'), canvas = document.getElementById('qrCanvas');
  const context = canvas.getContext('2d', { willReadFrequently: true });
  const output = document.getElementById('scanResult'), cameraStatus = document.getElementById('cameraStatus');
  const start = document.getElementById('startCamera'), stop = document.getElementById('stopCamera');
  let stream, frame, running = false, busy = false, lastCode = '', lastTime = 0;
  function feedback(message, ok) { output.textContent = message; output.className = `message ${ok ? 'success' : 'error'}`; }
  async function save(code) {
    if (busy) return;
    busy = true; document.getElementById('submitScan').disabled = true;
    try {
      const body = new URLSearchParams({ csrf: root.dataset.csrf, code, direction: document.getElementById('scanDirection').value });
      const response = await fetch(root.dataset.endpoint, { method: 'POST', body, credentials: 'same-origin' });
      if (!(response.headers.get('content-type') || '').includes('application/json')) throw new Error('Sesi berakhir. Muat ulang halaman dan masuk kembali.');
      const data = await response.json(); feedback(data.message, data.ok);
      if (data.ok) document.getElementById('manualCode').value = '';
    } catch (error) { feedback(error.message || 'Gagal terhubung. Coba kembali.', false); }
    finally { busy = false; document.getElementById('submitScan').disabled = false; }
  }
  function decode(width, height) {
    const pixels = context.getImageData(0, 0, width, height);
    return window.jsQR(pixels.data, width, height, { inversionAttempts: 'attemptBoth' });
  }
  function tick() {
    if (!running) return;
    if (video.readyState >= 2 && !busy) {
      const scale = Math.min(1, 720 / video.videoWidth);
      canvas.width = Math.round(video.videoWidth * scale); canvas.height = Math.round(video.videoHeight * scale);
      context.drawImage(video, 0, 0, canvas.width, canvas.height);
      const result = decode(canvas.width, canvas.height);
      if (result && (result.data !== lastCode || Date.now() - lastTime > 5000)) { lastCode = result.data; lastTime = Date.now(); save(result.data); }
    }
    frame = requestAnimationFrame(tick);
  }
  function stopCamera() {
    running = false; cancelAnimationFrame(frame); stream?.getTracks().forEach(track => track.stop());
    video.srcObject = null; start.disabled = false; stop.disabled = true; cameraStatus.textContent = 'Kamera dihentikan.';
  }
  start.addEventListener('click', async () => {
    start.disabled = true;
    try {
      if (!navigator.mediaDevices?.getUserMedia) throw new Error('Kamera memerlukan HTTPS atau localhost. Gunakan input NIS atau gambar kartu.');
      if (!window.jsQR) throw new Error('Pustaka pemindai belum tersedia. Muat ulang halaman.');
      stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: { ideal: 'environment' } }, audio: false });
      video.srcObject = stream; await video.play(); running = true; stop.disabled = false;
      cameraStatus.textContent = 'Arahkan kartu QR ke kamera.'; tick();
    } catch (error) { stopCamera(); cameraStatus.textContent = error.name === 'NotAllowedError' ? 'Izin kamera ditolak. Izinkan kamera atau gunakan input manual.' : error.message; }
  });
  stop.addEventListener('click', stopCamera); window.addEventListener('pagehide', stopCamera);
  document.addEventListener('visibilitychange', () => { if (document.hidden) stopCamera(); });
  document.getElementById('scanForm').addEventListener('submit', event => { event.preventDefault(); save(document.getElementById('manualCode').value.trim()); });
  document.getElementById('qrFile').addEventListener('change', async event => {
    const file = event.target.files[0]; if (!file) return;
    stopCamera();
    try {
      if (file.size > 10 * 1024 * 1024) throw new Error('Ukuran gambar maksimal 10 MB.');
      const bitmap = await createImageBitmap(file); const scale = Math.min(1, 1600 / Math.max(bitmap.width, bitmap.height));
      canvas.width = Math.round(bitmap.width * scale); canvas.height = Math.round(bitmap.height * scale);
      context.drawImage(bitmap, 0, 0, canvas.width, canvas.height); bitmap.close();
      const result = decode(canvas.width, canvas.height); if (!result) throw new Error('QR tidak terbaca. Gunakan gambar lebih jelas atau input NIS.');
      await save(result.data);
    } catch (error) { feedback(error.message, false); }
    event.target.value = '';
  });
})();
