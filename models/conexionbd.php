<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$usuario = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
class conexionBD {
    // Acceso personal para el sistema en prduccion
    private $host;
    private $dbName;
    private $usuario;
    private $password;
    private $pdo;

    function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->usuario = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
    }
      
    function conexion() {
        try {
            $this->pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->dbName", $this->usuario, $this->password
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