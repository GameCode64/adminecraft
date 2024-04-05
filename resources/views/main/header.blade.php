<!doctype html>
<html data-bs-theme="light">
<!-- HEADER -->

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ricky Visser / GameCode64 Engine: Bootstrap">
    <title>{{$AdditionalInfo["ServerTitle"]}} - ADMINecraft {{$AdditionalInfo["PanelVersion"]}}</title>


    <link href="../assets/dist/css/css-file-icons.css" rel="stylesheet">

    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/dist/vendor/ace/css/ace.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>

    </style>

    <link href="css/main.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100 bg-dark ">

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-12 col-md-3 col-lg-2 col-xxl-1 me-0 px-3" href="/">AD//MIN//ECRAFT<br>{{$AdditionalInfo["ServerTitle"]}}</a>


        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- input class="form-control form-control-dark w-100 hidden" type="text" placeholder="Search" aria-label="Search" -->

    </header>

    <div class="container-fluid pb-5">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 col-xxl-1 col-12 d-md-block sidebar collapse">
                <div class="position-sticky pt-5">
                    <ul class="nav flex-column text-light">

                        <li class="nav-item nav-link text-light text-center p-0">

                            Welcome {{ $Session['Name'] }}
                        </li>
                        <li class="nav-item">
                            <hr class=" text-light" />
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($Route == 'dashboard') active @else text-light @endif"
                                aria-current="page" href="/">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>

                       
                            <li class="nav-item">
                                <a class="nav-link @if ($Route == 'console') active @else text-light @endif"
                                    href="/console">
                                    <span data-feather="terminal"></span>
                                    Console
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link  @if ($Route == 'filemanager') active @else text-light @endif"
                                    href="/filemanager">
                                    <span data-feather="file"></span>
                                    Filemanager
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link  @if ($Route == 'logs') active @else text-light @endif"
                                    href="/logs">
                                    <span data-feather="file-text"></span>
                                    Logs
                                </a>
                            </li>
                        @if ($Session['Authority'] >= 2)
                            <li class="nav-item">
                                <a class="nav-link  @if ($Route == 'users') active @else text-light @endif"
                                    href="/users">
                                    <span data-feather="users"></span>
                                    Users
                                </a>
                            </li>
{{--                       

                        <li class="nav-item">
                            <a class="nav-link  @if ($Route == 'myaccount') active @else text-light @endif"
                                href="/myaccount">
                                <span data-feather="user"></span>
                                My account
                            </a>
                        </li> --}}
                        @endif
                        <li class="nav-item">
                            <hr class=" text-light" />
                        </li>

                        @if ($Session['Authority'] >= 2)
                            <li class="nav-item">
                                <a class="nav-link @if ($Route == 'settings') active @else text-light @endif"
                                    href="/settings">
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
