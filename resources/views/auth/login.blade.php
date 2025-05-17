<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | BCH LinkedBase</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      display: flex;
      height: 100vh;
    }
    .left, .right {
      width: 50%;
      padding: 60px;
      box-sizing: border-box;
    }
    .left {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
    .form-container {
      width: 100%;
      max-width: 400px;
    }
    h1 {
      color: #0041C2;
      margin-bottom: 10px;
    }
    h2 {
      margin: 10px 0;
    }
    .description {
      color: #777;
      font-size: 14px;
      margin-bottom: 30px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: 600;
    }
    input {
      width: 100%;
      padding: 10px 40px 10px 12px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      position: relative;
    }
    .form-group {
      position: relative;
    }
    .form-group.valid input {
      border-color: green;
    }
    .form-group.valid::after {
      content: '✔';
      position: absolute;
      right: 10px;
      top: 36px;
      color: green;
      font-size: 16px;
    }
    .form-group .toggle-password {
      position: absolute;
      right: 10px;
      top: 36px;
      cursor: pointer;
      color: #888;
      transition: color 0.3s ease;
    }
    .form-check {
      margin: 10px 0;
      display: flex;
      align-items: center;
    }
    .form-check input {
      width: auto;
      margin-right: 10px;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #0041C2;
      color: white;
      border: none;
      border-radius: 8px;
      margin-top: 20px;
      cursor: pointer;
      font-weight: bold;
    }
    .bottom-text {
      text-align: center;
      margin-top: 15px;
    }
    .bottom-text a {
      color: #0041C2;
      text-decoration: none;
    }
    .right {
      background: linear-gradient(to right, #0041C2, #0065FF);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .right img {
      width: 100%;
      max-height: 220px;
      object-fit: cover;
      border-radius: 10px;
    }
    
    .right .content {
      max-width: 400px;
    }

    .content-box {
      background-color: rgba(255, 255, 255, 0.25); /* putih dengan transparansi */
      border-radius: 16px;
      backdrop-filter: blur(8px); /* efek blur di belakang */
      -webkit-backdrop-filter: blur(8px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .custom-toast {
      position: fixed;
      top: 20px;
      right: 20px;
      background: linear-gradient(90deg, #f15b2a, #e5383b);
      color: white;
      padding: 16px 20px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      z-index: 9999;
      font-family: 'Segoe UI', sans-serif;
      animation: fadeIn 0.3s ease;

    }

  .icon-left {
    background-color: rgba(0, 0, 0, 0.15);
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
  }

  .close-icon {
    font-size: 16px;
    font-weight: bold;
    cursor: default;
  }

  .toast-text {
    flex-grow: 1;
  }

  .toast-title {
    font-weight: 600;
    font-size: 15px;
    margin-bottom: 4px;
  }

  .toast-message {
    font-size: 14px;
  }

  .icon-right {
    font-size: 18px;
    margin-left: 12px;
    cursor: pointer;
    font-weight: bold;
    opacity: 0.8;
  }

  .icon-right:hover {
    opacity: 1;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
  }

  .form-control:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 2px rgba(0, 65, 194, 0.1);
    outline: none;
  }

  .input-error {
    border-color: #dc3545 !important;
    transition: border-color 0.3s;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-2px); }
    to { opacity: 1; transform: translateY(0); }
  }


  .error-message {
    color: #dc3545;
    font-size: 13px;
    margin-top: 6px;
    margin-left: 4px;
    display: none;
    animation: fadeIn 0.3s ease;
  }

</style>
  </style>
</head>
<body>
  <div class="left">
    <div class="form-container">
      <h1>BCH LinkedBase</h1>
      <h2>Sign In</h2>
      <p class="description">Masuk untuk mengelola layanan Bandung Creative Hub</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group" id="emailGroup">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            required
            placeholder="you@email.com"
            class="form-control"
          />
          <span id="email-error" class="error-message">Silakan isi email terlebih dahulu</span>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            required
            placeholder="Input password"
            class="form-control"
          />
          <span id="password-error" class="error-message">Silakan isi password terlebih dahulu</span>
          <i class="fa-solid fa-eye toggle-password" onclick="togglePassword()" id="toggleIcon"></i>
        </div>

        <div class="form-check">
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">Remember me?</label>
        </div>

        <div style="text-align: right;">
          <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>

        <button type="submit">Sign In</button>

        <p class="bottom-text">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
      </form>
    </div>
  </div>

  <div class="right">
    <div class="content ">
      <div class="content-box">

        <img src="{{ asset('images/screenLogin.png') }}" alt="Bandung Creative Hub">
      </div>
      <h2>Easy-to-Use Bandung Creative Hub Service Management Website</h2>
      <p>
        Designed to make it easier for users to access BCH services anytime, anywhere — 
        while also simplifying administrative tasks for the management team, ensuring faster, 
        more efficient operations.
      </p>
    </div>
    @if(session('error'))
    <div id="errorPopup" class="custom-toast">
      <div class="icon-left">
        <span class="close-icon">×</span>
      </div>
      <div class="toast-text">
        <div class="toast-title">Login Gagal</div>
        <div class="toast-message">{{ session('error') }}</div>
      </div>
      <div class="icon-right" onclick="document.getElementById('errorPopup').style.display='none'">
        ×
      </div>
    </div>
    @endif
  </div>


  <script>
   

    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const toggleIcon = document.getElementById("toggleIcon");

      const isPassword = passwordInput.type === "password";
      passwordInput.type = isPassword ? "text" : "password";

      // Toggle icon
      toggleIcon.classList.toggle("fa-eye");
      toggleIcon.classList.toggle("fa-eye-slash");
    }

    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('email-error');

    emailInput.addEventListener('invalid', function (e) {
      e.preventDefault(); // blokir tooltip browser
      emailInput.classList.add('input-error');
      emailError.style.display = 'block';
    });

    emailInput.addEventListener('input', function () {
      if (emailInput.validity.valid) {
        emailInput.classList.remove('input-error');
        emailError.style.display = 'none';
      }
    });

    const passwordInput = document.getElementById('password');
    const passwordError = document.getElementById('password-error');

    passwordInput.addEventListener('invalid', function (e) {
      e.preventDefault(); // blokir tooltip browser
      passwordInput.classList.add('input-error');
      passwordError.style.display = 'block';
    });

    passwordInput.addEventListener('input', function () {
      if (passwordInput.validity.valid) {
        passwordInput.classList.remove('input-error');
        passwordError.style.display = 'none';
      }
    });
  </script>
</body>
</html>
