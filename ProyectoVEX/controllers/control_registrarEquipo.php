<?php
session_start();
require_once '../models/ModeloProcesos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del POST
    $nombreEquipo = $_POST['nombreEquipo'];
    $idCategoria  = $_POST['idCategoria'];
    $evento       = $_POST['evento']; // Ojo: en tu HTML es un input text, debería ser coincidente con DB
    $codEscuela   = $_POST['codEscuela'];
    $idAsistente  = $_POST['idAsistente'];

    // Llamar al modelo
    $resultado = ModeloProcesos::altaEquipo($nombreEquipo, $idCategoria, $codEscuela, $evento, $idAsistente);
    
    $msg = $resultado['mensaje'];

    echo "<script>
            alert('$msg');
            window.location.href = '../views/dashboards/asistenteDashboard.php#registro-equipo';
          </script>";
}
?>