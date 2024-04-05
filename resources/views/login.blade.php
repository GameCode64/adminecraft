<!doctype html>
<html data-bs-theme="light">
<!-- HEADER -->

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Ricky Visser / GameCode64 Engine: Bootstrap">
  <title>{{$AdditionalInfo["ServerTitle"]}} - ADMINecraft {{$AdditionalInfo["PanelVersion"]}}</title>

  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  {!! htmlScriptTagJsApi() !!}
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    /* Custom styles for light mode */
    :root[data-bs-theme='light'] {
      --body-bg-color: #fff;
      --body-text-color: #212529;
      --nav-bg-color: #212529;
      --nav-text-color: #fff;
      --sidebar-bg-color: #f8f9fa;
      --sidebar-text-color: #212529;
      --border-color: rgba(0, 0, 0, 0.1);
    }

    /* Custom styles for dark mode */
    :root[data-bs-theme='dark'] {
      --body-bg-color: #212529;
      --body-text-color: #fff;
      --nav-bg-color: #343a40;
      --nav-text-color: #fff;
      --sidebar-bg-color: #212529;
      --sidebar-text-color: #fff;
      --border-color: rgba(255, 255, 255, 0.1);
    }
    .background{
      background-image: url("assets/img/background.jpg") ;
      background-repeat: no-repeat;
      background-size:auto;
      background-color: var(--body-bg-color);
      filter: blur(4px) contrast(1.15) brightness(1.2);
      height: 100vh;
      width: 100vw;
      z-index: -1;
      position: absolute;
    }
    
    body {

      color: var(--body-text-color);
    }
    
    .navbar{
      z-index: 0 !important;
    }

    .login {
      background: rgba(0,0,0,0.3) !important;

    }

    .navbar-dark {
      background-color: var(--nav-bg-color);
    }

    .navbar-dark .navbar-brand {
      color: var(--nav-text-color);
    }

    .nav-link {
      color: var(--sidebar-text-color);
    }

    .bg-dark {
      background-color: var(--sidebar-bg-color);
      border-color: var(--border-color);
    }
  </style>

  <link href="css/main.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100 bg-dark ">
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-12 col-md-3 col-lg-2 col-xxl-1 me-0 px-3" href="/">AD//MIN//ECRAFT<br>{{$AdditionalInfo["ServerTitle"]}}</a>
  </header>

  <div class="container">
    <div class="row justify-content-center align-items-center pt-5">
      <main class="col align-self-center col-12 col-md-9 col-lg-6 col-xl-4">
        <div class="card bg-dark border-secondary ">
          <div class="card-header login  bg-dark text-light h1 text-center">LOGIN</div>
          <div class="card-body bg-dark text-light">
            @isset($ErrorMessage)
            <div class="alert @if($Status) alert-success @else alert-danger @endif">{{$ErrorMessage}}</div>
            @endif
            <form method="POST" action="/login" class="pt-3">
              @csrf
              <div class="form-outline mb-4">
                <input type="email" required name="email" id="Email" class="form-control" />
                <label class="form-label" for="Email">Email address</label>
              </div>
              <div class="form-outline mb-4">
                <input type="password" required id="Password" name="password" class="form-control" />
                <label class="form-label"  for="Password">Password</label>
              </div>
              @if ($AdditionalInfo["Settings"]["AllowResetPassword"])
              <div class="row mb-4">
                <div class="col">
                  <a href="#!">Forgot password?</a>
                </div>
              </div>
              @endif

              <!-- Submit button -->
              <button type="submit" class="w-100 btn btn-primary btn-block mb-4">Sign in</button>

              <!-- Register buttons -->
              @if ($AdditionalInfo["Settings"]["AllowRegister"])
               <div class="text-center">
                <p>Not a member? <a href="/register">Register</a></p>
              </div>
              @endif
            </form>
          </div>

        </div>

      </main>
    </div>
  </div>
  <!-- BODY -->

  <div class="background"></div>


  <!-- FOOTER -->
  <footer class="bg-dark text-center text-white fixed-bottom">

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © {{ date("Y") }} Copyright: GameCode64
    </div>
    <!-- Copyright -->
  </footer>

  <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
    integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
    integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
    crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
</body>

</html>
<!-- FOOTER -->