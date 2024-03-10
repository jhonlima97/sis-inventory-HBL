<?php
require_once 'conexionbd.php';

class Model_Areas extends conexionBD
{
    public function listar_areas(){
        try {
            $con = conexionBD::conexion();
            $sql = "SELECT * FROM areas";
            $arreglo = array();
            $query = $con->prepare($sql);
            $query->execute();
    
            /* ASOC PQ SE LLAMA  A LAS COLUMNAS DE LA TABLA */
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $rpta) {
                $arreglo["data"][] = $rpta;
            }
    
            return $arreglo;
        } catch (PDOException $e) {
            // Puedes agregar código adicional aquí para manejar el error
            return false;
        } finally {
            // Cerrar la conexión en el bloque finally
            conexionBD::cerrar_conexion();
        }
    }
    
    public function registrar_area($nombre, $responsable) {
        $con = conexionBD::conexion();
    
        try {
            // Validar si el área ya existe en la BD
            $sql_validar = "SELECT COUNT(*) AS total FROM areas WHERE nombre = ?";
            $query_validar = $con->prepare($sql_validar);
            $query_validar->bindParam(1, $nombre);
            $query_validar->execute();
    
            $resultado = $query_validar->fetch();
    
            if ($resultado['total'] > 0) {
                // Área ya existe, no se puede registrar nuevamente
                $response = array("status" => "exist", "message" => "Área ya existe");
            } else {
                // Área no existe, se puede registrar
                $sql = "INSERT INTO areas (nombre, responsable) VALUES (?, ?)";
                $query = $con->prepare($sql);
                $query->bindParam(1, $nombre);
                $query->bindParam(2, $responsable);
                $query->execute();
    
                $response = array("status" => "success", "message" => "Área registrada correctamente");
            }
    
            // Retornar la respuesta como JSON
            header('Content-Type: application/json');
            echo json_encode($response);
    
        } catch (PDOException $e) {
            $response = array("status" => "error", "message" => "Error al registrar el área");
            // Retornar la respuesta de error como JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } finally {
            conexionBD::cerrar_conexion();
        }
    } 

    public function modificar_area($responsable, $nombre, $id) {
        $con = conexionBD::conexion();
    
        try {
            // Verificar si los nuevos datos coinciden con algún otro registro existente
            $sql_validar = "SELECT COUNT(*) AS total FROM areas WHERE nombre = ? AND responsable = ? AND id <> ?";
            $query_validar = $con->prepare($sql_validar);
            $query_validar->bindParam(1, $nombre);
            $query_validar->bindParam(2, $responsable);
            $query_validar->bindParam(3, $id);
            $query_validar->execute();
    
            $resultado = $query_validar->fetch();
    
            if ($resultado['total'] > 0) {
                // Si existe un registro con los mismos datos, no se permite la modificación
                $response = array("status" => "exist", "message" => "Ya existe un registro con esos datos");
            } else {
                // Si no hay coincidencias, proceder con la actualización
                $sql = "UPDATE areas SET responsable = ?, nombre = ? WHERE id = ?";
                $query = $con->prepare($sql);
    
                $query->bindParam(1, $responsable);
                $query->bindParam(2, $nombre);
                $query->bindParam(3, $id);
    
                $query->execute();
    
                // Verificar el número de filas afectadas para confirmar la actualización
                $filas_afectadas = $query->rowCount();
    
                if ($filas_afectadas > 0) {
                    // Si se actualizó al menos una fila, se considera que la modificación fue exitosa
                    $response = array("status" => "success", "message" => "Área actualizada correctamente");
                } else {
                    // Si no se actualizó ninguna fila, probablemente el ID no existe o no se realizó ningún cambio
                    $response = array("status" => "error", "message" => "No se pudo actualizar los datos");
                }
            }
        } catch (PDOException $e) {
            // Manejo de errores en caso de excepción
            $response = array("status" => "error", "message" => "Error en la base de datos al actualizar");
        } finally {
            conexionBD::cerrar_conexion();
        }
        // Convierte el array en formato JSON y envíalo como respuesta
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function eliminar_area($id) {
        $con = conexionBD::conexion();
    
        try {
            $sql = "DELETE FROM areas WHERE id = ?";
            $query = $con->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
    
            $filas_afectadas = $query->rowCount();
    
            if ($filas_afectadas > 0) {
                // Si se eliminó al menos una fila, se considera que la eliminación fue exitosa
                return true;
            } else {
                // Si no se eliminó ninguna fila, probablemente el ID no existe o no se realizó ningún cambio
                return false;
            }
        } catch (PDOException $e) {
            // Manejo de errores en caso de excepción
            return false; // Devuelve false en caso de error
        } finally {
            conexionBD::cerrar_conexion();
        }
    }

}

?>