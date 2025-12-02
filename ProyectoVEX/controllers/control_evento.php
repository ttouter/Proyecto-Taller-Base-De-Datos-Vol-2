<?php
session_start();
require_once '../models/ModeloAdmin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $lugar  = $_POST['lugar'];
    $fecha  = $_POST['fecha'];

    $mensaje = ModeloAdmin::altaEvento($nombre, $lugar, $fecha);

    // Redirigir con mensaje
    echo "<script>
            alert('$mensaje');
            window.location.href = '../views/dashboards/adminDashboard.php#eventos';
          </script>";
}
?>