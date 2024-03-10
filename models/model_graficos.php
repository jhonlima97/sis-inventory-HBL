<?php
require_once 'conexionbd.php';

class Model_Graficos extends conexionBD
{
    public function getNumEquipos() {
        $conexion = conexionBD::conexion();
        $sql = "CALL SP_NUM_EQUIPOS";
        $resultadoArray = array();
    
        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $fila) {
                $resultadoArray[] = $fila; // Aquí está la modificación
            }
            return $resultadoArray; // Ahora devuelve directamente el array de equipos
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error en la consulta: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }
    }
    
    public function getGraficoParams($anio) {
        $conexion = conexionBD::conexion();
        $sql = "CALL SP_DESPLAZAMIENTOS('$anio')";
        $resultadoArray = array();
    
        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $fila) {
                $resultadoArray[] = $fila; // Aquí está la modificación
            }
            return $resultadoArray; // Ahora devuelve directamente el array de equipos
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error en la consulta: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }
    }

}
?>