<?php
// models/Usuario.php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $password) {
        $query = "SELECT id_usuario, nombre, email, password, rol, plan FROM " . $this->table_name . " WHERE email = :email AND estado = 'activo' LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }

    public function registrar($nombre, $email, $password) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, password, rol, plan) VALUES (:nombre, :email, :password, 'usuario', 'free')";
        $stmt = $this->conn->prepare($query);
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }
    // --- FUNCIONES PARA EL PERFIL DEL USUARIO ---

    public function getById($id) {
        $query = "SELECT id_usuario, nombre, email, telefono, rol, plan FROM " . $this->table_name . " WHERE id_usuario = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarPerfil($id, $nombre, $email, $telefono) {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, email = :email, telefono = :telefono WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function verificarPassword($id, $password_actual) {
        $query = "SELECT password FROM " . $this->table_name . " WHERE id_usuario = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return password_verify($password_actual, $row['password']);
    }

    public function cambiarPassword($id, $nueva_password) {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($query);
        $password_hash = password_hash($nueva_password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminarCuenta($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // --- FUNCIONES PARA EL CRUD DEL ADMINISTRADOR ---

    public function obtenerTodos() {
        $query = "SELECT id_usuario, nombre, email, telefono, rol, plan, estado FROM " . $this->table_name . " ORDER BY id_usuario DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function adminCrearUsuario($nombre, $email, $password, $rol, $plan) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, password, rol, plan) VALUES (:nombre, :email, :password, :rol, :plan)";
        $stmt = $this->conn->prepare($query);
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':plan', $plan);
        return $stmt->execute();
    }

    public function adminActualizarUsuario($id, $nombre, $email, $rol, $plan) {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, email = :email, rol = :rol, plan = :plan WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':plan', $plan);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>