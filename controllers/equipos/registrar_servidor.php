<?php
    require '../../models/model_servidores.php';
    
    $MSE = new Model_Servidores();//Instanciamos
    
    $cod_patrimonial= htmlspecialchars($_POST['cod_patrimonial'],ENT_QUOTES,'UTF-8');
    $nombre     = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
    $marca      = htmlspecialchars($_POST['marca'],ENT_QUOTES,'UTF-8');
    $modelo     = htmlspecialchars($_POST['modelo'],ENT_QUOTES,'UTF-8');
    $serie      = strtoupper(htmlspecialchars($_POST['serie'],ENT_QUOTES,'UTF-8'));
    $sis_ope    = htmlspecialchars($_POST['sis_ope'],ENT_QUOTES,'UTF-8');
    $ip         = htmlspecialchars($_POST['ip'],ENT_QUOTES,'UTF-8');
    $procesador = htmlspecialchars($_POST['procesador'],ENT_QUOTES,'UTF-8');
    $ram        = htmlspecialchars($_POST['ram'],ENT_QUOTES,'UTF-8');
    $disco      = htmlspecialchars($_POST['disco'],ENT_QUOTES,'UTF-8');
    $area       = htmlspecialchars($_POST['area_id'],ENT_QUOTES,'UTF-8');
    $estado     = htmlspecialchars($_POST['estado'],ENT_QUOTES,'UTF-8');

    $consulta = $MSE->registrar_servidor(
                                    $cod_patrimonial,$nombre, $marca,$modelo,$serie,
                                    $sis_ope,$ip,$procesador,
                                    $ram,$disco,$area,$estado); 
    
    echo $consulta;
    
?>