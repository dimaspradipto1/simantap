<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - SIMANTAP | Badan Pengusahaan Batam</title>
  <meta content="SIMANTAP - Satu pintu untuk setiap berkas pertanahan Badan Pengusahaan Batam" name="description">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    :root {
      --primary-color: #2563eb;
      --primary-hover: #1d4ed8;
      --accent-gold: #f59e0b;
      --accent-gold-hover: #d97706;
      --bg-dark: #0b132a;
      --bg-dark-secondary: #111c38;
      --text-muted: #94a3b8;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-dark);
      color: #f8fafc;
      min-height: 100vh;
      margin: 0;
      overflow-x: hidden;
    }

    .auth-wrapper {
      min-height: 100vh;
      display: flex;
    }

    /* Left Hero Section */
    .hero-section {
      background: radial-gradient(circle at 10% 20%, rgba(245, 158, 11, 0.08) 0%, transparent 40%),
                  radial-gradient(circle at 90% 80%, rgba(37, 99, 235, 0.15) 0%, transparent 40%),
                  linear-gradient(135deg, #0b132a 0%, #0f172a 60%, #111c3a 100%);
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
      background-size: 32px 32px;
      pointer-events: none;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 680px;
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: var(--accent-gold);
      font-weight: 700;
      font-size: 0.875rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      margin-bottom: 1.75rem;
    }

    .brand-badge .dot {
      width: 9px;
      height: 9px;
      background-color: var(--accent-gold);
      border-radius: 50%;
      display: inline-block;
      box-shadow: 0 0 12px rgba(245, 158, 11, 0.8);
    }

    .hero-title {
      font-size: 3.1rem;
      font-weight: 800;
      line-height: 1.18;
      color: #ffffff;
      margin-bottom: 1.5rem;
      letter-spacing: -0.02em;
    }

    .hero-subtitle {
      font-size: 1.125rem;
      line-height: 1.7;
      color: var(--text-muted);
      font-weight: 400;
      margin-bottom: 2.5rem;
    }

    .feature-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      padding: 8px 16px;
      border-radius: 50px;
      font-size: 0.875rem;
      font-weight: 500;
      color: #e2e8f0;
      transition: all 0.3s ease;
    }

    .feature-pill:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(245, 158, 11, 0.4);
      transform: translateY(-2px);
    }

    /* Right Form Section */
    .form-section {
      background-color: #0f172a;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      border-left: 1px solid rgba(255, 255, 255, 0.07);
    }

    .login-card {
      background: rgba(15, 23, 42, 0.75);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      padding: 2.5rem;
      width: 100%;
      max-width: 440px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .app-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 2rem;
    }

    .app-logo-icon {
      width: 44px;
      height: 44px;
      background: linear-gradient(135deg, var(--accent-gold) 0%, #d97706 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #0b132a;
      font-size: 1.35rem;
      box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }

    .app-brand-name {
      font-size: 1.5rem;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.01em;
      line-height: 1;
    }

    .app-brand-sub {
      font-size: 0.75rem;
      color: var(--text-muted);
      font-weight: 500;
      margin-top: 3px;
    }

    .form-title {
      font-size: 1.35rem;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 0.35rem;
    }

    .form-subtitle {
      font-size: 0.875rem;
      color: var(--text-muted);
      margin-bottom: 1.75rem;
    }

    .custom-label {
      font-size: 0.85rem;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 0.5rem;
      display: block;
    }

    .custom-input-group {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      color: #64748b;
      font-size: 1.1rem;
      transition: color 0.2s ease;
      z-index: 4;
      pointer-events: none;
    }

    .custom-control {
      width: 100%;
      background-color: rgba(30, 41, 59, 0.6);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      padding: 0.75rem 1rem 0.75rem 2.75rem;
      font-size: 0.925rem;
      color: #f8fafc;
      transition: all 0.25s ease;
    }

    .custom-control.has-toggle {
      padding-right: 2.75rem;
    }

    .custom-control::placeholder {
      color: #475569;
    }

    .custom-control:focus {
      background-color: rgba(30, 41, 59, 0.9);
      border-color: var(--accent-gold);
      box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15);
      outline: none;
      color: #ffffff;
    }

    .custom-input-group:focus-within .input-icon {
      color: var(--accent-gold);
    }

    .toggle-password {
      position: absolute;
      right: 14px;
      background: none;
      border: none;
      color: #64748b;
      font-size: 1.1rem;
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s ease;
      z-index: 4;
    }

    .toggle-password:hover {
      color: #f8fafc;
    }

    .form-check-input {
      background-color: rgba(30, 41, 59, 0.8);
      border-color: rgba(255, 255, 255, 0.2);
      border-radius: 6px;
      width: 18px;
      height: 18px;
      cursor: pointer;
    }

    .form-check-input:checked {
      background-color: var(--accent-gold);
      border-color: var(--accent-gold);
    }

    .form-check-label {
      font-size: 0.85rem;
      color: #cbd5e1;
      cursor: pointer;
      user-select: none;
    }

    .btn-login {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #0b132a;
      font-weight: 700;
      font-size: 0.95rem;
      border: none;
      border-radius: 12px;
      padding: 0.85rem 1.5rem;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25);
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
      color: #0b132a;
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .alert-custom {
      border-radius: 12px;
      padding: 0.85rem 1rem;
      font-size: 0.85rem;
      border: none;
      margin-bottom: 1.25rem;
    }

    .alert-custom-danger {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #fca5a5;
    }

    .alert-custom-success {
      background: rgba(34, 197, 94, 0.15);
      border: 1px solid rgba(34, 197, 94, 0.3);
      color: #86efac;
    }

    /* Footer Text */
    .auth-footer {
      text-align: center;
      margin-top: 2rem;
      font-size: 0.775rem;
      color: #64748b;
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
      .hero-title {
        font-size: 2.25rem;
      }
      .hero-subtitle {
        font-size: 1rem;
      }
      .login-card {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>

<body>

  <div class="container-fluid p-0">
    <div class="row g-0 auth-wrapper">
      
      <!-- Left Hero Section -->
      <div class="col-lg-7 col-xl-7 hero-section d-flex align-items-center justify-content-center p-4 p-md-5">
        <div class="hero-content">
          
          <div class="brand-badge">
            <span class="dot"></span>
            BADAN PENGUSAHAAN BATAM
          </div>

          <h1 class="hero-title">
            Satu pintu untuk setiap berkas pertanahan.
          </h1>

          <p class="hero-subtitle">
            Menggantikan pencatatan checklist tanda terima dokumen yang selama ini dilakukan berulang di formulir cetak dan Microsoft Excel — kini terpadu, tertelusur, dan tak pernah hilang.
          </p>

          <div class="d-flex flex-wrap gap-2 pt-2">
            <div class="feature-pill">
              <i class="bi bi-shield-check text-warning"></i> Terpadu & Terintegrasi
            </div>
            <div class="feature-pill">
              <i class="bi bi-search text-info"></i> Tertelusur Real-time
            </div>
            <div class="feature-pill">
              <i class="bi bi-folder-check text-success"></i> Dokumen Aman & Akurat
            </div>
          </div>

        </div>
      </div>

      <!-- Right Form Section -->
      <div class="col-lg-5 col-xl-5 form-section p-4 p-md-5">
        <div class="login-card">
          
          <!-- App Header -->
          <div class="app-brand">
            <div class="app-logo-icon">
              <i class="bi bi-file-earmark-text-fill"></i>
            </div>
            <div>
              <div class="app-brand-name">SIMANTAP</div>
              <div class="app-brand-sub">Sistem Manajemen Tanda Terima Pertanahan</div>
            </div>
          </div>

          <div class="mb-4">
            <h2 class="form-title">Masuk ke Akun Anda</h2>
            <p class="form-subtitle">Silakan masukkan kredensial terdaftar untuk melanjutkan</p>
          </div>

          <!-- Alert Notifications -->
          @if (session('success'))
            <div class="alert alert-custom alert-custom-success alert-dismissible fade show" role="alert">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-6"></i>
                <div>{{ session('success') }}</div>
              </div>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if ($errors->any())
            <div class="alert alert-custom alert-custom-danger alert-dismissible fade show" role="alert">
              <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-6 mt-1"></i>
                <div>
                  <ul class="mb-0 ps-2" style="list-style-type: none;">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Login Form -->
          <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <!-- Email Field -->
            <div class="mb-3">
              <label for="yourEmail" class="custom-label">Alamat Email</label>
              <div class="custom-input-group">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" name="email" class="custom-control @error('email') is-invalid @enderror" id="yourEmail" value="{{ old('email') }}" placeholder="nama@bpbatam.go.id" required autofocus>
              </div>
              @error('email')
                <div class="text-danger small mt-1 ps-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-3">
              <label for="yourPassword" class="custom-label">Kata Sandi</label>
              <div class="custom-input-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" class="custom-control has-toggle @error('password') is-invalid @enderror" id="yourPassword" placeholder="••••••••" required>
                <button type="button" class="toggle-password" id="togglePasswordBtn" title="Tampilkan/Sembunyikan Kata Sandi">
                  <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
              </div>
              @error('password')
                <div class="text-danger small mt-1 ps-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Remember Me Checkbox -->
            <div class="d-flex align-items-center justify-content-between mb-4">
              <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" name="remember" value="1" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Ingat Saya</label>
              </div>
            </div>

            <!-- Submit Button -->
            <button class="btn btn-login" type="submit">
              <span>Masuk ke Sistem</span>
              <i class="bi bi-arrow-right-short fs-5"></i>
            </button>

          </form>

          <div class="auth-footer">
            &copy; {{ date('Y') }} Badan Pengusahaan Batam. All rights reserved.
          </div>

        </div>
      </div>

    </div>
  </div>

  <!-- Vendor JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Toggle Password Visibility Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const togglePasswordBtn = document.getElementById('togglePasswordBtn');
      const passwordInput = document.getElementById('yourPassword');
      const toggleIcon = document.getElementById('toggleIcon');

      if (togglePasswordBtn && passwordInput && toggleIcon) {
        togglePasswordBtn.addEventListener('click', function () {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          
          if (type === 'text') {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
          } else {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
          }
        });
      }
    });
  </script>

</body>

</html>