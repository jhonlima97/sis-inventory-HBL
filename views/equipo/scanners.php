<div class="container">
    <div class="row mb-4" style="margin: 10px;">
        <div class="col-sm-6" style="text-align: left;">
            <h3 class="m-0"><b>MANTENIMIENTO DE SCANNERS </b></h3>
        </div>
        <div class="col-sm-6">

            <button class="btn btn-primary btn-sm float-right" onclick="AbrirModalRegistroScanner()"><i class="fas fa-plus"></i>
                Nuevo Registro
            </button>
        </div>
    </div>

    <table id="tbl_scanners" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cod_Patrimonial</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Sis. Ope.</th>
                <th>Velocidad</th>
                <th>Resolución</th>           
                <th>Área</th>
                <th>Estado</th>
                <th>Aciones</th>
            </tr>
            </thead>
        <tbody>

        </tbody>
    </table>

    <!-- Inicio Modal REGISTRO -->
    <div class="modal fade" id="modal_registro_scanner" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de Scanners</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-4">
                            <label for="">Cod. Patrimonial
                            <input type="text" id="txt_cod" placeholder="Ingresar código" 
                            class="form-control" onpaste="return false">
                            </label>
                            <label for="">Seleccione Marca
                                <select class="form-control" name="select_marca" id="select_marca" style="width:100%;">
                                <option value="EPSON">EPSON</option>
                                <option value="CANON">CANON</option>
                                <option value="HP">HP</option>
                                <option value="XEROX">XEROX</option>
                                <option value="BROTHER">BROTHER</option>
                                </select>
                            </label>
                            <label for="">Modelo
                            <input type="text" id="txt_modelo" placeholder="Ingresar modelo" 
                            class="form-control" onpaste="return false">
                            </label>
                        </div> 
                        <!-- Columna 2 -->
                        <div class="col-md-4">
                            <label for="">Serie
                                <input type="text" id="txt_serie" placeholder="Ingresar serie" 
                                class="form-control" onpaste="return false">
                            </label>
                            <label for="">Sistema Operativo
                            <input type="text" id="txt_sis_ope" placeholder="Ingresar nombre del sistema operativo" 
                            class="form-control" onpaste="return false">
                            </label>

                            <label for="">Velocidad
                            <input type="text" id="txt_velocidad" placeholder="Ingresar nombre del sistema operativo" 
                            class="form-control" onpaste="return false">
                            </label>
                        </div>

                        <div class="col-md-4">
                            <label for="">Resolución
                                <input type="text" id="txt_resolucion" placeholder="Ingresar nombre del sistema operativo" 
                                class="form-control" onpaste="return false">
                            </label>
                            <label for="">Área
                                <select class="form-control" name="select_area" id="select_area" style="width:100%;">
                                    <!-- Opciones de área en js -->
                                </select>
                                </label><br>
                                <label for="">Estado</label>
                                <select class="form-control" name="select_estado" id="select_estado" style="width:70%;">
                                    <option value="BUENO">BUENO</option>
                                    <option value="MALO">MALO</option>
                                </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Registrar_Scanner()">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

    <div class="modal fade" id="modal_editar_scanner" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos Scanner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-4">
                                                        
                            <label for="">Seleccione Marca
                                <input type="text" id="txt_cod_editar" hidden>
                                <select class="form-control" name="select_marca_editar" id="select_marca_editar" style="width:100%;">
                                <option value="CANON">CANON</option>
                                <option value="EPSON">EPSON</option>
                                <option value="XEROX">XEROX</opton>
                                <option value="HP">HP</option>
                                <option value="BROTHER">BROTHER</option>
                                </select>
                            </label>
                            <label for="">Modelo
                            <input type="text" id="txt_modelo_editar" class="form-control">
                            </label>
                            <label for="">Serie
                            <input type="text" id="txt_serie_editar" class="form-control">
                            </label>
                        </div>
                        <!-- Columna 2 -->
                        <div class="col-md-4">
                            <label for="">Sistema operativo
                            <input type="text" id="txt_so_editar" class="form-control" onpaste="return false">
                            </label>
                            <label for="">Velocidad
                            <input type="text" id="txt_velocidad_editar" class="form-control">
                            </label>
                            <label for="">Resolución
                            <input type="text" id="txt_resol_editar" class="form-control" onpaste="return false">
                            </label>
                        </div>
                        <!-- Columna 3 -->
                        <div class="col-md-4">
                            <label for="">Seleccione Área
                            <select class="form-control" name="select_area_editar" id="select_area_editar" style="width:100%;">
                                <!-- Opciones de área en js -->
                            </select>
                            </label><br>
                            <label for="">Estado</label>
                            <select class="form-control" name="select_estado_editar" id="select_estado_editar" style="width:100%;">
                                <option value="BUENO">BUENO</option>
                                <option value="MALO">MALO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Modificar_Scanner()">Modificar</button>
                </div>
            </div>
        </div>
    </div>
</div>