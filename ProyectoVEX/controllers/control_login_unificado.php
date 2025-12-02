<?php
session_start();
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Recibir y limpiar datos
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'entrenador'; // Rol seleccionado en el formulario

    try {
        // 2. Verificar credenciales generales (Tabla Asistente)
        // Usamos el SP que ya tienes: SP_InicioSesion_Asistente
        $stmt = $pdo->prepare("CALL SP_InicioSesion_Asistente(:email)");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); // Liberar para siguientes consultas

        // Si el usuario no existe o contraseña incorrecta
        if (!$usuario || !password_verify($password, $usuario['password'])) {
            $_SESSION['error_login'] = "Credenciales incorrectas. Verifica tu correo y contraseña.";
            header("Location: ../views/login/login_unificado.php");
            exit();
        }

        // 3. Verificación de ROL ESPECÍFICO
        // Aunque el login sea correcto, debemos validar si tiene permiso para el rol seleccionado
        $idAsistente = $usuario['idAsistente'];
        $accesoPermitido = false;
        $urlRedireccion = "";

        switch ($rol) {
            case 'entrenador':
                // Verificar en tabla Entrenador usando su FK hacia Asistente
                $check = $pdo->prepare("SELECT 1 FROM Entrenador WHERE idAsistente_Asistente = ?");
                $check->execute([$idAsistente]);
                if ($check->fetch()) {
                    $accesoPermitido = true;
                    $urlRedireccion = "../views/dashboards/asistenteDashboard.php";
                    $_SESSION['asistente_logged_in'] = true; // Mantener compatibilidad
                } else {
                    $_SESSION['error_login'] = "No tienes permisos de Entrenador registrados.";
                }
                break;

            case 'juez':
                // Verificar en tabla Juez usando su FK hacia Asistente
                $check = $pdo->prepare("SELECT 1 FROM Juez WHERE idAsistente_Asistente = ?");
                $check->execute([$idAsistente]);
                if ($check->fetch()) {
                    $accesoPermitido = true;
                    $urlRedireccion = "../views/dashboards/juezDashboard.php";
                    $_SESSION['juez_logged_in'] = true;
                    $_SESSION['juez_nombre'] = $usuario['nombre'];
                    $_SESSION['juez_id'] = $idAsistente;
                } else {
                    $_SESSION['error_login'] = "No tienes perfil de Juez activo.";
                }
                break;

            case 'organizador':
                // Validar organizador (puedes ajustar esta lógica según tus necesidades reales)
                // Ejemplo simple: Solo correos específicos
                if (strpos($email, 'admin') !== false || $email === 'admin@vex.com') {
                    $accesoPermitido = true;
                    $urlRedireccion = "../views/dashboards/adminDashboard.php";
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_nombre'] = $usuario['nombre'];
                } else {
                    $_SESSION['error_login'] = "Cuenta no autorizada para administración.";
                }
                break;

            default:
                $_SESSION['error_login'] = "Rol no válido.";
                break;
        }

        if ($accesoPermitido) {
            // Guardar datos comunes de sesión
            $_SESSION['rol_activo'] = $rol;
            $_SESSION['usuario_id'] = $idAsistente;
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_email'] = $usuario['email'];
            
            // Compatibilidad extra para el dashboard de asistente
            if ($rol == 'entrenador') {
                $_SESSION['asistente_id'] = $idAsistente;
                $_SESSION['asistente_nombre'] = $usuario['nombre'];
            }

            header("Location: " . $urlRedireccion);
            exit();
        } else {
            // Login OK pero Rol incorrecto
            header("Location: ../views/login/login_unificado.php");
            exit();
        }

    } catch (PDOException $e) {
        error_log("Error de BD en login: " . $e->getMessage());
        $_SESSION['error_login'] = "Ocurrió un error en el servidor. Intente más tarde.";
        header("Location: ../views/login/login_unificado.php");
        exit();
    }
} else {
    // Si intentan entrar directo al archivo sin POST
    header("Location: ../views/login/login_unificado.php");
    exit();
}
?>