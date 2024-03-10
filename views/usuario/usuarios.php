<div class="container">
    <div class="row mb-4" style="margin: 10px;">
        <div class="col-sm-6" style="text-align: left;">
            <h3 class="m-0"><b>MANTENIMIENTO DE USUARIOS</b></h3>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-primary btn-sm float-right" onclick="AbrirModalRegistroUsuario()"><i class="fas fa-plus"></i>
                Nuevo Registro
            </button>
        </div>
    </div>

    <!-- Agrega la tabla con DataTable -->
    <table id="tbl_usuario" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Correo</th>
                <th>Contraseña</th>
                <th>Rol De Usuario</th>
                <th>Estado</th>
                <th>Aciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- ... Agrega más filas según sea necesario ... -->
        </tbody>
    </table>

    <!-- Inicio Modal REGISTRO -->
    <div class="modal fade" id="modal_registro_usuario" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Nombre de Usuario</label>
                            <input type="text" id="txt_nombres" placeholder="Ingresar nombres" 
                            class="form-control" onkeypress="return validaLetras(event);" onpaste="return false">
                            <label for="">Email</label>
                            <input type="email" id="txt_email" placeholder="usuario@gmail.com" class="form-control">
                            <label for="">Contraseña</label>
                            <input type="password" id="txt_pass" placeholder="Ingresar contraseña"  
                            class="form-control" onpaste="return false">

                            <label>Pregunta Secreta</label>
                            <input type="text" id="txt_pregunta" placeholder="Ingresar pregunta secreta" 
                            class="form-control">
                            <label>Respuesta</label>
                            <input type="text" id="txt_respuesta" placeholder="Ingresar respuesta" 
                            class="form-control">

                            <label for="">Rol de Usuario</label>
                            <select class="form-control" name="select_rol" id="select_rol" style="width:100%;">
                                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                <option value="INFORMATICO">INFORMATICO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Registrar_Usuario()">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

    <!-- Inicio Modal MODIFICAR-->
    <div class="modal fade" id="modal_editar_usuario" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Nombre de Usuario</label>
                            <input type="text" id="txt_id_editar" hidden>
                            <input type="text" id="txt_nombres_editar" class="form-control" 
                            onkeypress="return validaLetras(event);" onpaste="return false">
                            <label for="">Email</label>
                            <input type="email" id="txt_email_editar" class="form-control" 
                            onpaste="return false">
                            <label for="">Contraseña</label>
                            <input type="password" id="txt_pass_editar" class="form-control" 
                            onpaste="return false">

                            <label>Pregunta Secreta</label>
                            <input type="text" id="txt_pregunta_editar" class="form-control">
                            <label>Respuesta</label>
                            <input type="text" id="txt_respuesta_editar" class="form-control">

                        </div>
                        <div class="col-6" style="padding-top: 5px">
                            <label for="">Rol Usuario</label>
                            <select class="form-control" name="select_rol_editar" id="select_rol_editar" style="width:100%;">
                                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                <option value="INFORMATICO">INFORMATICO</option>
                            </select><br>
                        </div>
                        <div class="col-4" style="padding-top: 5px">
                            <label for="">Estado</label>
                            <select class="form-control" name="select_estado_editar" id="select_estado_editar" style="width:100%;">
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select><br>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="Modificar_Usuario()">Modificar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

</div>