<div class="container">
    <div class="row mb-4" style="margin-top: 10px;">
        <div class="col-sm-8">
            <h3><b>DESPLAZAMIENTOS DE EQUIPOS INFORMÁTICOS</b></h3>
        </div>
        <div class="col-sm-4">
        <button class="btn btn-success btn-sm float-right" 
            onclick="window.location.href='../views/index.php?view=registro_desplazamiento'"><i class="fas fa-plus"></i>
                Nuevo registro
            </button>
        </div>
    </div>


    <!-- Agrega la tabla con DataTable -->
    <table id="tbl_desplazamientos" class="table table-striped table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th>N°</th>
                <th>Motivo</th>
                <th>Área proveniente</th>
                <th>Responsable proveniente</th>
                <th>Área asignada</th>
                <th>Responsable asignado</th>
                <th>Fecha</th>
                <th>Códigos Patrimoniales</th>
                <th>Ver Equipos</th>
                <th>Aciones</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>



    <!-- Inicio Modal Editar fecha-->
    <div class="modal fade" id="modal_reporte_fecha" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Fecha Reporte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for=""> N° Registro
                                <input type="text" id="txt_cod_actualizar" placeholder="Número de registro" class="form-control" readonly onpaste="return false">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label for="">Fecha
                                <input type="date" class="form-control" id="fecha_actualizar" name="fecha_actualizar">
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Editar_fecha_reporte()">Modificar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

    <!-- Inicio Modal  Detalle Desplazamiento-->
    <div class="modal fade" id="modal_visualizar_detalle" aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle de desplazamiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="tbl_detalle" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Cod. Patrimonial</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../libs/js/desplazamientos.js"></script>