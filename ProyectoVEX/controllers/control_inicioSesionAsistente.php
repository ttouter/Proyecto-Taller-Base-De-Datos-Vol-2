<?php
/*session_start();
require_once '../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = Usuario::validarLogin($email, $password);

    if ($usuario && $usuario['tipo'] === 'entrenador') {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        header("Location: ../views/panel_entrenador.php");
        exit();
    } else {
        header("Location: ../views/inicioSesion_entrenador.php?error=1");
        exit();
    }
}*/

require_once '../config/conexion.php'; // tu archivo de conexión PDO
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $passwordIngresado = $_POST['password'] ?? '';

    

    try {
        // Llamar al procedimiento almacenado
        $stmt = $pdo->prepare("CALL SP_InicioSesion_Asistente(:email)");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $asistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($asistente) {
            $passwordHashBD = $asistente['password'];

            // Verificar la contraseña en PHP
            if (password_verify($passwordIngresado, $passwordHashBD)) {
                // Login correcto → crear sesión
                $_SESSION['asistente_logged_in'] = true;
                $_SESSION['asistente_nombre'] = $asistente['nombre'];
                $_SESSION['asistente_id'] = $asistente['idAsistente'];

                header("Location: ../views/dashboards/asistenteDashboard.php");
                exit();
            } else {
                // Contraseña incorrecta
                header("Location: ../views/login/inicioSesion_entrenador.php?error=Contraseña inválida");
                exit();
            }
        } else {
            // Correo no encontrado
            header("Location: ../views/login/inicioSesion_entrenador.php?error=Correo no registrado");
            exit();
        }
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
}
?>
