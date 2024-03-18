<div class="container">
    <div class="row mb-4" style="margin-top: 10px;">
        <div class="col-sm-6">
            <h3><b>MANTENIMIENTO DE SWITCHES</b></h3>
        </div>
        <div class="col-sm-6">
            
            <button class="btn btn-primary btn-sm float-right" onclick="AbrirModalRegistroSwitch()"><i class="fas fa-plus"></i>
                Nuevo Registro
            </button>
        </div>
    </div>

    <!-- Agrega la tabla con DataTable -->
    <table id="tbl_switches" class="table table-striped table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cod_Patrimonial</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Puertos</th>
                <th>Área</th>
                <th>Estado</th>
                <th>Aciones</th>
            </tr>

        </thead>
        <tbody>

        </tbody>
    </table>

        <!-- Inicio Modal REGISTRO -->
    <div class="modal fade" id="modal_registro_switch" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Registro de Switches</h5>
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

                                <label for="">Nombre
                                <input type="text" id="txt_nombre" placeholder="Ingresar nombre del switch" 
                                class="form-control" onkeypress="return validaLetras(event);" onpaste="return false">
                                </label>
                                <label for="">Seleccione Marca
                                    <select class="form-control select2-dropdown" name="select_marca" id="select_marca" style="width:100%;">
                                    <option value="D-LINK">D-LINK</option>
                                    <option value="ZyXel">ZyXel</option>
                                    <option value="Mitrastar">Mitrastar</option>
                                    <option value="Tp Link">Tp Link</option>
                                    <option value="Advantek Networks">Advantek Networks</option>
                                    <option value="ZTE">ZTE</option>
                                    <option value="Cisco">Cisco</option>
                                    <option value="HP">HP</option>
                                    <option value="Netgear">Netgear</option> 
                                    </select>
                                </label>
                            </div> 
                            <!-- Columna 2 -->
                            <div class="col-md-4">

                                <label for="">Modelo
                                    <input type="text" id="txt_modelo" placeholder="Ingresar modelo" 
                                    class="form-control" onkeypress="return validaLetras(event);" onpaste="return false">
                                </label>

                                <label for="">Serie
                                    <input type="text" id="txt_serie" placeholder="Ingresar serie" 
                                    class="form-control" onpaste="return false">
                                </label>
                                <label for="">Puertos
                                    <input type="number" id="txt_puerto" placeholder="Ingresar n° de puerto" 
                                    class="form-control" min="0" onpaste="return false">
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label for="">Área
                                    <select class="form-control select2-dropdown" name="select_area" id="select_area" style="width:100%;">
                                    <!-- Opciones de área en js -->
                                    </select>

                                </label><br>
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
                        <button type="button" class="btn btn-primary" onclick="Registrar_Switch()">Registrar</button>
                    </div>
                </div>
            </div>
    </div>
    <!-- Fin Modal -->

    <!-- Inicio Modal MODIFICAR-->
    <div class="modal fade" id="modal_editar_switch" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos Switch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-4">
                            <label for="">Nombre
                                <input type="text" id="txt_nombre_editar" class="form-control">
                            </label>
                                                        
                            <label for="">Seleccione Marca
                                <input type="text" id="txt_cod_editar" hidden>
                                <select class="form-control select2-dropdown" name="select_marca_editar" id="select_marca_editar" style="width:100%;">
                                <option value="D-LINK">D-LINK</option>
                                <option value="TP ALTRON">TP ALTRON</option>
                                <option value="ZyXel">ZyXel</option>
                                <option value="Mitrastar">Mitrastar</option>
                                <option value="Tp Link">Tp Link</option>
                                <option value="Advantek Networks">Advantek Networks</option>
                                <option value="ZTE">ZTE</option>
                                <option value="Cisco">Cisco</option>
                                <option value="HP">HP</option>
                                <option value="Netgear">Netgear</option>  
                                </select>
                            </label>
                            <label for="">Modelo
                            <input type="text" id="txt_modelo_editar" class="form-control">
                            </label>
                            
                    
                        </div>
                        <!-- Columna 2 -->
                        <div class="col-md-4">
                            <label for="">Serie
                                <input type="text" id="txt_serie_editar" class="form-control">
                            </label>
                            <label for=""> Puertos
                            <input type="number" id="txt_puerto_editar" class="form-control" min="0" onpaste="return false">
                            </label>
                        </div>
                        <!-- Columna 3 -->
                        <div class="col-md-4">
                            <label for="">Seleccione Área
                            <select class="form-control select2-dropdown" name="select_area_editar" id="select_area_editar" style="width:100%;">
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
                    <button type="button" class="btn btn-primary" onclick="Modificar_Switch()">Modificar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

</div>