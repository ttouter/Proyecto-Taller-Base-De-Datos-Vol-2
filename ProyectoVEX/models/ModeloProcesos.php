<?php
require_once __DIR__ . '/../config/conexion.php';
class ModeloProcesos {

    // 1. COMPLETAR PERFIL ENTRENADOR
    public static function altaDetallesEntrenador($idAsistente, $codEscuela) {
        global $pdo;
        try {
            $sql = "CALL AltaDetallesEntrenador(:id, :escuela, @mensaje)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $idAsistente, ':escuela' => $codEscuela]);
            
            $res = $pdo->query("SELECT @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);
            return $res['mensaje'];
        } catch (PDOException $e) {
            return "Error BD: " . $e->getMessage();
        }
    }

    // 2. REGISTRAR EQUIPO
    public static function altaEquipo($nombre, $idCategoria, $codEscuela, $evento, $idAsistente) {
        global $pdo;
        try {
            $sql = "CALL AltaEquipo(:nombre, :cat, :escuela, :evento, :asistente, @mensaje, @idOut)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':cat' => $idCategoria,
                ':escuela' => $codEscuela,
                ':evento' => $evento,
                ':asistente' => $idAsistente
            ]);
            
            $res = $pdo->query("SELECT @mensaje AS mensaje, @idOut AS id")->fetch(PDO::FETCH_ASSOC);
            return $res; 
        } catch (PDOException $e) {
            return ['mensaje' => "Error BD: " . $e->getMessage()];
        }
    }

    // 3. REGISTRAR PARTICIPANTE
    public static function altaParticipante($numControl, $nombre, $apPat, $apMat, $edad, $sexo, $idEquipo) {
        global $pdo;
        try {
            $sql = "CALL AltaParticipante(:num, :nom, :pat, :mat, :edad, :sexo, :equipo, @mensaje)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':num' => $numControl,
                ':nom' => $nombre,
                ':pat' => $apPat,
                ':mat' => $apMat,
                ':edad' => $edad,
                ':sexo' => $sexo,
                ':equipo' => $idEquipo
            ]);
            
            $res = $pdo->query("SELECT @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);
            return $res['mensaje'];
        } catch (PDOException $e) {
            return "Error BD: " . $e->getMessage();
        }
    }

    // 4. FUNCIONES DE LECTURA (Selects)
    public static function listarEscuelas() {
        global $pdo;
        try {
            $stmt = $pdo->prepare("CALL ListarEscuelas()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) { return []; }
    }

    public static function listarEventos() {
        global $pdo;
        try {
            $stmt = $pdo->prepare("CALL ListarEventos()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) { return []; }
    }

    // NUEVO: LISTAR EQUIPOS DEL ENTRENADOR
    public static function listarEquiposPorEntrenador($idAsistente) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("CALL ObtenerEquiposPorEntrenador(:id)");
            $stmt->execute([':id' => $idAsistente]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) { return []; }
    }
}
?>