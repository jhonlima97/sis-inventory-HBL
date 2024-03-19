<div class="container">
    <div class="row mb-4" style="margin-top: 10px;">
        <div class="col-sm-6">
            <h3><b>MANTENIMIENTO DE ÁREAS</b></h3>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-primary btn-sm float-right" onclick="AbrirModalRegistroArea()"><i class="fas fa-plus"></i>
                Nuevo Registro
            </button>
        </div>
    </div>
    <!-- Hola -->

    <!-- Agrega la tabla con DataTable -->
    <table id="tbl_area" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Responsable Funcional</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- ... Agrega más filas según sea necesario ... -->
        </tbody>
    </table>


    <!-- Inicio Modal REGISTRO -->
    <div class="modal fade" id="modal_registro_area" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de Área</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="txt_nombre">Nombre de Área</label>
                            <input type="text" id="txt_nombre" placeholder="Ingresar area" 
                            class="form-control" onkeypress="return validaLetras(event);" onpaste="return false">
                            
                            <label for="txt_responsable">Responsable Funcional</label>
                            <input type="text" id="txt_responsable" placeholder="Ingresar responsable" 
                            class="form-control" onkeypress="return validaLetras(event);" onpaste="return false">
                        
                        </div>
                        <div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Registrar_Area()">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

    <!-- Inicio Modal MODIFICAR-->
    <div class="modal fade" id="modal_editar_area" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos Área</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="txt_nombre_editar">Nombre Área</label>
                            <input type="text" id="txt_idarea_editar" hidden>
                            <input type="text" id="txt_nombre_editar" class="form-control" 
                            onkeypress="return validaLetras(event);" onpaste="return false">
                            <label for="txt_responsable_editar">Responsable Funcional</label>
                            <input type="text" id="txt_responsable_editar" class="form-control" 
                            onkeypress="return validaLetras(event);" onpaste="return false">
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Modificar_Area()">Modificar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

</div>