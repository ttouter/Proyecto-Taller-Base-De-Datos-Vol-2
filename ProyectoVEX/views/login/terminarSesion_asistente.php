<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Redirigir al login de asistente
header("Location: ../login/inicioSesion_entrenador.php");
exit();
?>
