<?php
require_once __DIR__ . '/../config/conexion.php';

class ModeloReportes {
    public static function obtenerRanking() {
        global $pdo;
        try {
            $stmt = $pdo->prepare("CALL GenerarReportePuntajes()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>