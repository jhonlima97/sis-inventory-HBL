<?php
require_once 'conexionbd.php';

class Model_Desplazamiento extends conexionBD
{
    public function listar_tipoBien(){
        try {
            $con = conexionBD::conexion();
            $sql = "select id, nombre from tipo_bien Order by nombre ASC";
            $query = $con->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function llenarSelectAreas1()
    {
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
    public function llenarSelectResponsables()
    {
        try {
            $con = conexionBD::conexion();
            $sql = "SELECT id,responsable from areas ORDER by responsable ASC";
            $query = $con->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function llenarSelectResponsables1()
    {
        try {
            $con = conexionBD::conexion();
            $sql = "SELECT id,responsable from areas ORDER by responsable ASC";
            $query = $con->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }


    //Probar Responsables con parametros
    public function llenarSelectResponsablesXArea($area)
    {
        try {
            $con = conexionBD::conexion();
            $sql = "SELECT id,responsable from areas where nombre=$area ORDER by responsable ASC";
            $query = $con->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar_desplazamientos()
    {
        $con = conexionBD::conexion();
        //$sql = "SELECT * FROM desplazamiento ORDER BY id DESC";
        //$sql = "SELECT d.*, ap.nombre AS nom_area_prov, aa.nombre AS nom_area_asig FROM desplazamiento d INNER JOIN areas ap ON d.area_prov = ap.id INNER JOIN areas aa ON d.area_asig = aa.id ORDER BY d.id DESC";
        $sql = "SELECT 
            d.id,
            d.motivo,
            ap.nombre AS nom_area_prov,
            aa.nombre AS nom_area_asig,
            d.responsable_prov,
            d.responsable_asig,
            d.fecha,
            GROUP_CONCAT(dd.cod_patrimonial SEPARATOR ', ') AS codigos_patrimoniales
        FROM desplazamiento d
        INNER JOIN areas ap ON d.area_prov = ap.id
        INNER JOIN areas aa ON d.area_asig = aa.id
        INNER JOIN detalle_desplazamiento dd ON d.id = dd.id_desplazamiento
        GROUP BY d.id, d.motivo, ap.nombre, aa.nombre, d.responsable_prov, d.responsable_asig, d.fecha
        ORDER BY d.id DESC;";

        $arreglo = array();

        try {
            $query = $con->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $rpta) {
                $arreglo["data"][] = $rpta;
            }

            conexionBD::cerrar_conexion();
            return $arreglo;
        } catch (PDOException $e) {

            echo "Error al listar desplazamientos: " . $e->getMessage();
            return null;
        }
    }


    public function listar_Detalle_equipos($cod)
    {
        $con = conexionBD::conexion();
        $sql = "SELECT dd.* FROM detalle_desplazamiento dd INNER JOIN desplazamiento d ON dd.id_desplazamiento = d.id WHERE d.id = $cod";
        $arreglo = array();

        try {
            $query = $con->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $rpta) {
                $arreglo["data"][] = $rpta;
            }
            conexionBD::cerrar_conexion();
            return $arreglo;
        } catch (PDOException $e) {
            echo "Error al listar detalle de desplazamiento: " . $e->getMessage();
            return null;
        }
    }


    public function obtener_ultimo_codigo_periferico()
    {
        $conexion = conexionBD::conexion();
        $sql = "SELECT MAX(id) as ultimo_id FROM desplazamiento";

        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            $nuevoCodigo = ($resultado && isset($resultado["ultimo_id"])) ? $resultado["ultimo_id"] + 1 : 1;

            return $nuevoCodigo;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el nuevo código de periférico: " . $e->getMessage());
        } finally {
            conexionBD::cerrar_conexion();
        }
    }



    public function obtener_nombre_responsable_por_area($nombre_area)
    {
        $conexion = conexionBD::conexion();
        $sql = "SELECT responsable FROM areas WHERE nombre = :nombre_area";

        try {
            $query = $conexion->prepare($sql);
            $query->bindParam(':nombre_area', $nombre_area, PDO::PARAM_STR);  // Asumo que el id es un entero, ajusta según sea necesario
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            // Cambia el índice de "nombre_responsable" a "responsable"
            $nombreResponsable = ($resultado && isset($resultado["responsable"])) ? $resultado["responsable"] : null;

            return $nombreResponsable;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el nombre del responsable del área: " . $e->getMessage());
        } finally {
            conexionBD::cerrar_conexion();
        }
    }



    public function getRegistroPorCodigoPatrimonial($tipo_bien_id, $cod_patrimonial)
    {
        $conexion = conexionBD::conexion();
    
        try {
            
            $sql_tipo_bien = "SELECT nombre FROM tipo_bien WHERE id = :tipo_bien_id";
            $query_tipo_bien = $conexion->prepare($sql_tipo_bien);
            $query_tipo_bien->bindParam(':tipo_bien_id', $tipo_bien_id, PDO::PARAM_INT);
            $query_tipo_bien->execute();
            $row_tipo_bien = $query_tipo_bien->fetch(PDO::FETCH_ASSOC);
    
            if ($row_tipo_bien) {
                $nombre_tabla = $row_tipo_bien['nombre'];

                $sql_registro = "SELECT * FROM $nombre_tabla WHERE cod_patrimonial = :cod_patrimonial";
                $query_registro = $conexion->prepare($sql_registro);
                $query_registro->bindParam(':cod_patrimonial', $cod_patrimonial, PDO::PARAM_STR);
                $query_registro->execute();
                $resultado = $query_registro->fetch(PDO::FETCH_ASSOC);
    
                return $resultado;
            } else {
                // Si no se encuentra el tipo de bien, retorna un mensaje de error o null según sea necesario
                return null; // Por ejemplo, podrías retornar null si no se encuentra el tipo de bien
            }
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error al obtener el registro por código patrimonial: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }
    }
    
    public function registrar_asignacion_despl(
        $motivo,
        $area_prov,
        $resp_prov,
        $area_asig,
        $resp_asig,
        $fecha,
        $detallesEquipos
    ) {
        $con = conexionBD::conexion();
    
        $sqlDesplazamiento = "INSERT INTO desplazamiento (motivo, area_prov, responsable_prov, area_asig, responsable_asig, fecha) 
                                VALUES (?, ?, ?, ?, ?, ?)";
    
        $sqlDetalleDesplazamiento = "INSERT INTO detalle_desplazamiento (id_desplazamiento, cod_patrimonial, tipo_bien, marca, modelo, serie) 
                                        VALUES (?, ?, ?, ?, ?, ?)";
    
        // actualice el area del equipo 
        try {
            $con->beginTransaction();
    
            // Insertar datos en la tabla desplazamiento
            $queryDesplazamiento = $con->prepare($sqlDesplazamiento);
            $queryDesplazamiento->execute([$motivo, $area_prov, $resp_prov, $area_asig, $resp_asig, $fecha]);
    
            // Obtener el ID del desplazamiento recién insertado
            $idDesplazamiento = $con->lastInsertId();
    
            // Insertar detalles de equipos en la tabla detalle_desplazamiento
            $queryDetalleDesplazamiento = $con->prepare($sqlDetalleDesplazamiento);
            foreach ($detallesEquipos as $equipo) {
                $queryDetalleDesplazamiento->execute([$idDesplazamiento, $equipo['cod_patrimonial'], $equipo['tipo_bien'], $equipo['marca'], $equipo['modelo'], $equipo['serie']]);
                
                // Actualizar el área del equipo en la tabla de equipos
                $sqlActualizarArea = "UPDATE " . $equipo['tipo_bien'] . " SET area_id = ? WHERE cod_patrimonial = ?";
                $queryActualizarArea = $con->prepare($sqlActualizarArea);
                $queryActualizarArea->execute([$area_asig, $equipo['cod_patrimonial']]);
            }
    
            $con->commit();
    
            // Preparar el array para enviar como respuesta
            $response = array();
    
            //return "Success"; // Éxito en la inserción
            $response['status'] = "Success"; // Éxito en la inserción
            // Devolver la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (PDOException $e) {
            $con->rollback();
            //return "Error en la base de datos: " . $e->getMessage();
            $response['status'] = "Error en la base de datos: " . $e->getMessage();
    
            // Devolver la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } finally {
            conexionBD::cerrar_conexion();
        }
    }
    


    public function Actualizar_Fecha($id, $fecha)
    {
        $con = conexionBD::conexion();

        try {
            $sql = "UPDATE desplazamiento SET fecha = ? WHERE id = ?";

            $query = $con->prepare($sql);
            $query->bindParam(1, $fecha);
            $query->bindParam(2, $id, PDO::PARAM_INT);  // Asignación del código patrimonial para la actualización

            $query->execute();

            $filas_afectadas = $query->rowCount();

            if ($filas_afectadas > 0) {
                // Si se actualizó al menos una fila, se considera que la modificación fue exitosa
                $response = array("status" => "success", "message" => "Datos actualizados correctamente");
            } else {
                // Si no se actualizó ninguna fila, probablemente el código patrimonial no existe
                $response = array("status" => "error", "message" => "No se pudo actualizar los datos");
            }
        } catch (PDOException $e) {
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
}
