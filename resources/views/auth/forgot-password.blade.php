<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password | BCH LinkedBase</title>
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
      margin-bottom: 20px;
    }
    .right .content {
      max-width: 400px;
    }
  </style>
</head>
<body>
  <div class="left">
    <div class="form-container">
      <h1>BCH LinkedBase</h1>
      <h2>Forgot Password</h2>
      <p class="description">Enter your registered email and we'll send you a link to reset your password.</p>
      
      @if (session('status'))
        <div style="color: green; margin-bottom: 10px;">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group" id="emailGroup">
          <label for="email">Email</label>
          <input id="email" type="email" name="email" required placeholder="you@email.com">
        </div>

        <button type="submit">Send Reset Link</button>

        <p class="bottom-text">
          Remember your password? <a href="{{ route('login') }}">Sign In</a>
        </p>
      </form>
    </div>
  </div>

  <div class="right">
    <div class="content">
      <img src="{{ asset('images/login.jpeg') }}" alt="Bandung Creative Hub">
      <h2>Easy-to-Use Bandung Creative Hub Service Management Website</h2>
      <p>
        Designed to make it easier for users to access BCH services anytime, anywhere — 
        while also simplifying administrative tasks for the management team, ensuring faster, 
        more efficient operations.
      </p>
    </div>
  </div>

  <script>
    const emailInput = document.getElementById('email');
    const emailGroup = document.getElementById('emailGroup');

    emailInput.addEventListener('input', function () {
      const valid = emailInput.checkValidity();
      emailGroup.classList.toggle('valid', valid);
    });
  </script>
</body>
</html>
