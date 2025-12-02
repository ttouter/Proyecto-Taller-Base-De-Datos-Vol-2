<?php
session_start();
require_once '../models/ModeloProcesos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numControl = $_POST['numControl'];
    $nombre     = $_POST['nombre'];
    $apPat      = $_POST['apellidoPat'];
    $apMat      = $_POST['apellidoMat'];
    $edad       = $_POST['edad'];
    $sexo       = $_POST['sexo'];
    $idEquipo   = $_POST['idEquipo'];

    $mensaje = ModeloProcesos::altaParticipante($numControl, $nombre, $apPat, $apMat, $edad, $sexo, $idEquipo);

    echo "<script>
            alert('$mensaje');
            window.location.href = '../views/dashboards/asistenteDashboard.php#registro-participantes';
          </script>";
}
?>