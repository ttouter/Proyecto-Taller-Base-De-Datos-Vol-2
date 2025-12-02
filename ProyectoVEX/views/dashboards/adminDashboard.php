<?php
session_start();
$nombre_admin = isset($_SESSION['admin_nombre']) ? $_SESSION['admin_nombre'] : "Administrador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Organizador - VEX Robotics</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">
    
    <!-- ESTILOS -->
    <!-- 1. Estilos Base -->
    <link rel="stylesheet" href="../../assets/css/styles_asistenteDashboard.css">
    <!-- 2. Estilos Admin -->
    <link rel="stylesheet" href="../../assets/css/styles_admin.css">
    <!-- 3. Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="logo-admin">⚙️</div>
            <h2>VEX Control</h2>
            <p>Panel de Organizador</p>
        </div>

        <!-- MENÚ: Fíjate que ahora usamos href="#id" y NO onclick -->
        <ul class="sidebar-menu">
            <li><a href="#resumen" class="nav-link active"><i class="fas fa-home"></i> Resumen</a></li>
            <li><a href="#eventos" class="nav-link"><i class="fas fa-calendar-alt"></i> Gestión de Eventos</a></li>
            <li><a href="#escuelas" class="nav-link"><i class="fas fa-university"></i> Escuelas</a></li>
            <li><a href="#usuarios" class="nav-link"><i class="fas fa-users"></i> Monitor Usuarios</a></li>
            <!-- Cerrar sesión es un enlace normal a PHP, no lleva # -->
            <li><a href="../login/terminarSesion_organizador.php" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">
        
        <header class="content-header">
            <h1>Panel de Administración</h1>
            <div class="user-info">
                <span>Hola, <?php echo $nombre_admin; ?></span>
                <i class="fas fa-user-circle fa-lg" style="margin-left: 10px; color: #2C2C54;"></i>
            </div>
        </header>

        <!-- SECCIÓN: RESUMEN -->
        <div id="resumen" class="content-section active">
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="icon"><i class="fas fa-robot"></i></div>
                    <div class="info">
                        <h3>Equipos</h3>
                        <p class="number">24</p>
                    </div>
                </div>
                <div class="stat-card yellow">
                    <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="info">
                        <h3>Eventos Activos</h3>
                        <p class="number">3</p>
                    </div>
                </div>
                <div class="stat-card red">
                    <div class="icon"><i class="fas fa-gavel"></i></div>
                    <div class="info">
                        <h3>Jueces</h3>
                        <p class="number">8</p>
                    </div>
                </div>
                <div class="stat-card green">
                    <div class="icon"><i class="fas fa-user-friends"></i></div>
                    <div class="info">
                        <h3>Participantes</h3>
                        <p class="number">150+</p>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2 style="color: #2C2C54; border-bottom: 2px solid #F9E595; padding-bottom: 10px; margin-bottom: 20px;">Últimos Equipos Registrados</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Equipo</th>
                                <th>Categoría</th>
                                <th>Escuela</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>101</td>
                                <td>RoboTigers</td>
                                <td>Preparatoria</td>
                                <td>Tec Madero</td>
                                <td><span class="status active">Activo</span></td>
                            </tr>
                            <tr>
                                <td>102</td>
                                <td>MechaWarriors</td>
                                <td>Universidad</td>
                                <td>Polytechnic</td>
                                <td><span class="status pending">Pendiente</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SECCIÓN: GESTIÓN DE EVENTOS -->
        <div id="eventos" class="content-section">
            <div class="form-section">
                <h2 style="color: #2C2C54;">Registrar Nuevo Evento</h2>
                <form id="formNuevoEvento" action="../../controllers/control_evento.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombreEvento">Nombre del Evento</label>
                            <input type="text" id="nombreEvento" name="nombre" placeholder="Ej. Torneo Nacional 2025" required>
                        </div>
                        <div class="form-group">
                            <label for="lugarEvento">Lugar / Sede</label>
                            <input type="text" id="lugarEvento" name="lugar" placeholder="Ej. Auditorio Municipal" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaEvento">Fecha</label>
                            <input type="date" id="fechaEvento" name="fecha" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary" style="margin-top: 10px;"><i class="fas fa-plus"></i> Crear Evento</button>
                </form>
            </div>
        </div>

        <!-- SECCIÓN: ESCUELAS -->
        <div id="escuelas" class="content-section">
            <div class="form-section">
                <h2 style="color: #2C2C54;">Alta de Instituciones</h2>
                <form id="formNuevaEscuela" action="../../controllers/control_escuela.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="codEscuela">Código de Escuela (ID)</label>
                            <input type="text" id="codEscuela" name="codEscuela" placeholder="Ej. ITM-01" required>
                        </div>
                        <div class="form-group">
                            <label for="nombreEscuela">Nombre de la Institución</label>
                            <input type="text" id="nombreEscuela" name="nombreEscuela" placeholder="Ej. Instituto Tecnológico de Madero" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary" style="margin-top: 10px;"><i class="fas fa-save"></i> Guardar Escuela</button>
                </form>
            </div>
        </div>

        <!-- SECCIÓN: USUARIOS -->
        <div id="usuarios" class="content-section">
            <div class="form-section">
                <h2 style="color: #2C2C54;">Directorio de Usuarios</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Juan Pérez</td>
                                <td>juan@email.com</td>
                                <td><span class="badge role-coach">Entrenador</span></td>
                                <td><button class="btn-icon delete"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</div>

<!-- CARGAR SCRIPT JS -->
<!-- Ajusta la ruta si tu archivo está en otra carpeta -->
<script src="../../assets/js/admin_script.js"></script>

</body>
</html>