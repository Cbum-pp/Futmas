<?php
// views/partido_detalle.php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Partido.php';

if(!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$db = (new Database())->getConnection();
$partidoModel = new Partido($db);
$detalle = $partidoModel->obtenerDetalleCompleto($_GET['id']);

if(!$detalle) {
    die("Partido no encontrado.");
}

// Simulamos decodificar el JSON de la API que estará guardado en la columna 'estadisticas_json'
$stats = json_decode($detalle['estadisticas_json'], true) ?? [
    'posesion_local' => '55%', 'posesion_visitante' => '45%',
    'lesionados_local' => ['Jugador A (Rodilla)', 'Jugador B (Muscular)'],
    'lesionados_visitante' => ['Jugador C (Tobillo)'],
    'h2h_ultimos_5' => 'Local: 2 | Empates: 1 | Visitante: 2'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>FutMas - Detalle del Partido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">⬅ Volver</a>
        </div>
    </nav>

    <div class="container">
        <!-- Marcador Central -->
        <div class="card shadow-sm border-0 mb-4 bg-dark text-white text-center py-4">
            <h5 class="text-warning"><?php echo htmlspecialchars($detalle['liga_nombre']); ?></h5>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <div class="text-end me-4">
                    <h3><?php echo htmlspecialchars($detalle['equipo_local']); ?></h3>
                </div>
                <div class="px-4">
                    <h1 class="display-4 fw-bold mb-0"><?php echo $detalle['goles_local']; ?> - <?php echo $detalle['goles_visitante']; ?></h1>
                    <span class="badge <?php echo $detalle['estado'] == 'En Juego' ? 'bg-danger' : 'bg-secondary'; ?> mt-2">
                        <?php echo $detalle['estado'] == 'En Juego' ? $detalle['minuto_actual']."'" : $detalle['estado']; ?>
                    </span>
                </div>
                <div class="text-start ms-4">
                    <h3><?php echo htmlspecialchars($detalle['equipo_visitante']); ?></h3>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Columna Alineaciones y Bajas -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">🏥 Reporte de Lesionados y Bajas</div>
                    <div class="card-body row text-center">
                        <div class="col-6 border-end">
                            <h6 class="text-primary"><?php echo htmlspecialchars($detalle['equipo_local']); ?></h6>
                            <ul class="list-unstyled text-muted small">
                                <?php foreach($stats['lesionados_local'] as $l) echo "<li>❌ $l</li>"; ?>
                            </ul>
                        </div>
                        <div class="col-6">
                            <h6 class="text-primary"><?php echo htmlspecialchars($detalle['equipo_visitante']); ?></h6>
                            <ul class="list-unstyled text-muted small">
                                <?php foreach($stats['lesionados_visitante'] as $l) echo "<li>❌ $l</li>"; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Historial H2H -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-bold">📊 Historial (Últimos 5 partidos)</div>
                    <div class="card-body text-center">
                        <p class="mb-0 fw-bold"><?php echo htmlspecialchars($stats['h2h_ultimos_5']); ?></p>
                        <hr>
                        <p class="small text-muted mb-0">Posesión de Balón</p>
                        <div class="progress mt-2" style="height: 25px;">
                            <div class="progress-bar bg-primary" style="width: <?php echo $stats['posesion_local']; ?>"><?php echo $stats['posesion_local']; ?></div>
                            <div class="progress-bar bg-danger" style="width: <?php echo $stats['posesion_visitante']; ?>"><?php echo $stats['posesion_visitante']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>