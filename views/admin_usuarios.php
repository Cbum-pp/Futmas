<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado. Solo administradores.");
}
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

$db = (new Database())->getConnection();
$usuarioModel = new Usuario($db);
$usuarios = $usuarioModel->obtenerTodos();

// Si se envía un ID por GET, es modo edición
$usuario_editar = null;
if(isset($_GET['edit_id'])) {
    $usuario_editar = $usuarioModel->getById($_GET['edit_id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - FutMas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="dashboard.php">⬅ Volver al Dashboard (Admin)</a>
        </div>
    </nav>

    <div class="container">
        <h3 class="mb-4">Gestión de Usuarios (CRUD)</h3>
        <?php if(isset($_GET['msg'])) echo '<div class="alert alert-success">'.htmlspecialchars($_GET['msg']).'</div>'; ?>
        
        <div class="row">
            <!-- Formulario Crear / Editar -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header <?php echo $usuario_editar ? 'bg-warning' : 'bg-primary text-white'; ?> fw-bold">
                        <?php echo $usuario_editar ? 'Editar Usuario ID: '.$usuario_editar['id_usuario'] : 'Agregar Nuevo Usuario'; ?>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/AdminController.php" method="POST">
                            <input type="hidden" name="action" value="<?php echo $usuario_editar ? 'update' : 'create'; ?>">
                            <?php if($usuario_editar): ?>
                                <input type="hidden" name="id_usuario" value="<?php echo $usuario_editar['id_usuario']; ?>">
                            <?php endif; ?>

                            <div class="mb-2">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo $usuario_editar['nombre'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-2">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $usuario_editar['email'] ?? ''; ?>" required>
                            </div>
                            <?php if(!$usuario_editar): ?>
                            <div class="mb-2">
                                <label>Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <?php endif; ?>
                            <div class="mb-2">
                                <label>Rol</label>
                                <select name="rol" class="form-select">
                                    <option value="usuario" <?php echo (isset($usuario_editar) && $usuario_editar['rol']=='usuario') ? 'selected' : ''; ?>>Usuario</option>
                                    <option value="admin" <?php echo (isset($usuario_editar) && $usuario_editar['rol']=='admin') ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Plan</label>
                                <select name="plan" class="form-select">
                                    <option value="free" <?php echo (isset($usuario_editar) && $usuario_editar['plan']=='free') ? 'selected' : ''; ?>>Free</option>
                                    <option value="premium" <?php echo (isset($usuario_editar) && $usuario_editar['plan']=='premium') ? 'selected' : ''; ?>>Premium</option>
                                </select>
                            </div>
                            <button type="submit" class="btn <?php echo $usuario_editar ? 'btn-warning' : 'btn-primary'; ?> w-100">
                                <?php echo $usuario_editar ? 'Guardar Cambios' : 'Crear Usuario'; ?>
                            </button>
                            <?php if($usuario_editar): ?>
                                <a href="admin_usuarios.php" class="btn btn-outline-secondary w-100 mt-2">Cancelar Edición</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Plan</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($usuarios as $u): ?>
                                <tr>
                                    <td><?php echo $u['id_usuario']; ?></td>
                                    <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                                    <td><span class="badge bg-<?php echo $u['rol']=='admin' ? 'danger' : 'secondary'; ?>"><?php echo strtoupper($u['rol']); ?></span></td>
                                    <td><span class="badge bg-<?php echo $u['plan']=='premium' ? 'warning text-dark' : 'light text-dark'; ?>"><?php echo strtoupper($u['plan']); ?></span></td>
                                    <td>
                                        <a href="admin_usuarios.php?edit_id=<?php echo $u['id_usuario']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="../controllers/AdminController.php" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar usuario?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id_usuario" value="<?php echo $u['id_usuario']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>