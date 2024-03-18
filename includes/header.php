<!DOCTYPE html>
<html lang="es">
 
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Definimos una variable para el title de cada vista -->
  <title><?php echo $pageTitle; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../libs/css/main.css">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="../libs/css/adminlte.min.css">


  <!-- Libreria SwetAlert -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css">

  <!-- Agrega los enlaces a las bibliotecas DataTables y Bootstrap -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- CDN de select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
</head>

</head>

<body class="sidebar-mini layout-fixed" style="width: 100%;">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../libs/images/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand" style="background-color:#506f86;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item"> <!-- Icono de ocultar y mostrar menu  -->
        <a class="nav-link" data-widget="pushmenu" role="button">
          <i class="fas fa-bars fa-1x" style="color:white"></i></a>
      </li>
      <li class="nav-item" style="margin-left: 10px; margin-right: 10px;">
        <a href="../views/index.php" class="nav-link" style="color:white; font-size:15px"><b>Página Principal</b></a>
      </li>
      <li class="nav-item" style="margin-left: 10px; margin-right: 10px;">
        <a href="../views/index.php?view=patrimonio" class="nav-link" style="color:white; font-size:15px"><b>Patrimonio</b></a>
      </li>
      <li class="nav-item" style="margin-left: 10px; margin-right: 10px;">
        <a href="../views/index.php?view=desplazamientos" class="nav-link" style="color:white; font-size:15px"><b>Desplazamientos</b></a>
      </li>
      <li class="nav-item" style="margin-left: 10px; margin-right: 10px;">
        <a href="../views/index.php?view=graficos" class="nav-link" style="color:white; font-size:15px"><b>Gráficos</b></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search" style="color:white"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times" ></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>     
    </ul>
  </nav>  
</body>

</html>