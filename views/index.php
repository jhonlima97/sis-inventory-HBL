<?php

session_start();
if (!isset($_SESSION['S_ID'])) {
  header('Location: ../index.php');
  exit();
}
?>

<div class="content-wrapper">

  <?php

  if (isset($_GET['view'])) {
    $view = $_GET['view'];
    switch ($view) {
      case 'graficos':
        $pageTitle = 'Graficos';
        include_once "../includes/header.php";
        include('graficos.php');
        break;
      case 'areas':
        $pageTitle = 'Areas';
        include_once "../includes/header.php";
        include('area/areas.php');
        break;
      case 'usuarios':
        $pageTitle = 'Usuarios';
        include_once "../includes/header.php";
        include('usuario/usuarios.php');
        break;
      case 'computadoras':
        $pageTitle = 'Computadoras';
        include_once "../includes/header.php";
        include('equipo/computadoras.php');
        break;
      case 'impresoras':
        $pageTitle = 'Impresoras';
        include_once "../includes/header.php";
        include('equipo/impresoras.php');
        break;
      case 'switches':
        $pageTitle = 'Switches';
        include_once "../includes/header.php";
        include('equipo/switches.php');
        break;
      case 'scanners':
        $pageTitle = 'Scanners';
        include_once "../includes/header.php";
        include('equipo/scanners.php');
        break;  
      case 'servidores':
        $pageTitle = 'Servidores';
        include_once "../includes/header.php";
        include('equipo/servidores.php');
        break;
      case 'perifericos':
        $pageTitle = 'Perifericos';
        include_once "../includes/header.php";
        include('equipo/perifericos.php');
      break;
      case 'patrimonio':
        $pageTitle = 'Patrimonio';
        include_once "../includes/header.php";
        include('reporte/reportes.php');
      break;
      case 'desplazamientos':
        $pageTitle = 'Desplazamientos';
        include_once "../includes/header.php";
        include('reporte/desplazamiento.php');
        break;
      case 'registro_desplazamiento':
        $pageTitle = 'Desplazamientos';
        include_once "../includes/header.php";
        include('reporte/registro_desplazamiento.php');
      break;
      
      default:
        // Manejar otros casos si el parámetro no coincide con ninguna vista conocida
        break;
    }
  } else {
  $pageTitle = 'SIS INVENTARIO';
  include_once "../includes/header.php";

    // Aquí va el contenido por defecto si no se especifica una vista
  ?>
  
  <!-- Contenido del Dashboard -->
  <body>
      <div class="col-md-4">
          <h2 class="etiqueta-inventario">Bienvenido a <br>
              <span class="contenedor-celeste">Belen Informatics</span>
          </h2>         
      </div> 
      <div class="col-md-4">               
          <img class="img-inventario"  src="../libs/images/hospital_inventario.png">                   
      </div> 
  </body>

  <?php

}
  
  include_once "../includes/menu.php";
  ?>

</div>
  

<?php
include_once "../includes/footer.php";
?>