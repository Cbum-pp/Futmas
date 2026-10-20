<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();
    $usuarioModel = new Usuario($db);
    $id_usuario = $_SESSION['usuario_id'];
    $action = $_POST['action'] ?? '';

    if ($action === 'update_data') {
        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $telefono = trim($_POST['telefono']);
        
        if($usuarioModel->actualizarPerfil($id_usuario, $nombre, $email, $telefono)){
            $_SESSION['nombre'] = $nombre; // Actualizar sesión
            header("Location: ../views/perfil.php?msg=Datos actualizados correctamente");
        } else {
            header("Location: ../views/perfil.php?error=Error al actualizar datos (el email podría estar en uso)");
        }
    } 
    elseif ($action === 'update_password') {
        $password_actual = $_POST['password_actual'];
        $nueva_password = $_POST['nueva_password'];

        if($usuarioModel->verificarPassword($id_usuario, $password_actual)){
            $usuarioModel->cambiarPassword($id_usuario, $nueva_password);
            header("Location: ../views/perfil.php?msg=Contraseña cambiada exitosamente");
        } else {
            header("Location: ../views/perfil.php?error=La contraseña actual es incorrecta");
        }
    }
    elseif ($action === 'delete_account') {
        $usuarioModel->eliminarCuenta($id_usuario);
        session_unset();
        session_destroy();
        header("Location: ../views/login.php?error=Tu cuenta ha sido eliminada permanentemente");
    }
}
?>