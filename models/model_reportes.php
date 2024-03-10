<?php
require_once 'conexionbd.php';

class Model_Reportes extends conexionBD
{
    public function getCompusMalas() {
        $conexion = conexionBD::conexion();
        $sql = "SELECT a.nombre AS area,'computadora' AS tipo_bien, c.cod_patrimonial, 
                c.marca, c.modelo, c.serie, c.estado FROM computadoras c
                LEFT JOIN areas a ON c.area_id = a.id
                WHERE c.estado = 'MALO'";
        $resultadoArray = array();
    
        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $fila) {
                $resultadoArray["data"][] = $fila;
            }
            return $resultadoArray;
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error al listar computadoras: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }
    }
    
    public function getImpresorasMalas() {
        $conexion = conexionBD::conexion();
        $sql = "SELECT a.nombre AS area,'impresora' AS tipo_bien, im.cod_patrimonial, 
                im.marca, im.modelo, im.serie, im.estado FROM impresoras im
                LEFT JOIN areas a ON im.area_id = a.id
                WHERE im.estado = 'MALO'";
        $resultadoArray = array();
    
        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $fila) {
                $resultadoArray["data"][] = $fila;
            }
            return $resultadoArray;
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error al listar impresoras: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }
    }
    
    public function getServidoresMalos() {
        $conexion = conexionBD::conexion();
        $sql = "SELECT a.nombre AS area,'servidor' AS tipo_bien, se.cod_patrimonial, 
                se.marca, se.modelo, se.serie, se.estado FROM servidores se
                LEFT JOIN areas a ON se.area_id = a.id
                WHERE se.estado = 'MALO'";
        $resultadoArray = array();
    
        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $fila) {
                $resultadoArray["data"][] = $fila;
            }
            return $resultadoArray;
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error al listar servidores: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }
    }

    public function getSwitchesMalos() {
        $conexion = conexionBD::conexion();
        $sql = "SELECT a.nombre AS area,'switch' AS tipo_bien, sw.cod_patrimonial, 
                sw.marca, sw.modelo, sw.serie, sw.estado FROM switches sw
                LEFT JOIN areas a ON sw.area_id = a.id
                WHERE sw.estado = 'MALO'";
        $resultadoArray = array();
    
        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $fila) {
                $resultadoArray["data"][] = $fila;
            }
            return $resultadoArray;
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error al listar switches: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }
    }

    public function getPerifericosMalos() {
        $conexion = conexionBD::conexion();
        $sql = "SELECT a.nombre AS area,'periferico' AS tipo_bien, pe.cod_patrimonial, 
                pe.marca, pe.modelo, pe.serie, pe.estado FROM perifericos pe
                LEFT JOIN areas a ON pe.area_id = a.id
                WHERE pe.estado = 'MALO'";
        $resultadoArray = array();
    
        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $fila) {
                $resultadoArray["data"][] = $fila;
            }
            return $resultadoArray;
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error al listar perifericos: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }

    }
    public function getScannersMalos() {
        $conexion = conexionBD::conexion();
        $sql = "SELECT a.nombre AS area,'scanner' AS tipo_bien, pe.cod_patrimonial, 
                pe.marca, pe.modelo, pe.serie, pe.estado FROM scanners pe
                LEFT JOIN areas a ON pe.area_id = a.id
                WHERE pe.estado = 'MALO'";
        $resultadoArray = array();
    
        try {
            $query = $conexion->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($resultado as $fila) {
                $resultadoArray["data"][] = $fila;
            }
            return $resultadoArray;
        } catch (PDOException $e) {
            // Lanza una excepción personalizada
            throw new Exception("Error al listar scanners: " . $e->getMessage());
        } finally {
            // Siempre cierra la conexión
            conexionBD::cerrar_conexion();
        }

    }
}
?>