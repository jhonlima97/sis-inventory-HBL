<footer class="main-footer" style="margin-left: auto;">
    <strong>Copyright &copy; 2023-2024 <b>Hospital "Belén" - Lambayeque</b>.</strong> <br>
     Desarrollado por María Gabriela Santillán Cabrejos
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>


<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="../libs/js/adminlte.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>

<!-- Agrega los scripts de jQuery, DataTables y Bootstrap -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- CDN de select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- LLamo a mis js de mis tablas -->
<script src="../libs/js/usuario.js?rev=<?php echo time(); ?>"></script>
<script src="../libs/js/areas.js?rev=<?php echo time(); ?>"></script>
<script src="../libs/js/computadoras.js?rev=<?php echo time(); ?>"></script>
<script src="../libs/js/impresoras.js?rev=<?php echo time(); ?>"></script>
<script src="../libs/js/servidores.js?rev=<?php echo time(); ?>"></script>
<script src="../libs/js/scanners.js?rev=<?php echo time(); ?>"></script>
<script src="../libs/js/switches.js?rev=<?php echo time(); ?>"></script>
<script src="../libs/js/perifericos.js?rev=<?php echo time(); ?>"></script>
<script src="../libs/js/reportes.js?rev=<?php echo time(); ?>"></script>
  
<script>
  // Inicializa las tablas con DataTable
  $(document).ready(function() {

    listar_areas();
    listar_usuarios();
    listar_computadoras();
    listar_impresoras();
    listar_servidores();
    listar_switches();
    listar_perifericos();
    //desplzamientos
    //listar_asignaciones();
    // Inicializa el DataTable vacio en la vista del reporte Patrimonio
    getTabla('');
    //getTabladetalle();
    //listar_detalle_desplazamiento();
    
  });

  // Obtener referencias a los elementos relevantes del DOM
  var nombreUsuario = document.getElementById('nombreUsuario');
  var cerrarSesionBtn = document.getElementById('cerrarSesionBtn');

  // Agregar evento de clic al nombre de usuario
  nombreUsuario.addEventListener('click', function() {
      // Mostrar u ocultar el botón de cerrar sesión
      if (cerrarSesionBtn.style.display === 'none') {
          cerrarSesionBtn.style.display = 'block';
      } else {
          cerrarSesionBtn.style.display = 'none';
      }
  });
    
</script>
</body>
</html>

