<?php
// controllers/AuthController.php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $login_result = $usuario->login($email, $password);

    if ($login_result) {
        $_SESSION['usuario_id'] = $login_result['id_usuario'];
        $_SESSION['nombre'] = $login_result['nombre'];
        $_SESSION['rol'] = $login_result['rol'];
        $_SESSION['plan'] = $login_result['plan'];
        
        header("Location: ../views/dashboard.php");
        exit();
    } else {
        header("Location: ../views/login.php?error=1");
        exit();
    }
}
?>