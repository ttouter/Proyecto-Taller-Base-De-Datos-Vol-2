<?php
session_start();
// Solo permitir a organizadores ver esto
if (!isset($_SESSION['rol_activo']) || $_SESSION['rol_activo'] !== 'organizador') {
    die("Acceso denegado");
}

require_once '../models/ModeloReportes.php';

$ranking = ModeloReportes::obtenerRanking();

// Devolver JSON para usarlo con JavaScript o simplemente incluirlo en la vista
header('Content-Type: application/json');
echo json_encode($ranking);
?>