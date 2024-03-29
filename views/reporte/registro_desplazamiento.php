<div class="container">
    <div class="row mb-4" style="margin-top: 10px;">
        <div class="col-sm-12">
            <h3><b>GESTIÓN DE ASIGNACIONES</b></h3>
        </div>
    </div>
    <!-- Aquí empieza el formulario -->

    <form class="needs-validation" novalidate>
        <!--DATOS GENERALES -->
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="input-group col-3 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">N° Registro</label>
                        </div>
                        <input type="text" id="txt_cod" class="form-control" readonly onpaste="return false">
                    </div>
                    <div class="input-group col-5 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Motivo</label>
                        </div>
                        <select class="form-control" name="select_motivo" id="select_motivo">
                            <option value="Desplazamiento" disabled selected>Desplazamiento</option>
                            <!--<option value="Asignación">Asignación</option>-->
                        </select>
                    </div>

                    <div class="input-group col-4 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Fecha</label>
                        </div>
                        <input type="date" class="form-control" id="fecha" name="fecha">
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group col-6 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Área proveniente</label>
                        </div>
                        <select class="form-control" name="select_area_prov" id="select_area_prov" style="width: 50%;">
                            <!-- Opciones de área en js -->
                        </select>
                    </div>

                    <div class="input-group col-6 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Responsable proveniente</label>
                        </div>
                        <input type="text" name="select_resp" id="select_resp" readonly class="form-control">
                    </div>

                    <div class="input-group col-6 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Área asignada</label>
                        </div>
                        <select class="form-control" name="select_area_asig" id="select_area_asig" style="width: 50%;">
                            <!-- Opciones de área en js -->

                        </select>
                    </div>

                    <div class="input-group col-6 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Responsable asignado</label>
                        </div>
                        <input type="text" name="select_resp_asig" id="select_resp_asig" readonly class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <!--BUSQUEDA DE BIEN-->
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="input-group col-5 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Tipo de bien</label>
                        </div>
                        <select class="form-control" name="select_bien" id="select_bien"> <!-- Ajusta el ancho según sea necesario -->
                        </select>
                    </div>

                    <div class="input-group col-7 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Código Patrimonial</label>
                        </div>
                        <input type="text" id="txt_cod_patrimonial" placeholder="Ingresar código" class="form-control">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="Buscar_Bien()">Buscar</button>
                        </div>
                    </div>

                </div>

                <div class="form-row">
                    <div class="input-group col-3 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Marca</label>
                        </div>
                        <input type="text" id="txt_marca" class="form-control" readonly>
                    </div>

                    <div class="input-group col-4 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Modelo</label>
                        </div>
                        <input type="text" id="txt_modelo" class="form-control" readonly>
                    </div>

                    <div class="input-group col-5 mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Serie</label>
                        </div>
                        <input type="text" id="txt_serie" class="form-control" readonly>
                        <button type="button" class="btn btn-primary" onclick="AgregarEquipo()">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Tabla-->
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <table id="equipos-table" class="table table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Tipo de Bien</th>
                                <th>Cod. Patrimonial</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                                <th>Opción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se agregarán las filas dinámicamente -->
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-footer " style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='../views/index.php?view=desplazamientos'">Volver</button>
                <button type="button" class="btn btn-primary" onclick="Registrar_Asignacion()">Registrar</button>
            </div>

        </div>


    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script src="../libs/js/registro_desplazamiento.js"></script>

<script>
    
// Carga el select2 de la tabla
  $(document).ready(function() {
    $('#select_area_prov').select2();
    $('#select_area_asig').select2();

  });
</script>