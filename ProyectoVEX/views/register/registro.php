<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cuenta - VEX Robotics</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">
    
    <!-- Nueva Hoja de Estilos -->
    <link rel="stylesheet" href="../../assets/css/styles_registro_moderno.css">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="split-screen">
        
        <!-- PANEL IZQUIERDO: Branding y Bienvenida -->
        <div class="left-pane">
            <div class="overlay">
                <a href="../index/Index.html" class="brand-link">
                    <img src="../../assets/img/logo.png" alt="Logo VEX" class="logo">
                    <span>VEX Robotics</span>
                </a>
                
                <div class="welcome-content">
                    <h1>¡Bienvenido, futuro participante!</h1>
                    <p>
                        Únete a la comunidad de robótica más grande. Gestiona tus equipos, 
                        inscribe participantes y accede a herramientas exclusivas para llevar 
                        la competencia al siguiente nivel.
                    </p>
                    <div class="features">
                        <div class="feature-item">
                            <i class="fas fa-trophy"></i>
                            <span>Torneos Nacionales</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-users"></i>
                            <span>Gestión de Equipos</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Seguimiento en Vivo</span>
                        </div>
                    </div>
                </div>
                
                <p class="copyright">&copy; 2025 VEX Robotics Organization</p>
            </div>
        </div>

        <!-- PANEL DERECHO: Formulario -->
        <div class="right-pane">
            <div class="form-container">
                <div class="form-header">
                    <h2>Crear una cuenta</h2>
                    <p>Completa tus datos para comenzar</p>
                </div>

                <!-- Muestra errores si existen (puedes conectar esto con tu lógica PHP) -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="../../controllers/control_registro.php" method="POST" class="register-form">
                    
                    <div class="form-row">
                        <div class="input-group">
                            <label>Nombre</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" name="nombre" placeholder="Tu nombre" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Sexo</label>
                            <div class="input-wrapper">
                                <i class="fas fa-venus-mars"></i>
                                <select name="sexo" required>
                                    <option value="" disabled selected>Selecciona...</option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Mujer">Mujer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label>Apellido Paterno</label>
                            <div class="input-wrapper">
                                <i class="far fa-user"></i>
                                <input type="text" name="ap_paterno" placeholder="Apellido Paterno" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Apellido Materno</label>
                            <div class="input-wrapper">
                                <i class="far fa-user"></i>
                                <input type="text" name="ap_materno" placeholder="Apellido Materno" required>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Correo Electrónico</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="ejemplo@correo.com" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Contraseña</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Crea una contraseña segura" required>
                        </div>
                        <small class="hint">Mínimo 8 caracteres</small>
                    </div>

                    <div class="actions">
                        <button type="submit" class="btn-register">
                            Registrarme <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                    <p class="login-redirect">
                        ¿Ya tienes una cuenta? <a href="../login/login_unificado.php">Inicia sesión aquí</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>
</html>