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

    <!-- Estilos específicos para la validación de contraseña -->
    <style>
        .password-requirements {
            list-style: none;
            padding: 0;
            margin-top: 10px;
            font-size: 0.85rem;
            background: rgba(255,255,255,0.5);
            padding: 10px;
            border-radius: 8px;
        }
        
        .password-requirements li {
            margin-bottom: 5px;
            color: #666;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .password-requirements li i {
            font-size: 12px;
        }

        /* Clases para estado válido/inválido */
        .req-valid {
            color: #27ae60 !important; /* Verde */
            font-weight: 500;
        }
        
        .req-invalid {
            color: #e74c3c; /* Rojo */
        }

        /* Deshabilitar botón visualmente */
        button:disabled {
            background: #95a5a6 !important;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }
    </style>
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

                <!-- Muestra errores si existen -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="../../controllers/control_registro.php" method="POST" class="register-form" id="registroForm">
                    
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

                    <!-- CAMBIO: Campo de contraseña con validación -->
                    <div class="input-group">
                        <label>Contraseña</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="passwordInput" placeholder="Crea una contraseña segura" required>
                            <i class="fas fa-eye" id="togglePassword" style="left: auto; right: 15px; cursor: pointer;"></i>
                        </div>
                        
                        <!-- Lista de requisitos dinámica -->
                        <ul class="password-requirements">
                            <li id="req-length" class="req-invalid"><i class="fas fa-circle"></i> Mínimo 8 caracteres</li>
                            <li id="req-upper" class="req-invalid"><i class="fas fa-circle"></i> Al menos una mayúscula</li>
                            <li id="req-lower" class="req-invalid"><i class="fas fa-circle"></i> Al menos una minúscula</li>
                            <li id="req-number" class="req-invalid"><i class="fas fa-circle"></i> Al menos un número</li>
                            <li id="req-special" class="req-invalid"><i class="fas fa-circle"></i> Carácter especial (!@#$%)</li>
                        </ul>
                    </div>

                    <div class="actions">
                        <button type="submit" class="btn-register" id="btnSubmit" disabled>
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

    <!-- SCRIPT DE VALIDACIÓN -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('passwordInput');
            const togglePassword = document.getElementById('togglePassword');
            const submitButton = document.getElementById('btnSubmit');

            // Requisitos
            const requirements = {
                length: { regex: /.{8,}/, element: document.getElementById('req-length') },
                upper: { regex: /[A-Z]/, element: document.getElementById('req-upper') },
                lower: { regex: /[a-z]/, element: document.getElementById('req-lower') },
                number: { regex: /[0-9]/, element: document.getElementById('req-number') },
                special: { regex: /[!@#$%^&*(),.?":{}|<>]/, element: document.getElementById('req-special') }
            };

            // Función para alternar visibilidad contraseña
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Función de validación
            passwordInput.addEventListener('keyup', function() {
                const value = passwordInput.value;
                let allValid = true;

                for (const key in requirements) {
                    const req = requirements[key];
                    const isValid = req.regex.test(value);
                    const icon = req.element.querySelector('i');

                    if (isValid) {
                        req.element.classList.remove('req-invalid');
                        req.element.classList.add('req-valid');
                        icon.classList.remove('fa-circle');
                        icon.classList.add('fa-check-circle');
                    } else {
                        req.element.classList.remove('req-valid');
                        req.element.classList.add('req-invalid');
                        icon.classList.remove('fa-check-circle');
                        icon.classList.add('fa-circle');
                        allValid = false;
                    }
                }

                // Habilitar/Deshabilitar botón
                submitButton.disabled = !allValid;
            });
        });
    </script>

</body>
</html>