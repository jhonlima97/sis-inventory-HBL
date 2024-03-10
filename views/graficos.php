<div class="col-lg-12" style="padding-top: 5px;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <b>GRAFICOS CHART JS SIN PARÁMETROS</b>
            <button type="button" class="btn bg-info btn-sm ml-auto" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>

        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-5" style="border: 1px solid black;">
                    <!-- Aquí iba el botón del gráfico de barras vertical -->
                    <canvas id="myChart1" width="100" height="100"></canvas>
                </div>
                <div class="col-lg-5" style="border: 1px solid black; margin-left: 10px;">
                    <!-- Aquí iba el botón del gráfico de barras horizontal -->
                    <canvas id="myChart2" width="100" height="100"></canvas>
                </div> <br>
                <div class="col-lg-5" style="border: 1px solid black; margin-top:10px">
                    <!-- Aquí iba el botón del gráfico de barras horizontal -->
                    <canvas id="myChart3" width="100" height="100"></canvas>
                </div>
                <div class="col-lg-5" style="border: 1px solid black; margin-top:10px;margin-left: 10px">
                    <!-- Aquí iba el botón del gráfico de barras horizontal -->
                    <canvas id="myChart4" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <b>GRAFICOS CHART JS CON PARÁMETROS</b>
            <button type="button" class="btn bg-info btn-sm ml-auto" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>

        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <label for="">Seleccione Un Año</label>
                    <select name="select-anio" id="select-anio" class="form-control"></select>
                </div>
                <div class="col-lg-5">
                    <label for="">&nbsp;</label><br>
                    <button class="btn btn-danger" onclick="MostrarGraficosParams()">BUSCAR</button>
                </div>
                
                <div class="col-lg-5" style="border: 1px solid black; margin-top: 20px;">
                    <!-- Aquí iba el botón del gráfico de barras vertical -->
                    <canvas id="myChart1_param" width="100" height="100"></canvas>
                </div>
                <div class="col-lg-5" style="border: 1px solid black; margin-top: 20px; margin-left: 10px;">
                    <!-- Aquí iba el botón del gráfico de barras vertical -->
                    <canvas id="myChart2_param" width="100" height="100"></canvas>
                </div>
                <div class="col-lg-5" style="border: 1px solid black; margin-top:10px">
                    <!-- Aquí iba el botón del gráfico de barras vertical -->
                    <canvas id="myChart3_param" width="100" height="100"></canvas>
                </div>
                <div class="col-lg-5" style="border: 1px solid black;margin-top:10px;margin-left: 10px">
                    <!-- Aquí iba el botón del gráfico de barras vertical -->
                    <canvas id="myChart4_param" width="100" height="100"></canvas>
                </div>
                
            </div>
        </div>

    </div>
</div>


<!-- Libreria y archivo js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../libs/js/graficos.js?rev=<?php echo time(); ?>"></script>
