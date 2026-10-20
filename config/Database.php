<?php
// config/Database.php
class Database {
    private $host = "localhost";
    private $db_name = "app_365scores_ia";
    private $username = "root"; // Cambia si usas otro usuario
    private $password = "";     // Cambia si tienes contraseña en XAMPP/MAMP
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>