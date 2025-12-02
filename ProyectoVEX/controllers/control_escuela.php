<?php
session_start();
require_once '../models/ModeloAdmin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codEscuela'];
    $nombre = $_POST['nombreEscuela'];

    $mensaje = ModeloAdmin::altaEscuela($codigo, $nombre);

    echo "<script>
            alert('$mensaje');
            window.location.href = '../views/dashboards/adminDashboard.php#escuelas';
          </script>";
}
?>