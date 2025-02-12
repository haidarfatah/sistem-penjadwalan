<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('/storage/icon/logo.png') }}" type="image/png">
    
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #9ac5e5, #4fb19d);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-title {
            color: #4fb19d;
            font-weight: bold;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-login {
            background: #edce7a;
            color: #fff;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #c98c9a;
            color: #fff;
        }

        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .toggle-password:hover {
            color: #4fb19d;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h2 class="text-center login-title"><i class="fas fa-user-lock"></i> Login</h2>
        <form method="POST" action="/login">
            @csrf
            <!-- Input Email -->
            <div class="mb-3 position-relative">
                <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
            </div>

            <!-- Input Password -->
            <div class="mb-3 position-relative">
                <label class="form-label"><i class="fas fa-key"></i> Password</label>
                <div class="position-relative">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    <i class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                </div>
            </div>

            <!-- Tombol Login -->
            <button type="submit" class="btn btn-login w-100 py-2"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript untuk Toggle Password -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var icon = document.querySelector(".toggle-password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>

</body>

</html>
