<?php
// controllers/RegisterController.php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($usuario->registrar($nombre, $email, $password)) {
        header("Location: ../views/login.php?success=1");
    } else {
        header("Location: ../views/register.php?error=1");
    }
    exit();
}
?>