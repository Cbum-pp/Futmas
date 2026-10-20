<?php
// models/Partido.php
class Partido {
    private $conn;
    private $table_name = "partidos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Consulta para el Dashboard (Lista de partidos)
    public function obtenerPartidosDashboard() {
        $query = "
            SELECT 
                p.id_partido, p.estado, p.goles_local, p.goles_visitante, p.minuto_actual, p.fecha_hora,
                l.nombre AS liga_nombre, l.logo_url AS liga_logo,
                el.nombre AS equipo_local, el.escudo_url AS escudo_local,
                ev.nombre AS equipo_visitante, ev.escudo_url AS escudo_visitante
            FROM " . $this->table_name . " p
            INNER JOIN ligas l ON p.id_liga = l.id_liga
            INNER JOIN equipos el ON p.id_equipo_local = el.id_equipo
            INNER JOIN equipos ev ON p.id_equipo_visitante = ev.id_equipo
            ORDER BY p.fecha_hora ASC
            LIMIT 10
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Consulta para el Detalle del Partido (Al hacer clic)
    public function obtenerDetalleCompleto($id_partido) {
        $query = "
            SELECT 
                p.*, 
                l.nombre AS liga_nombre, 
                el.nombre AS equipo_local, el.escudo_url AS escudo_local,
                ev.nombre AS equipo_visitante, ev.escudo_url AS escudo_visitante
            FROM " . $this->table_name . " p
            INNER JOIN ligas l ON p.id_liga = l.id_liga
            INNER JOIN equipos el ON p.id_equipo_local = el.id_equipo
            INNER JOIN equipos ev ON p.id_equipo_visitante = ev.id_equipo
            WHERE p.id_partido = :id_partido
            LIMIT 1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_partido', $id_partido, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>