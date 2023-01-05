<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Cikarang Lake View Premium</title>
    <link rel="icon" type="image/png" href="/assets/gambar/logo.png" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/dist/css/custom.css">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <p class="text-center">
                    {{-- <img src="/assets/gambar/logo.png" alt="Logo SMK"
                        style="height: 80px;" /></p> --}}
                    <a href="" class="text-dark">
                        <h5>Cikarang Lake View Premium</h5>
                    </a>
            </div>
            <div class="card-body">
                <x-jet-validation-errors class="mb-3 rounded-0" />

                @if (session('status'))
                    <div class="alert alert-success mb-3 rounded-0" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <x-jet-input-error for="email"></x-jet-input-error>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Kata sandi" required>
                        <div class="input-group-append" role="button" onclick="showpassword()">
                            <div class="input-group-text">
                                <i class="fa fa-eye-slash" id="eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck" style="font-size: 14px;">
                                <input type="checkbox" class="remember-me mr-1" name="remember" value="1"
                                    id="remember">
                                <label for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block bg-blue btn-masuk">Masuk</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="/lupakatasandi">Lupa kata sandi</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <script>
        function showpassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
                $('#eye').addClass("fa-eye");
                $('#eye').removeClass("fa-eye-slash");
            } else {
                x.type = "password";
                $('#eye').removeClass("fa-eye");
                $('#eye').addClass("fa-eye-slash");
            }
        }
    </script>
</body>

</html>
