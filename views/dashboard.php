<?php
// views/dashboard.php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$es_invitado = ($_SESSION['rol'] === 'invitado');
$es_admin = ($_SESSION['rol'] === 'admin');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>FutMas - Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">FutMas</a>
            <div class="d-flex align-items-center">
                <span class="text-light me-3">
                    Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                </span>
                
                <?php if(!$es_invitado): ?>
                    <a href="perfil.php" class="btn btn-sm btn-outline-light me-2">Mi Cuenta</a>
                <?php endif; ?>

                <?php if($es_admin): ?>
                    <a href="admin_usuarios.php" class="btn btn-sm btn-warning me-2">Panel Admin</a>
                <?php endif; ?>

                <?php if($es_invitado): ?>
                    <a href="login.php" class="btn btn-sm btn-light text-primary fw-bold">Registrarse / Login</a>
                <?php else: ?>
                    <a href="../controllers/LogoutController.php" class="btn btn-sm btn-danger">Salir</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container mt-4">
        <div class="row">
            <!-- Columna de Partidos -->
            <div class="col-md-8">
                
                <h5 class="text-danger fw-bold mb-3">🔴 En Juego (Top 5 Ligas)</h5>
                
                <!-- Partido en Vivo: Manchester City vs Arsenal -->
                <div class="card mb-4 border-0 shadow-sm border-start border-danger border-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                        <h6 class="text-primary fw-bold"><img src="https://media.api-sports.io/football/leagues/39.png" width="20" class="me-2">Premier League (Inglaterra)</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-end" style="width: 35%;">
                                <span>Manchester City</span> <img src="https://media.api-sports.io/football/teams/50.png" width="25" class="ms-2">
                            </div>
                            <div class="text-center" style="width: 30%;">
                                <span class="badge bg-danger">65'</span><br>
                                <h4 class="mb-0 mt-1 fw-bold">1 - 1</h4>
                            </div>
                            <div class="text-start" style="width: 35%;">
                                <img src="https://media.api-sports.io/football/teams/42.png" width="25" class="me-2"> <span>Arsenal</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="text-secondary fw-bold mb-3 mt-4">📅 Próximos Partidos</h5>

                <!-- Próximo Partido: Real Madrid vs Barcelona -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                        <h6 class="text-primary fw-bold"><img src="https://media.api-sports.io/football/leagues/140.png" width="20" class="me-2">La Liga (España)</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-end" style="width: 35%;">
                                <span>Real Madrid</span> <img src="https://media.api-sports.io/football/teams/541.png" width="25" class="ms-2">
                            </div>
                            <div class="text-center" style="width: 30%;">
                                <span class="badge bg-secondary">Hoy - 15:00</span><br>
                                <h5 class="mb-0 mt-1 text-muted">vs</h5>
                            </div>
                            <div class="text-start" style="width: 35%;">
                                <img src="https://media.api-sports.io/football/teams/529.png" width="25" class="me-2"> <span>Barcelona</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Próximo Partido: Juventus vs AC Milan -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                        <h6 class="text-primary fw-bold"><img src="https://media.api-sports.io/football/leagues/135.png" width="20" class="me-2">Serie A (Italia)</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-end" style="width: 35%;">
                                <span>Juventus</span> <img src="https://media.api-sports.io/football/teams/496.png" width="25" class="ms-2">
                            </div>
                            <div class="text-center" style="width: 30%;">
                                <span class="badge bg-secondary">Mañana - 13:45</span><br>
                                <h5 class="mb-0 mt-1 text-muted">vs</h5>
                            </div>
                            <div class="text-start" style="width: 35%;">
                                <img src="https://media.api-sports.io/football/teams/489.png" width="25" class="me-2"> <span>AC Milan</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Columna del Chat IA -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white fw-bold">FutMas IA - Analista</div>
                    <div class="card-body d-flex flex-column justify-content-center" style="background: #f8f9fa;">
                        <?php if($es_invitado): ?>
                            <div class="alert alert-warning text-center">
                                Debes <a href="login.php" class="alert-link">iniciar sesión</a> para usar la Inteligencia Artificial.
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center">Área de chat reservada para la integración con Google Gemini en la próxima etapa.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>