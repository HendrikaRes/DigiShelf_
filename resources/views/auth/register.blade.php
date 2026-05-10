<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SiPerpus - SMP N 1 KLAMBU - Register</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/logosmp.jpg" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="css/owl.carousel.min.css" rel="stylesheet">
    <link href="css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            background: url('img/library.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative d-flex p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-7 col-lg-6 col-xl-7"> 
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="index.html" class="">
                        <h3 class="text-primary"><i class="fa fa-book"></i> SiPerpus</h3>
                    </a>
                    <h3>Sign Up</h3>
                </div>

              <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf 

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingNamaLengkap" name="nama_lengkap" placeholder="Jhon Wash" required>
                                <label for="floatingNamaLengkap">Nama Lengkap</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingNama" name="name" placeholder="Jhon" required>
                                <label for="floatingNama">Nama Panggilan</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingNis" name="nis" placeholder="123456" required>
                                <label for="floatingNis">NIS</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingAlamat" name="alamat" placeholder="Jl. Merdeka No. 10" required>
                                <label for="floatingAlamat">Alamat</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="name@example.com" required>
                                <label for="floatingEmail">Email Address</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                        <label for="foto_profil">Foto Profil</label>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-4 position-relative">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                                <span class="position-absolute end-0 top-50 translate-middle-y me-3" onclick="togglePassword('floatingPassword', 'eyeIcon1')" style="cursor: pointer;">
                                    <i id="eyeIcon1" class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-4 position-relative">
                                <input type="password" class="form-control" id="floatingConfirmPassword" name="password_confirmation" placeholder="Confirm Password" required>
                                <label for="floatingConfirmPassword">Confirm Password</label>
                                <span class="position-absolute end-0 top-50 translate-middle-y me-3" onclick="togglePassword('floatingConfirmPassword', 'eyeIcon2')" style="cursor: pointer;">
                                    <i id="eyeIcon2" class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>

                    <p class="text-center mb-0">
                        Already have an account? <a href="{{ route('login') }}">Sign In</a>
                    </p>
                </form>

                </div>
        </div>
    </div>
</div>

        </div>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/easing.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/moment-timezone.min.js"></script>
    <script src="js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="js/main.js"></script>

    <script>
    function togglePassword(inputId, eyeIconId) {
        let inputField = document.getElementById(inputId);
        let eyeIcon = document.getElementById(eyeIconId);

        if (inputField.type === "password") {
            inputField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            inputField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>

</body>

</html>