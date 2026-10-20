<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();
    $usuarioModel = new Usuario($db);
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $rol = $_POST['rol'];
        $plan = $_POST['plan'];
        
        $usuarioModel->adminCrearUsuario($nombre, $email, $password, $rol, $plan);
        header("Location: ../views/admin_usuarios.php?msg=Usuario creado correctamente");
    } 
    elseif ($action === 'update') {
        $id_usuario = $_POST['id_usuario'];
        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $rol = $_POST['rol'];
        $plan = $_POST['plan'];

        $usuarioModel->adminActualizarUsuario($id_usuario, $nombre, $email, $rol, $plan);
        header("Location: ../views/admin_usuarios.php?msg=Usuario actualizado");
    }
    elseif ($action === 'delete') {
        $id_usuario = $_POST['id_usuario'];
        if($id_usuario != $_SESSION['usuario_id']) { // Evitar que el admin se borre a sí mismo
            $usuarioModel->eliminarCuenta($id_usuario);
            header("Location: ../views/admin_usuarios.php?msg=Usuario eliminado");
        } else {
            header("Location: ../views/admin_usuarios.php?msg=No puedes eliminar tu propia cuenta desde aquí");
        }
    }
}
?>