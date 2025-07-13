<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Administrative Panel</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" >


    <!-- Custom CSS (Local) -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css') }}" />
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="col-12">
        @if (Session::has('error'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4> {{ Session::get('error') }}
          </div>
        @endif

        @if (Session::has('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4> {{ Session::get('success') }}
          </div>
        @endif
      </div>

      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="#" class="h3 text-decoration-none">Administrative Panel</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          <form action="{{ route('admin.authenticate') }}" method="post">
            @csrf
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="email" placeholder="Email" />
              <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
              </div>
            </div>

            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="Password" />
              <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
              </div>
            </div>

            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember" name="remember">
                  <label for="remember">Remember Me</label>
                </div>
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
              </div>
              <div class="col-md-8 align-content-center">
                <p class="mb-0 text-right">
                  <a href="{{ route('account.forgotPassword') }}">I forgot my password</a>
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>

      <p class="mb-1 mt-3 text-center">
        <a href="{{ route('editor.login') }}">Login as Editor</a>
      </p>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 4 Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" ></script>

    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  </body>
</html>
