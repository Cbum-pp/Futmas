<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>FutMas - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center mb-4 text-primary fw-bold">FutMas</h3>
                        <?php if(isset($_GET['error'])) echo '<div class="alert alert-danger">Credenciales incorrectas</div>'; ?>
                        <?php if(isset($_GET['success'])) echo '<div class="alert alert-success">Registro exitoso. Inicia sesión.</div>'; ?>
                        
                        <form action="../controllers/AuthController.php" method="POST">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                        
                        <div class="mt-3 text-center d-flex flex-column gap-2">
                            <a href="register.php" class="btn btn-outline-secondary w-100">Registrarse</a>
                            <a href="../controllers/GuestController.php" class="text-decoration-none text-muted mt-2">Entrar sin iniciar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>