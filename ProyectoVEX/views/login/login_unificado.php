<?php
session_start();
// Si ya hay sesión activa, redirigir al dashboard correspondiente
if (isset($_SESSION['rol_activo'])) {
    switch ($_SESSION['rol_activo']) {
        case 'entrenador': header("Location: ../dashboards/asistenteDashboard.php"); break;
        case 'juez': header("Location: ../dashboards/juezDashboard.php"); break;
        case 'organizador': header("Location: ../dashboards/adminDashboard.php"); break;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - VEX Robotics</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">
    <!-- Estilos Unificados -->
    <link rel="stylesheet" href="../../assets/css/styles_login_unificado.css">
    <!-- Iconos FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <!-- BOTÓN DE REGRESO AL INICIO (Asegúrate de que esta línea exista) -->
    <a href="../index/Index.html" class="btn-back-home">
        <i class="fas fa-arrow-left"></i> Regresar al Inicio
    </a>

    <div class="login-wrapper">
        <!-- Panel Izquierdo (Imagen/Decoración) -->
        <div class="login-left">
            <div class="overlay">
                <div class="brand">
                    <img src="../../assets/img/logo.png" alt="Logo VEX" class="logo-img">
                    <h1>Torneo VEX Robotics</h1>
                </div>
                <p>Bienvenido a la plataforma de gestión de competencias. Conecta, compite e innova.</p>
            </div>
        </div>

        <!-- Panel Derecho (Formulario) -->
        <div class="login-right">
            <div class="login-container">
                <h2>Iniciar Sesión</h2>
                <p class="subtitle">Selecciona tu rol para ingresar</p>

                <!-- Mensajes de Error (Flash Message) -->
                <?php if (isset($_SESSION['error_login'])): ?>
                    <div class="alert error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $_SESSION['error_login']; unset($_SESSION['error_login']); ?>
                    </div>
                <?php endif; ?>

                <!-- Selector de Roles (Tabs) -->
                <div class="role-tabs">
                    <div class="role-tab active" data-role="entrenador" onclick="selectRole('entrenador')">
                        <i class="fas fa-user-tie"></i>
                        <span>Entrenador</span>
                    </div>
                    <div class="role-tab" data-role="juez" onclick="selectRole('juez')">
                        <i class="fas fa-gavel"></i>
                        <span>Juez</span>
                    </div>
                    <div class="role-tab" data-role="organizador" onclick="selectRole('organizador')">
                        <i class="fas fa-cogs"></i>
                        <span>Admin</span>
                    </div>
                </div>

                <form action="../../controllers/control_login_unificado.php" method="POST" id="loginForm">
                    <!-- Input Oculto para enviar el Rol seleccionado -->
                    <input type="hidden" name="rol" id="selectedRole" value="entrenador">

                    <div class="input-group">
                        <label for="email">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope icon"></i>
                            <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock icon"></i>
                            <input type="password" id="password" name="password" placeholder="••••••••" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                        </div>
                    </div>

                    <div class="form-footer">
                        <label class="checkbox-container">
                            <input type="checkbox" name="recordar">
                            <span class="checkmark"></span>
                            Recordarme
                        </label>
                        <!-- Se le agrega ID para ocultarlo vía JS -->
                        <a href="#" class="forgot-pass" id="forgotPassLink">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="btn-submit">
                        Ingresar como <span id="btnRoleText">Entrenador</span>
                    </button>
                </form>

                <!-- Se le agrega ID para ocultarlo vía JS -->
                <div class="register-link" id="registerLinkSection">
                    ¿No tienes una cuenta? <a href="../register/registro.php">Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de interacción -->
    <script>
        function selectRole(role) {
            // 1. Actualizar visualmente las pestañas
            document.querySelectorAll('.role-tab').forEach(tab => tab.classList.remove('active'));
            document.querySelector(`.role-tab[data-role="${role}"]`).classList.add('active');
            
            // 2. Actualizar el valor oculto
            document.getElementById('selectedRole').value = role;
            
            // 3. Actualizar texto del botón
            const roleTexts = {
                'entrenador': 'Entrenador',
                'juez': 'Juez',
                'organizador': 'Organizador'
            };
            document.getElementById('btnRoleText').textContent = roleTexts[role];

            // 4. LÓGICA DE OCULTAMIENTO (NUEVO)
            const forgotPassLink = document.getElementById('forgotPassLink');
            const registerLinkSection = document.getElementById('registerLinkSection');

            if (role === 'organizador') {
                // Si es Admin, ocultamos los enlaces
                forgotPassLink.style.display = 'none';
                registerLinkSection.style.display = 'none';
            } else {
                // Si es Entrenador o Juez, los mostramos
                forgotPassLink.style.display = 'block';
                registerLinkSection.style.display = 'block';
            }
        }

        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.querySelector('.toggle-password');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>