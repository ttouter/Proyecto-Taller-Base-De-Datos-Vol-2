<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de sesión Organizador - VEX</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">
    <link rel="stylesheet" href="../../assets/css/styles_inicioSesion.css">
</head>
<body>

    <!-- HEADER --> 
    <header>
        <div class="left">
            <img src="../../assets/img/logo.png" alt="Logo" />
        </div>
        <div class="center">
            <h1>Título de la Organización</h1>
        </div>
        <div class="right">
            <a href="../../views/index/Index.html" class="btn-header">Regresar a inicio</a>
        </div>
    </header>

    <!-- LOGIN CARD -->
    <main class="login-container">
        <div class="login-box">
            <div class="login-icon">⚙️</div>
            <h2>Ingreso a administrador</h2>
            

            <form action="../../controllers/control_inicioSesionOrganizador.php" method="POST">
                <label for="usuario">Usuario *</label>
                <input type="text" id="usuario" name="email" placeholder="Correo electrónico" required>

                <label for="password">Contraseña *</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>

                <div class="recordar">
                    <input type="checkbox" id="recordar" name="recordar">
                    <label for="recordar">Recordarme</label>
                </div>

                <button type="submit" class="btn-login">Acceso</button>
            </form>

            <div class="login-links">
                <a href="#">¿Se te olvidó tu contraseña?</a>
                <a href="../../views/register/registro.php">¿No tienes una cuenta?</a>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>&copy; 2025 Competencia de Robótica</p>
    </footer>

</body>
</html>
