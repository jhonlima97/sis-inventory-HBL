<?php

class conexionBD {
    private $host     = 'tu-host';
    private $dbName   = 'tu-dbname';
    private $user     = 'tu-user';
    private $password = 'tu-pass'; // Aquí va tu contraseña de MySQL
    private $pdo;
      
    function conexion() {
        try {
            $this->pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES 'UTF8'");
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Falló la conexión: " . $e->getMessage();
            // Deberías manejar el error de una forma más adecuada en producción
            // En lugar de mostrar el mensaje de error directamente
            return null;
        }     
    }

    public function cerrar_conexion(){
        $this->pdo = null;
    }
}

?>



