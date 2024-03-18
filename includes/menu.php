<?php

include_once "../models/conexionbd.php";

// Crear una instancia de la clase de conexión
$conexion = new conexionBD();

// Intentar establecer la conexión llamando al método conexión
$pdo = $conexion->conexion();

$nombre_usuario = ""; // Inicializamos la variable

if ($pdo) {
    // Obtener el ID del usuario logueado (suponiendo que está almacenado en $_SESSION)
    $usuario_id = $_SESSION['S_ID'];
    $usuario_rol = $_SESSION['S_ROL'];

    // Consulta para obtener el nombre del usuario
    $query = "SELECT nombres FROM usuario WHERE id = :usuario_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    // Verificar si la consulta se ejecutó correctamente
    if ($stmt->rowCount() > 0) {
        // Obtener el nombre del usuario y asignarlo a la variable $nombre_usuario
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre_usuario = $row['nombres'];
    } else {
        echo "Nombre de usuario no encontrado";
    }
} else {
    echo "No se pudo conectar a la base de datos.";
}
?>

<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="../views/index.php" class="brand-link">
      <img src="../libs/images/hospital.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>SIS</b> INVENTARIO <b>HBL</b></span>
    </a>
    

    <!-- Perfil de usuario -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="../libs/images/user.png" class="img-circle" style="height:35px; width:35px;" alt="User Image">
        </div>
        <div class="info">
            <a class="d-block" id="nombreUsuario" style="text-decoration: none;"><?php echo $nombre_usuario; ?></a>
            <a href="../controllers/usuario/logout.php" id="cerrarSesionBtn" class="btn btn-warning mt-2" 
            style="display: none; color:black; font-weight:bolder">Cerrar Sesión</a>
        </div>
      </div>

      <?php
      // Mostrar/ocultar opciones de menú según el rol del usuario
      if ($usuario_rol == 'ADMINISTRADOR') {
          // Mostrar todas las opciones del menú
      ?>
      <!-- MENUS -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- MENU DE AREAS -->
          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa fa-hospital-o"></i>
                <p>
                  Áreas Hospitalarias
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=areas" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Áreas</p>
                  </a>
                </li>
                
              </ul>
          </li>
          <!-- MENU DE EQUIPOS -->
          <li class="nav-item">
              <a href="#" class="nav-link">
              <i class="fas fa-keyboard"></i>
                <p>
                  Equipos informáticos
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=computadoras" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Computadoras</p>
                  </a>
                </li>              
              </ul>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=impresoras" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Impresoras</p>
                  </a>
                </li>              
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=switches" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Switches</p>
                  </a>
                </li>              
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=scanners" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Scanners</p>
                  </a>
                </li>              
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=servidores" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Servidores</p>
                  </a>
                </li>              
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=perifericos" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Periféricos</p>
                  </a>
                </li>              
              </ul>
          </li>
          <!-- MENU DE REPORTES -->
          <li class="nav-item">
              <a href="#" class="nav-link">
              <i class="fa fa-file"></i>
                <p>
                  Reportes Inventario
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=patrimonio" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Patrimonio</p>
                  </a>
                </li>
              </ul>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=desplazamientos" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Desplazamientos</p>
                  </a>
                </li>
              </ul>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=graficos" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Gráficos</p>
                  </a>
                </li>
              </ul>
          </li>
          <!-- MENU USUARIOS -->
          <li class="nav-item">
              <a href="#" class="nav-link">
              <i class="fa fa-user"></i>
                <p>
                  Usuarios
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=usuarios" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Gestion de Usuarios</p>
                  </a>
                </li>
                
              </ul>
          </li>
        </ul>
      </nav>
    
      <?php
      } elseif ($usuario_rol == 'INFORMATICO') {
          // Mostrar solo las opciones de menú para Informatico
      ?>
      <!-- Opciones de menú para Informatico -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="#" class="nav-link">
              <i class="fa fa-hospital-o"></i>
                <p>
                  Reportes Inventario
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=patrimonio" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Patrimonio</p>
                  </a>
                </li>
                
              </ul>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=desplazamientos" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Desplazamientos</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../views/index.php?view=graficos" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Gráficos</p>
                  </a>
                </li>
              </ul>
          </li>
        </ul>
      </nav>
      
      <?php
      }
      ?>
    </div>

</aside>