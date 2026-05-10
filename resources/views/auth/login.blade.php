<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SiPerpus - SMP N 1 KLAMBU - Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="img/logosmp.jpg" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="css/owl.carousel.min.css" rel="stylesheet">
    <link href="css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        body {
            background: url('img/library.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <div class="container-xxl position-relative d-flex p-0">
        <!-- Sign In Start -->
        <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
        <div class="login-container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <a href="index.html">
                    <h3 class="text-primary"><i class="fa fa-book"></i> SiPerpus</h3>
                </a>
                <h3>Sign In</h3>
            </div>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- Pesan Error --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

          <!-- Form Login -->
<form action="{{ route('login') }}" method="POST">
    @csrf <!-- Token keamanan Laravel -->

    <!-- Pesan sukses / error -->
    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <!-- NIS -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingNis" name="nis" placeholder="Masukkan NIS" required>
        <label for="floatingNis">NIS</label>
    </div>

    <!-- Password -->
    <div class="form-floating mb-4 position-relative">
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
              onclick="togglePassword('floatingPassword', 'eyeIcon')" style="cursor: pointer;">
            <i id="eyeIcon" class="fa fa-eye"></i>
        </span>
    </div>

    <!-- Tombol Login -->
    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>

    <p class="text-center mb-0">
        Belum punya akun? <a href="{{ route('register') }}">Sign Up</a>
    </p>
</form>

            <!-- End Form -->
        </div>
    </div>
</div>

        <!-- Sign In End -->
    </div>

    <!-- JavaScript untuk toggle password -->
    <script>
                function togglePassword() {
                    let passwordField = document.getElementById("floatingPassword");
                    let eyeIcon = document.getElementById("eyeIcon");

                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        eyeIcon.classList.remove("fa-eye");
                        eyeIcon.classList.add("fa-eye-slash");
                    } else {
                        passwordField.type = "password";
                        eyeIcon.classList.remove("fa-eye-slash");
                        eyeIcon.classList.add("fa-eye");
                    }
                }
                </script>
                
</body>
</html>
