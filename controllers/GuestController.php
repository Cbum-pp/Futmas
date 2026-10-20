<?php
// controllers/GuestController.php
session_start();
$_SESSION['usuario_id'] = 0; 
$_SESSION['nombre'] = 'Invitado';
$_SESSION['rol'] = 'invitado';
$_SESSION['plan'] = 'free';

header("Location: ../views/dashboard.php");
exit();
?>