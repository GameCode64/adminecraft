<!doctype html>
<html data-bs-theme="light">
<!-- HEADER -->

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Ricky Visser / GameCode64 Engine: Bootstrap">
  <title>ADMINecraft v0.0.1</title>

  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  

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

    body {
      background-color: var(--body-bg-color);
      color: var(--body-text-color);
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
    <a class="navbar-brand col-12 col-md-3 col-lg-2 col-xxl-1 me-0 px-3" href="/">AD//MIN//ECRAFT</a>


    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- input class="form-control form-control-dark w-100 hidden" type="text" placeholder="Search" aria-label="Search" -->

  </header>

  <div class="container-fluid pb-5">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 col-xxl-1 col-12 d-md-block sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column text-light">

            <li class="nav-item nav-link text-light text-center p-0">
              
                Welcome {{$Session["Name"]}}
            </li>
            <li class="nav-item">
              <hr class=" text-light" />
          </li>
            <li class="nav-item">
              <a class="nav-link @if($Route == "dashboard") active @else text-light @endif" aria-current="page" href="/">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            
            @if($Session["Authority"] >=2 )
            <li class="nav-item">
              <a class="nav-link @if($Route == "console") active @else text-light @endif" href="/console">
                <span data-feather="terminal"></span>
                Console
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link  @if($Route == "filemanager") active @else text-light @endif" href="/filemanager">
                <span data-feather="file"></span>
                Filemanager
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link  @if($Route == "logs") active @else text-light @endif" href="/logs">
                <span data-feather="file-text"></span>
                Logs
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link  @if($Route == "users") active @else text-light @endif" href="/users">
                <span data-feather="users"></span>
                Users
              </a>
            </li>
            @endif
            
            <li class="nav-item">
              <a class="nav-link  @if($Route == "myaccount") active @else text-light @endif" href="/myaccount">
                <span data-feather="user"></span>
                My account
              </a>
            </li>

            <li class="nav-item">
                <hr class=" text-light" />
            </li>
            
            @if($Session["Authority"] >=2 )
            <li class="nav-item">
              <a class="nav-link @if($Route == "settings") active @else text-light @endif" href="/settings">
                <span data-feather="settings"></span>
                Settings
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a class="nav-link text-light" href="/logout">
                <span data-feather="log-out"></span>
                Sign out
              </a>
            </li>

          </ul>
        </div>
      </nav>
      <!-- HEADER -->