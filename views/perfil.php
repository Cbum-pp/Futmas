<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['rol'] === 'invitado') {
    header("Location: login.php");
    exit();
}
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

$db = (new Database())->getConnection();
$usuarioModel = new Usuario($db);
$datos_usuario = $usuarioModel->getById($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>FutMas - Mi Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">⬅ Volver al Dashboard</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <?php if(isset($_GET['msg'])) echo '<div class="alert alert-success">'.htmlspecialchars($_GET['msg']).'</div>'; ?>
                <?php if(isset($_GET['error'])) echo '<div class="alert alert-danger">'.htmlspecialchars($_GET['error']).'</div>'; ?>

                <!-- Formulario: Editar Datos -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">Actualizar Datos Personales</div>
                    <div class="card-body">
                        <form action="../controllers/PerfilController.php" method="POST">
                            <input type="hidden" name="action" value="update_data">
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($datos_usuario['nombre']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($datos_usuario['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Teléfono (Opcional)</label>
                                <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($datos_usuario['telefono'] ?? ''); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>

                <!-- Formulario: Cambiar Contraseña -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">Cambiar Contraseña</div>
                    <div class="card-body">
                        <form action="../controllers/PerfilController.php" method="POST">
                            <input type="hidden" name="action" value="update_password">
                            <div class="mb-3">
                                <label>Contraseña Actual</label>
                                <input type="password" name="password_actual" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Nueva Contraseña</label>
                                <input type="password" name="nueva_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning">Actualizar Contraseña</button>
                        </form>
                    </div>
                </div>

                <!-- Botón: Eliminar Cuenta -->
                <div class="card shadow-sm border-danger mb-5">
                    <div class="card-header bg-danger text-white fw-bold">Zona de Peligro</div>
                    <div class="card-body text-center">
                        <p class="text-muted">Una vez eliminada, no podrás recuperar tu cuenta ni tu historial de IA.</p>
                        <form action="../controllers/PerfilController.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta permanentemente?');">
                            <input type="hidden" name="action" value="delete_account">
                            <button type="submit" class="btn btn-outline-danger">Eliminar mi Cuenta</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>