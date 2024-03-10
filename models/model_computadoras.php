<?php
    require_once 'conexionbd.php';

    class Model_Computadoras extends conexionBD
    {
        public function listar_computadoras() {
            $con = conexionBD::conexion();
            $sql = "SELECT c.*, a.nombre AS nombre_area FROM computadoras c
                    LEFT JOIN areas a ON c.area_id = a.id";
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
                // Manejo de errores en la consulta
                echo "Error al listar computadoras: " . $e->getMessage();
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
        
        public function registrar_computadora(
            $cod_patrimonial,
            $marca,
            $modelo,
            $serie,
            $sis_ope,
            $ip,
            $procesador,
            $ram,
            $disco,
            $area,
            $estado) {
            
            $con = conexionBD::conexion();
        
            $sql = "INSERT INTO computadoras (cod_patrimonial, marca, modelo, serie,
                                        sis_ope,ip, procesador, ram,disco,area_id,estado) 
                                        VALUES (?,?,?,?, ?,?,?,?,?,?,?)";
        
            try {
                $query = $con->prepare($sql);

                $query->bindParam(1, $cod_patrimonial);
                $query->bindParam(2, $marca);
                $query->bindParam(3, $modelo);
                $query->bindParam(4, $serie);
                $query->bindParam(5, $sis_ope);
                $query->bindParam(6, $ip);
                $query->bindParam(7, $procesador);
                $query->bindParam(8, $ram);
                $query->bindParam(9, $disco);
                $query->bindParam(10, $area);
                $query->bindParam(11, $estado);

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
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $response['status'] = "Codigo existente"; // Mensaje específico para clave duplicada
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
        
        public function modificar_computadora($codigo, $marca, $modelo, $serie, $so, $ip, $procesador, $ram, $disco, $area, $estado) {
            $con = conexionBD::conexion();
        
            try {
                $sql = "UPDATE computadoras SET marca = ?, modelo = ?, serie = ?, sis_ope = ?, ip = ?, procesador = ?,
                            ram = ?, disco = ?, area_id = ?, estado = ? WHERE cod_patrimonial = ?";
        
                    $query = $con->prepare($sql);
                    $query->bindParam(1, $marca);
                    $query->bindParam(2, $modelo);
                    $query->bindParam(3, $serie);
                    $query->bindParam(4, $so);
                    $query->bindParam(5, $ip);
                    $query->bindParam(6, $procesador);
                    $query->bindParam(7, $ram);
                    $query->bindParam(8, $disco);
                    $query->bindParam(9, $area);
                    $query->bindParam(10, $estado);
                    $query->bindParam(11, $codigo, PDO::PARAM_STR);  // Asignación del código patrimonial para la actualización
        
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

        public function eliminar_computadora($cod_patrimonial) {
            $con = conexionBD::conexion();
        
            try {
                
                $sql = "DELETE FROM computadoras WHERE cod_patrimonial = ?";
                $query = $con->prepare($sql);
                $query->bindParam(1, $cod_patrimonial, PDO::PARAM_STR); // Asegúrate de usar PDO::PARAM_STR para valores VARCHAR

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
