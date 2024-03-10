<?php 
    require_once 'conexionbd.php';

    class Model_Scanners extends conexionBD
    {
        public function listar_scanners() {
            $con = conexionBD::conexion();
            $sql = "SELECT scan.*, a.nombre AS nombre_area FROM scanners scan
                    LEFT JOIN areas a ON scan.area_id = a.id";
                   
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
               
                echo "Error al listar scanners: " . $e->getMessage();
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
        
        public function registrar_scanner(
            $cod_patrimonial,
            $marca,
            $modelo,
            $serie,
            $sistema_operativo,
            $velocidad,
            $resolucion,
            $area,
            $estado) {
            
            $con = conexionBD::conexion();
        
            $sql = "INSERT INTO scanners (cod_patrimonial, marca, modelo, serie,
                                        sistema_operativo,velocidad,resolucion,area_id,estado) 
                                        VALUES (?,?,?,?, ?,?,?,?,?)";
        
            try {
                $query = $con->prepare($sql);
    
                $query->bindParam(1, $cod_patrimonial);
                $query->bindParam(2, $marca);
                $query->bindParam(3, $modelo);
                $query->bindParam(4, $serie);
                $query->bindParam(5, $sistema_operativo);
                $query->bindParam(6, $velocidad);
                $query->bindParam(7, $resolucion);
                $query->bindParam(8, $area);
                $query->bindParam(9, $estado);
    
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

        public function modificar_scanner($cod, $marca, $modelo, $serie, $sis_ope, $velocidad, $resolucion, $area, $estado) {
            $con = conexionBD::conexion();
        
            try {
                $sql = "UPDATE scanners SET marca = ?, modelo = ?, serie = ?, sistema_operativo = ?, velocidad = ?, resolucion = ?,
                            area_id = ?, estado = ? WHERE cod_patrimonial = ?";
        
                    $query = $con->prepare($sql);
                    $query->bindParam(1, $marca);
                    $query->bindParam(2, $modelo);
                    $query->bindParam(3, $serie);
                    $query->bindParam(4, $sis_ope);
                    $query->bindParam(5, $velocidad);
                    $query->bindParam(6, $resolucion);
                    $query->bindParam(7, $area);
                    $query->bindParam(8, $estado);
                    $query->bindParam(9, $cod, PDO::PARAM_STR);  
        
                    $query->execute();
        
                    $filas_afectadas = $query->rowCount();
        
                    if ($filas_afectadas > 0) {
                        
                        $response = array("status" => "success", "message" => "Datos actualizados correctamente");
                    } else {
                    
                        $response = array("status" => "error", "message" => "No se pudo actualizar los datos");
                    }
            
                } 
            catch (PDOException $e) {
               
                $response = array("status" => "error", "message" => "Error en la base de datos al actualizar");
                echo $e->getMessage();
            } finally {
                conexionBD::cerrar_conexion();
            }
            
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        public function eliminar_scanner($cod_patrimonial) {
            $con = conexionBD::conexion();
        
            try {
                
                $sql = "DELETE FROM scanners WHERE cod_patrimonial = ?";
                $query = $con->prepare($sql);
                $query->bindParam(1, $cod_patrimonial, PDO::PARAM_STR); // Asegúrate de usar PDO::PARAM_STR para valores VARCHAR

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