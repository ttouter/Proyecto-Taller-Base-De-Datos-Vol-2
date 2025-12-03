<?php
session_start();

// 1. Vaciar todas las variables de sesión
$_SESSION = [];

// 2. Destruir la sesión completamente
session_destroy();

// 3. CAMBIO: Redirigir al Index principal en lugar del login
header("Location: ../index/Index.html");
exit();
?>