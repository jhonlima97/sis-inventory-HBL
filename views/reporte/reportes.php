<div class="container">
    <div class="row mb-4" style="margin: 10px;">
        <div class="col-sm-6" style="text-align: left;">
            <h3 class="m-0"><b>REPORTES DE EQUIPOS DADOS DE BAJA</b></h3>
        </div>
        
    </div>

    <div class="row mb-4" style="margin: 10px;">
        <div class="col-md-8"> <!-- Utiliza la clase "col-md-6" para que ambos elementos ocupen la mitad del ancho en dispositivos medianos y grandes -->
            <label for="form-control">Seleccione Un Tipo de bien para ver su Reporte</label>
            <div class="d-flex"> <!-- Utiliza la clase "d-flex" para establecer un contenedor flexible y ajustar los elementos dentro -->
                <select class="form-control" name="select_bien" id="select_bien" style="width:70%;"> <!-- Ajusta el ancho según sea necesario -->
                <option value="" selected>Seleccione uno</option> <!-- Modificado para iniciar seleccionado -->
                    <option value="COMPUTADORAS">COMPUTADORAS</option>
                    <option value="IMPRESORAS">IMPRESORAS</option>
                    <option value="SERVIDORES">SERVIDORES</option>
                    <option value="SWITCHES">SWITCHES</option>
                    <option value="PERIFERICOS">PERIFERICOS</option>
                    <option value="SCANNERS">SCANNERS</option>
                </select>
                <button class="btn btn-primary " name = "mostrar_reporte" onclick="Reporte_bajas()" style="margin-left: 10px;"><i class="fas fa-file-pdf"></i></button> <!-- Ajusta el margen izquierdo según sea necesario -->
                <!--<i class="fa-regular fa-file-pdf"></i>
                <div>
                    <a target="_blank" class="fcc-btn" href="../views/fpdf/PruebaV.php">Ver Reporte <i class="far fa-file-pdf"></i></a>  
                </div>-->
            </div>
        </div>
    </div>

    <!-- Agrega la tabla con DataTable -->
    <table id="tbl_reporte" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>N.°</th>
                <th>Area/Unid.</th>
                <th>Tipo de Bien</th>
                <th>Cod. Patrimonial</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Estado</th>
                <!--<th>Aciones</th>-->
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>