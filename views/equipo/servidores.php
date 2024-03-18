<div class="container">
    <div class="row mb-4" style="margin-top: 10px;">
        <div class="col-sm-6">
            <h3><b>MANTENIMIENTO DE SERVIDORES</b></h3>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-primary btn-sm float-right" onclick="AbrirModalRegistroServidor()"><i class="fas fa-plus"></i>
                Nuevo Registro
            </button>
        </div>
    </div>

    <!-- Agrega la tabla con DataTable -->
    <table id="tbl_servidores" class="table table-striped table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cod_Patrimonial</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Sis. Ope.</th>
                <th>IP</th>
                <th>Procesador</th>
                <th>RAM</th>
                <th>Disco</th>
                <th>Área</th>
                <th>Estado</th>
                <th>Aciones</th>
            </tr>
            </thead>
        <tbody>

        </tbody>
    </table>

    <!-- Inicio Modal REGISTRO -->
    <div class="modal fade" id="modal_registro_servidor" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de servidores</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-4">
                            <label for="txt_cod">Cod. Patrimonial
                            <input type="text" id="txt_cod" placeholder="Ingresar código" 
                            class="form-control" onpaste="return false">
                            </label>
                            <label for="txt_nombre">Nombre
                            <input type="text" id="txt_nombre" placeholder="Ingresar nombre del servidor" 
                            class="form-control" onkeypress="return validaLetras(event);" onpaste="return false">
                            </label>
                            <label for="select_marca">Seleccione Marca
                                <select class="form-control select2-dropdown" name="select_marca" id="select_marca" style="width:100%;">
                                <option value="HP">HP</option>
                                <option value="Altron">Altron</option>
                                <option value="IBM">IBM</option>
                                <option value="Micronics">Micronics</option>
                                <option value="DELL">DELL</option>
                                <option value="Lenovo">Lenovo</option>
                                <option value="Intel">Intel</option>
                                <option value="Cisco">Cisco</option>
                                </select>
                            </label>
                            <label for="txt_modelo">Modelo
                            <input type="text" id="txt_modelo" placeholder="Ingresar modelo" 
                            class="form-control" onpaste="return false">
                            </label>

                            
                        </div> 
                        <!-- Columna 2 -->
                        <div class="col-md-4">
                            <label for="txt_serie">Serie
                            <input type="text" id="txt_serie" placeholder="Ingresar serie" 
                            class="form-control" onpaste="return false">
                            </label>
                            <label for="txt_so">Sistema operativo
                            <input type="text" id="txt_so" placeholder="Ingresar SO" 
                            class="form-control" onpaste="return false">
                            </label>

                            <label for="txt_ip">IP *Opcional*
                            <input type="text" id="txt_ip" placeholder="Ingresar IP" class="form-control">
                            </label>
                            <label for="txt_procesador">Procesador
                            <input type="text" id="txt_procesador" placeholder="Ingresar procesador" 
                            class="form-control" onkeypress="return validaLetras(event);" onpaste="return false">
                            </label>

                            
                        </div>
                        <!-- Columna 3 -->
                        <div class="col-md-4">
                            <label for="select_ram">Memoria RAM
                                <select class="form-control" name="select_ram" id="select_ram" style="width:100%;">
                                <option value="2GB">2GB</option>
                                <option value="4GB">4GB</option>
                                <option value="8GB">8GB</option>
                                <option value="12GB">12GB</option>
                                <option value="16GB">16GB</option>
                                <option value="32GB">32GB</option>
                                </select>
                            </label>
                            <label for="txt_disco">Disco
                            <input type="text" id="txt_disco" placeholder="Ingresar disco" 
                            class="form-control" onpaste="return false">
                            </label>
                            <label for="select_area">Área
                            <select class="form-control select2-dropdown" name="select_area" id="select_area" style="width:100%;">
                                <!-- Opciones de área en js -->
                            </select>
                            </label><br>
                            <label for="select_estado">Estado</label>
                            <select class="form-control" name="select_estado" id="select_estado" style="width:100%;">
                                <option value="BUENO">BUENO</option>
                                <option value="MALO">MALO</option>
                            </select>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Registrar_Servidor()">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

     <!-- Inicio Modal MODIFICAR-->
     <div class="modal fade" id="modal_editar_servidor" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos Servidor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-4">

                            <label for="txt_nombre_editar">Nombre
                                <input type="text" id="txt_nombre_editar" class="form-control">
                            </label>
                                                        
                            <label for="select_marca_editar">Seleccione Marca
                                <input type="text" id="txt_cod_editar" hidden>
                                <select class="form-control select2-dropdown" name="select_marca_editar" id="select_marca_editar" style="width:100%;">
                                    <option value="HP">HP</option>
                                    <option value="Altron">Altron</option>
                                    <option value="IBM">IBM</option>
                                    <option value="Micronics">Micronics</option>
                                    <option value="DELL">DELL</option>
                                    <option value="Lenovo">Lenovo</option>
                                    <option value="Intel">Intel</option>
                                    <option value="Cisco">Cisco</option>
                                </select>
                            </label>
                            <label for="txt_modelo_editar">Modelo
                            <input type="text" id="txt_modelo_editar" class="form-control">
                            </label>
                            <label for="txt_serie_editar">Serie
                            <input type="text" id="txt_serie_editar" class="form-control">
                            </label>
                            
                        </div>
                        <!-- Columna 2 -->
                        <div class="col-md-4">
                            <label for="txt_ip_editar">IP *Opcional*
                            <input type="text" id="txt_ip_editar" class="form-control">
                            </label>
                            <label for="txt_procesador_editar">Procesador
                            <input type="text" id="txt_procesador_editar" class="form-control" onpaste="return false">
                            </label>
                            <label for="select_ram_editar">Memoria RAM
                                <select class="form-control" name="select_ram_editar" id="select_ram_editar" style="width:100%;">
                                <option value="2GB">2GB</option>
                                <option value="4GB">4GB</option>
                                <option value="8GB">8GB</option>
                                <option value="12GB">12GB</option>
                                <option value="16GB">16GB</option>
                                <option value="32GB">32GB</option>
                                </select>
                            </label>
                            <label for="txt_so_editar">Sistema operativo
                            <input type="text" id="txt_so_editar" class="form-control" onpaste="return false">
                            </label>
                        </div>
                        <!-- Columna 3 -->
                        <div class="col-md-4">
                            <label for="txt_disco_editar">Disco
                            <input type="text" id="txt_disco_editar" class="form-control" onpaste="return false">
                            </label>
                            <label for="select_area_editar">Seleccione Área
                            <select class="form-control select2-dropdown" name="select_area_editar" id="select_area_editar" style="width:100%;">
                                <!-- Opciones de área en js -->
                            </select>
                            </label><br>
                            <label for="select_estado_editar">Estado</label>
                            <select class="form-control" name="select_estado_editar" id="select_estado_editar" style="width:100%;">
                                <option value="BUENO">BUENO</option>
                                <option value="MALO">MALO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Modificar_Servidor()">Modificar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->


</div>