    
<div class="col-lg-12" style="padding-top: 10px;">
    <div class="card">
        <div class="card-header">
            <b>GRAFICOS ESTADÍSTICOS CON CHART JS</b>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2">
                    <button class="btn btn-primary btn-sm" onclick="getNumEquiposBar1()">Grafico Bar Vertical</button>

                </div>

                <div class="col-lg-2">
                    <button class="btn btn-primary btn-sm" style="width: 110%" onclick="getNumEquiposBar2()">Grafico Bar Horizontal</button>

                </div>
                <canvas id="myChart" width="100" height="50"></canvas>

            </div>
            
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
</div>


<!-- Libreria y archivo js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script src="../libs/js/graficos.js?rev=<?php echo time(); ?>"></script>
