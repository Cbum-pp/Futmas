<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>FutMas - Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center mb-4 text-primary fw-bold">Unirse a FutMas</h3>
                        <?php if(isset($_GET['error'])) echo '<div class="alert alert-danger">Error: El email ya está en uso.</div>'; ?>
                        <form action="../controllers/RegisterController.php" method="POST">
                            <div class="mb-3">
                                <label>Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registrarme</button>
                            <div class="mt-3 text-center">
                                <a href="login.php" class="text-decoration-none">Ya tengo cuenta. Volver al Login.</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>