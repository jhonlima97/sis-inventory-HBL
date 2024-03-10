
<?php

require '../../models/model_desplazamiento.php';

$MA = new Model_Desplazamiento();

$tipoDeBienArray = []; // Inicializamos un array vacío para almacenar los tipos de bien

try {
    $consulta = $MA->listar_tipoBien();

    // Verificar si la consulta devolvió resultados
    if ($consulta) {

      
        // Iteramos sobre los resultados de la consulta y agregamos cada tipo de bien al array
        foreach ($consulta as $tipoBien) {
            // Convertimos el nombre a mayúsculas
            $nombreMayusculas = strtoupper($tipoBien["nombre"]);

            // Creamos un nuevo objeto que representa el tipo de bien
            $tipoDeBien = [
                "id" => $tipoBien["id"],
                "nombre" => $nombreMayusculas
            ];

            // Agregamos el tipo de bien al array global
            $tipoDeBienArray[] = $tipoDeBien;
        }
    } else {
        // Si la consulta no devuelve resultados, muestra un mensaje o realiza alguna acción alternativa
        $tipoDeBienArray[] = ["id" => 0, "nombre" => "No se encontraron tipos de bien"];
    }
} catch (Exception $exc) {
    $tipoDeBienArray[] = ["id" => 0, "nombre" => "Error: " . $exc->getMessage()];
}

// Agregar la opción "Seleccione Una..." al principio del array
array_unshift($tipoDeBienArray, ["id" => 0, "nombre" => "Seleccione Una..."]);

// Salida como JSON
header('Content-Type: application/json');
echo json_encode($tipoDeBienArray);

?>

