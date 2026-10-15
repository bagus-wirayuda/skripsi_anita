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
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  </head>
  <body data-page="login">
    <main class="login-layout">
      <div class="login-card">
        <!-- Branding -->
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" />
        <h1>SDN 1 UNDUOLO</h1>

        <!-- Login Form -->
        <form id="loginForm" action="{{ route('login.post') }}" method="POST">
          @csrf
          
          @if ($errors->any())
            <div class="alert alert-error" style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 12px; border-radius: 4px; margin-bottom: 16px;">
              <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('error'))
            <div class="alert alert-error" style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 12px; border-radius: 4px; margin-bottom: 16px;">
              {{ session('error') }}
            </div>
          @endif

          <div class="form-group">
            <label for="username"><i class="fa-solid fa-envelope"></i> Email</label>
            <input 
              type="email" 
              id="username" 
              name="username" 
              value="{{ old('username') }}"
              placeholder="Masukkan email" 
              required 
              autofocus
            />
            @error('username')
              <small style="color: #c33; display: block; margin-top: 4px;">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              placeholder="Masukkan password" 
              required 
            />
            @error('password')
              <small style="color: #c33; display: block; margin-top: 4px;">{{ $message }}</small>
            @enderror
          </div>
          <button class="btn" type="submit">
            <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
            <span>Masuk</span>
          </button>
        </form>
      </div>
    </main>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>


