<div class="container">
    <div class="row mb-4" style="margin: 10px;">
        <div class="col-sm-6" style="text-align: left;">
            <h3 class="m-0"><b>MANTENIMIENTO DE IMPRESORAS</b></h3>
        </div>
        <div class="col-sm-6">
            
            <button class="btn btn-primary btn-sm float-right" onclick="AbrirModalRegistroImpresora()"><i class="fas fa-plus"></i>
                Nuevo Registro
            </button>
        </div>
    </div>

    <!-- Agrega la tabla con DataTable -->
    <table id="tbl_impresoras" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cod_Patrimonial</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>N° Toner</th>
                <th>Área</th>
                <th>Estado</th>
                <th>Aciones</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <!-- Inicio Modal REGISTRO -->
    <div class="modal fade" id="modal_registro_impresora" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de Impresoras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <label for="">Cod. Patrimonial</label>
                            <input type="text" id="txt_cod" placeholder="Ingresar código" 
                            class="form-control" onpaste="return false">
                            
                            <label for="">Seleccione Marca</label>
                                <select class="form-control" name="select_marca" id="select_marca" style="width:100%;">
                                <option value="Canon">Canon</option>
                                <option value="Brother">Brother</option>
                                <option value="Epson">Epson</option>
                                <option value="DELL">DELL</option>
                                <option value="SAMSUNG">SAMSUNG</option>
                                <option value="Xerox">Xerox</option>
                                </select>
                            
                            <label for="">Modelo</label>
                            <input type="text" id="txt_modelo" placeholder="Ingresar modelo" 
                            class="form-control" onpaste="return false">
                            

                            <label for="">Serie</label>
                            <input type="text" id="txt_serie" placeholder="Ingresar serie" 
                            class="form-control" onpaste="return false">
                            
                        </div> 
                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <label for="">N° Toner</label>
                            <input type="text" id="txt_toner" placeholder="Ingresar número de toner" 
                            class="form-control" onpaste="return false">
                            

                            <label for="">Área</label>
                            <select class="form-control" name="select_area" id="select_area" style="width:100%;">
                                <!-- Opciones de área en js -->
                            </select>
                            
                            <label for="">Estado</label>
                            <select class="form-control" name="select_estado" id="select_estado" style="width:100%;">
                                <option value="BUENO">BUENO</option>
                                <option value="MALO">MALO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Registrar_Impresora()">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

     <!-- Inicio Modal MODIFICAR-->
     <div class="modal fade" id="modal_editar_impresora" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos Impresora</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                                                        
                            <label for="">Seleccione Marca</label>
                                <input type="text" id="txt_cod_editar" hidden>
                                <select class="form-control" name="select_marca_editar" id="select_marca_editar" style="width:100%;">
                                <option value="Canon">Canon</option>
                                <option value="Brother">Brother</option>
                                <option value="Epson">Epson</option>
                                <option value="DELL">DELL</option>
                                <option value="SAMSUNG">SAMSUNG</option>
                                <option value="Xerox">Xerox</option>
                                </select>
                            
                            <label for="">Modelo</label>
                            <input type="text" id="txt_modelo_editar" class="form-control">
                            
                            <label for="">Serie</label>
                            <input type="text" id="txt_serie_editar" class="form-control">
                            
                        </div>
                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <label for="">N° Toner</label>
                                <input type="text" id="txt_toner_editar" class="form-control" onpaste="return false">
                            

                            <label for="">Seleccione Área</label>
                            <select class="form-control" name="select_area_editar" id="select_area_editar" style="width:100%;">
                                <!-- Opciones de área en js -->
                            </select>


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
                    <button type="button" class="btn btn-primary" onclick="Modificar_Impresora()">Modificar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

</div>