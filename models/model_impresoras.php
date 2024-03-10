<?php
require_once 'conexionbd.php';

class Model_Impresoras extends conexionBD
{
    public function listar_impresoras(){
        $con = conexionBD::conexion();
        $sql = "SELECT imp.*, a.nombre AS area FROM impresoras imp LEFT JOIN areas a ON imp.area_id = a.id";
        $arreglo = array();  
        
        try{
            $query = $con->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach($resultado as $rpta){
                $arreglo["data"][] = $rpta;
            }
            conexionBD::cerrar_conexion();
            return $arreglo;
        } catch(PDOException $e) {
            echo "Error al listar impresoras: " . $e->getMessage();
            return null;
        }
    
}

    public function llenarSelectAreas(){
        try {
            $con = conexionBD::conexion();
            $sql = "select id, nombre from areas Order by nombre ASC";
            $query = $con->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function registrar_impresora (
        $cod_patrimonial,
        $marca,
        $modelo,
        $serie,
        $num_toner,
        $estado,
        $area
        )
    {
        $con = conexionBD::conexion();
    
        $sql = "INSERT INTO impresoras (cod_patrimonial, marca, modelo, serie,
                                    num_toner,estado,area_id) 
                                    VALUES (?,?,?,?,?,?,?)";
        try{

            $query = $con->prepare($sql);

            $query->bindParam(1, $cod_patrimonial);
            $query->bindParam(2, $marca);
            $query->bindParam(3, $modelo);
            $query->bindParam(4, $serie);
            $query->bindParam(5, $num_toner);
            $query->bindParam(6, $estado);
            $query->bindParam(7, $area);

            $query->execute();

            // Preparar el array para enviar como respuesta
            $response = array();

            if ($query->rowCount() > 0) {
                $response['status'] = "Success"; // Éxito en la inserción
            } else {
                $response['status'] = "Error";
            }

            // Devolver la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);

        }  catch(PDOException $e){
            if ($e->getCode() == 23000) {
                $response['status'] = "Codigo existente"; 
            } else {
                $response['status'] = "Error en la base de datos: " . $e->getMessage();
            }

            // Devolver la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } finally {
            conexionBD::cerrar_conexion();
        }                         
        
    }

    public function modificar_impresora($codigo, $marca, $modelo, $serie, $num_toner,$estado,$area) {
        $con = conexionBD::conexion();
    
        try {
            $sql = "UPDATE impresoras SET marca = ?, modelo = ?, serie = ?, num_toner = ?, estado = ?, area_id = ? WHERE cod_patrimonial = ?";
    
                $query = $con->prepare($sql);
                $query->bindParam(1, $marca);
                $query->bindParam(2, $modelo);
                $query->bindParam(3, $serie);
                $query->bindParam(4, $num_toner);
                $query->bindParam(5, $estado);
                $query->bindParam(6, $area);
                $query->bindParam(7, $codigo, PDO::PARAM_STR); 
    
                $query->execute();
    
                $filas_afectadas = $query->rowCount();
    
                if ($filas_afectadas > 0) {
                    // Si se actualizó al menos una fila, se considera que la modificación fue exitosa
                    $response = array("status" => "success", "message" => "Datos actualizados correctamente");
                } else {
                    // Si no se actualizó ninguna fila, probablemente el código patrimonial no existe
                    $response = array("status" => "error", "message" => "No se pudo actualizar los datos");
                }
           
            } 
         catch (PDOException $e) {
            // Manejo de errores en caso de excepción
            $response = array("status" => "error", "message" => "Error en la base de datos al actualizar");
            echo $e->getMessage();
        } finally {
            conexionBD::cerrar_conexion();
        }
        // Convierte el array en formato JSON y envíalo como respuesta
        header('Content-Type: application/json');
        echo json_encode($response);
    }  

    public function eliminar_impresora($cod_patrimonial) {
        $con = conexionBD::conexion();
    
        try {
            
            $sql = "DELETE FROM impresoras WHERE cod_patrimonial = ?";
            $query = $con->prepare($sql);
            $query->bindParam(1, $cod_patrimonial, PDO::PARAM_STR); 
            $query->execute();
    
            $filas_afectadas = $query->rowCount();
    
            if ($filas_afectadas > 0) {
            
                return true;
            } else {
               
                return false;
            }
        } catch (PDOException $e) {
            
            return false; 
        } finally {
            conexionBD::cerrar_conexion();
        }
    }

}

?>