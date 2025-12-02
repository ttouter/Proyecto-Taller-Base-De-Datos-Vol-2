<?php

class ModeloEvaluacion {

    // NUEVO: OBTENER EQUIPOS ASIGNADOS AL JUEZ
    public static function obtenerEquiposAsignados($idJuez) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("CALL ObtenerEquiposPorJuez(:id)");
            $stmt->execute([':id' => $idJuez]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public static function guardarEvaluacionCompleta($datos) {
        global $pdo;
        try {
            $pdo->beginTransaction(); 

            // 1. Diseño
            $stmt1 = $pdo->prepare("CALL AltaEvaluacionDiseno(:juez, :equipo, :v1, :v2, :v3, :v4, :v5, @msg1)");
            $stmt1->execute([
                ':juez' => $datos['idJuez'],
                ':equipo' => $datos['idEquipo'],
                ':v1' => $datos['registroDeFechas'],
                ':v2' => $datos['justificacionDeCambios'],
                ':v3' => $datos['diagramasEImagenes'],
                ':v4' => $datos['videoYAnimacion'],
                ':v5' => $datos['disenoYModelado']
            ]);
            
            // 2. Programación
            $stmt2 = $pdo->prepare("CALL AltaEvaluacionProgramacion(:juez, :equipo, :v1, :v2, :v3, :v4, :v5, @msg2)");
            $stmt2->execute([
                ':juez' => $datos['idJuez'],
                ':equipo' => $datos['idEquipo'],
                ':v1' => $datos['usoFunciones'],
                ':v2' => $datos['complejidad'],
                ':v3' => $datos['codigoModular'],
                ':v4' => $datos['sistemaAutonomo'],
                ':v5' => $datos['controlDriver']
            ]);

            // 3. Construcción
            $stmt3 = $pdo->prepare("CALL AltaEvaluacionConstruccion(:juez, :equipo, :v1, :v2, :v3, :v4, :v5, @msg3)");
            $stmt3->execute([
                ':juez' => $datos['idJuez'],
                ':equipo' => $datos['idEquipo'],
                ':v1' => $datos['estetica'],
                ':v2' => $datos['estabilidad'],
                ':v3' => $datos['cableado'],
                ':v4' => $datos['sensores'],
                ':v5' => $datos['engranes']
            ]);

            $pdo->commit();
            return "Evaluación guardada correctamente.";

        } catch (PDOException $e) {
            $pdo->rollBack();
            return "Error al guardar: " . $e->getMessage();
        }
    }
}
?>