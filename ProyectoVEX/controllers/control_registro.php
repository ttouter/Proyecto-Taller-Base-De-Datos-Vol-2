<?php
require_once '../models/usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre'      => $_POST['nombre'],
        'ap_paterno'  => $_POST['ap_paterno'],
        'ap_materno'  => $_POST['ap_materno'],
        'sexo'        => $_POST['sexo'],
        'email'       => $_POST['email'],
        'password'    => $_POST['password']
    ];

    // Ejecutar el procedimiento almacenado
    $mensaje = Usuario::registrar($datos);
    
    // --- ERROR ELIMINADO: Se quitó el var_dump($mensaje); ---

// Redirigir según el resultado
    if ($mensaje === 'Registro de asistente exitoso') {
        session_start();
        
        // --- NUEVO BLOQUE: OBTENER EL ID ---
        // Necesitamos el ID para que el dashboard funcione
        require_once '../config/conexion.php'; 
        $stmt = $pdo->prepare("SELECT idAsistente FROM Asistente WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $datos['email']]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['asistente_logged_in'] = true;
        $_SESSION['asistente_nombre'] = $datos['nombre']; 
        
        // AQUÍ GUARDAMOS EL ID EN LA SESIÓN
        $_SESSION['asistente_id'] = $usuario['idAsistente']; 
        // -----------------------------------
        
        header("Location: ../views/dashboards/asistenteDashboard.php");
        exit();
    } else {
        // En caso de error (ej. correo duplicado) regresa al registro
        header("Location: ../views/register/registro.php?error=" . urlencode($mensaje));
        exit();
    }
}
?>