<?php
require_once 'config/auth.php';

// Redirect jika sudah login
if (isLoggedIn()) {
    header('Location: ' . getRedirectUrl($_SESSION['role']));
    exit;
}

$error = '';

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (login($username, $password)) {
        header('Location: ' . getRedirectUrl($_SESSION['role']));
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Login Sistem</title>
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
    <style>
      .error-message {
        background: #fee;
        border: 1px solid #fcc;
        color: #c33;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
      }
    </style>
  </head>
  <body data-page="login">
    <main class="login-layout">
      <div class="login-card">
        <!-- Branding -->
        <img src="assets/img/logo.png" alt="Logo SDN 1 UNDUOLO" />
        <h1>SDN 1 UNDUOLO</h1>

        <?php if ($error): ?>
          <div class="error-message">
            <i class="fa-solid fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="loginForm" method="POST" action="">
          <div class="form-group">
            <label for="username"><i class="fa-solid fa-user"></i> Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required />
          </div>
          <div class="form-group">
            <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required />
          </div>
          <button class="btn" type="submit">
            <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
            <span>Masuk</span>
          </button>
        </form>
      </div>
    </main>

    <script src="assets/js/script.js"></script>
  </body>
</html>


