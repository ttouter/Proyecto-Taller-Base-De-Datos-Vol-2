<?php
require_once __DIR__ . '/../config/conexion.php';

class ModeloAdmin {

    // ... (Funciones existentes: obtenerResumen, listarEquipos, listarUsuarios, altaEvento, altaEscuela) ...

    public static function obtenerResumen() {
        global $pdo;
        try {
            $stmt = $pdo->prepare("CALL ObtenerResumenAdmin()");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['total_equipos' => 0, 'eventos_activos' => 0, 'total_jueces' => 0, 'total_participantes' => 0];
        }
    }

    public static function listarEquipos() {
        global $pdo;
        try {
            $stmt = $pdo->prepare("CALL ListarEquiposAdmin()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) { return []; }
    }

    public static function listarUsuarios() {
        global $pdo;
        try {
            $stmt = $pdo->prepare("CALL ListarUsuariosAdmin()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) { return []; }
    }

    public static function altaEvento($nombre, $lugar, $fecha) {
        global $pdo;
        try {
            $sql = "CALL AltaEvento(:nom, :lug, :fec, @mensaje)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nom' => $nombre, ':lug' => $lugar, ':fec' => $fecha]);
            $res = $pdo->query("SELECT @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);
            return $res['mensaje'];
        } catch (PDOException $e) { return "Error BD: " . $e->getMessage(); }
    }

    public static function altaEscuela($codigo, $nombre) {
        global $pdo;
        try {
            $sql = "CALL AltaEscuela(:cod, :nom, @mensaje)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':cod' => $codigo, ':nom' => $nombre]);
            $res = $pdo->query("SELECT @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);
            return $res['mensaje'];
        } catch (PDOException $e) { return "Error BD: " . $e->getMessage(); }
    }

    // --- NUEVAS FUNCIONES PARA ASIGNAR ROLES ---

    public static function asignarRolEntrenador($idAsistente, $codEscuela) {
        global $pdo;
        try {
            $sql = "CALL AsignarRolEntrenadorAdmin(:id, :escuela, @mensaje)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $idAsistente, ':escuela' => $codEscuela]);
            $res = $pdo->query("SELECT @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);
            return $res['mensaje'];
        } catch (PDOException $e) { return "Error BD: " . $e->getMessage(); }
    }

    public static function asignarRolJuez($idAsistente, $codEscuela, $grado) {
        global $pdo;
        try {
            $sql = "CALL AsignarRolJuezAdmin(:id, :escuela, :grado, @mensaje)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $idAsistente, ':escuela' => $codEscuela, ':grado' => $grado]);
            $res = $pdo->query("SELECT @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);
            return $res['mensaje'];
        } catch (PDOException $e) { return "Error BD: " . $e->getMessage(); }
    }
}
?>