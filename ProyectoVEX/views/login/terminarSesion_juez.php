<?php
session_start();

// 1. Vaciar todas las variables de sesión
$_SESSION = [];

// 2. Invalidar la cookie de sesión si existe (limpieza profunda)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destruir la sesión
session_destroy();

// 4. Redirigir al Index Principal (Landing Page)
header("Location: ../index/Index.html");
exit();
?>