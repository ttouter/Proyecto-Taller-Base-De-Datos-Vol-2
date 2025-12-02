<?php
session_start();
// Validación de sesión básica
$nombre_entrenador = isset($_SESSION['asistente_nombre']) ? $_SESSION['asistente_nombre'] : "Entrenador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Entrenador - VEX Robotics</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">

    <!-- 1. Estilos Base (Layout general) -->
    <link rel="stylesheet" href="../../assets/css/styles_asistenteDashboard.css">
    <!-- 2. Estilos Específicos del Entrenador -->
    <link rel="stylesheet" href="../../assets/css/styles_entrenador.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="logo-coach">🧢</div> <!-- Icono representativo -->
            <h2>VEX Team</h2>
            <p>Panel de Entrenador</p>
        </div>

        <ul class="sidebar-menu">
            <li><a href="#resumen" class="nav-link active"><i class="fas fa-tachometer-alt"></i> Resumen</a></li>
            <li><a href="#nuevo-equipo" class="nav-link"><i class="fas fa-plus-circle"></i> Nuevo Equipo</a></li>
            <li><a href="#participantes" class="nav-link"><i class="fas fa-user-plus"></i> Participantes</a></li>
            <li><a href="#mis-equipos" class="nav-link"><i class="fas fa-users"></i> Mis Equipos</a></li>
            <li><a href="../login/terminarSesion_asistente.php" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">
        
        <header class="content-header">
            <h1>Gestión de Equipos</h1>
            <div class="user-info">
                <span>Coach: <?php echo $nombre_entrenador; ?></span>
                <i class="fas fa-id-badge fa-lg" style="margin-left: 10px; color: #40407A;"></i>
            </div>
        </header>

        <!-- SECCIÓN: RESUMEN (HOME) -->
        <div id="resumen" class="content-section active">
            <div class="welcome-banner coach-banner">
                <h2>¡Hola de nuevo, Coach!</h2>
                <p>Prepara a tus equipos para la victoria. Aquí tienes el estado actual de tus registros.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card indigo">
                    <div class="icon"><i class="fas fa-robot"></i></div>
                    <div class="info">
                        <h3>Mis Equipos</h3>
                        <p class="number">3</p>
                    </div>
                </div>
                <div class="stat-card teal">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="info">
                        <h3>Participantes</h3>
                        <p class="number">12</p>
                    </div>
                </div>
                <div class="stat-card purple">
                    <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="info">
                        <h3>Próximo Evento</h3>
                        <p class="text-stat">Torneo Nacional</p>
                    </div>
                </div>
            </div>

            <!-- Tabla rápida -->
            <div class="form-section">
                <h3>Actividad Reciente</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Equipo</th>
                                <th>Acción</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>RoboTigers</td>
                                <td>Registro de Participante</td>
                                <td>Hoy, 10:30 AM</td>
                                <td><span class="status completed">Completado</span></td>
                            </tr>
                            <tr>
                                <td>MechaWarriors</td>
                                <td>Inscripción a Evento</td>
                                <td>Ayer</td>
                                <td><span class="status pending">En revisión</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SECCIÓN: NUEVO EQUIPO -->
        <div id="nuevo-equipo" class="content-section">
            <div class="form-section">
                <h2><i class="fas fa-plus"></i> Registrar Nuevo Equipo</h2>
                <p>Inscribe un nuevo robot para la competencia.</p>
                
                <form id="formNuevoEquipo" action="../../controllers/control_registrarEquipo.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombreEquipo">Nombre del Equipo *</label>
                            <input type="text" id="nombreEquipo" name="nombreEquipo" placeholder="Ej. CyberLions" required>
                        </div>
                        <div class="form-group">
                            <label for="categoria">Categoría *</label>
                            <select id="categoria" name="idCategoria" required>
                                <option value="">Seleccione...</option>
                                <option value="1">Primaria</option>
                                <option value="2">Secundaria</option>
                                <option value="3">Preparatoria</option>
                                <option value="4">Universidad</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="evento">Evento a participar *</label>
                            <select id="evento" name="evento" required>
                                <option value="">Seleccione evento...</option>
                                <option value="Torneo Nacional 2025">Torneo Nacional 2025</option>
                                <option value="Regional Norte">Regional Norte</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="escuela">Escuela de Procedencia *</label>
                            <input type="text" id="escuela" name="codEscuela" placeholder="Código o Nombre de Escuela" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Registrar Equipo</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SECCIÓN: REGISTRAR PARTICIPANTES -->
        <div id="participantes" class="content-section">
            <div class="form-section">
                <h2><i class="fas fa-user-plus"></i> Agregar Integrantes</h2>
                <p>Registra a los estudiantes dentro de un equipo existente.</p>

                <form id="formParticipante" action="../../controllers/control_registrarParticipante.php" method="POST">
                    
                    <!-- Selección del Equipo -->
                    <div class="form-group highlight-group">
                        <label for="selectEquipo">Selecciona el Equipo *</label>
                        <select id="selectEquipo" name="idEquipo" required class="big-select">
                            <option value="">-- Elige un equipo --</option>
                            <option value="101">RoboTigers</option>
                            <option value="102">MechaWarriors</option>
                            <option value="103">CyberPunk</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="numControl">Número de Control / Matrícula *</label>
                            <input type="text" id="numControl" name="numControl" required>
                        </div>
                        <div class="form-group">
                            <label for="nombrePart">Nombre(s) *</label>
                            <input type="text" id="nombrePart" name="nombre" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="apPaterno">Apellido Paterno *</label>
                            <input type="text" id="apPaterno" name="apellidoPat" required>
                        </div>
                        <div class="form-group">
                            <label for="apMaterno">Apellido Materno *</label>
                            <input type="text" id="apMaterno" name="apellidoMat" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="edad">Edad *</label>
                            <input type="number" id="edad" name="edad" min="5" max="99" required>
                        </div>
                        <div class="form-group">
                            <label for="sexo">Sexo *</label>
                            <select id="sexo" name="sexo" required>
                                <option value="Hombre">Hombre</option>
                                <option value="Mujer">Mujer</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Guardar Participante</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SECCIÓN: MIS EQUIPOS (VISUAL) -->
        <div id="mis-equipos" class="content-section">
            <div class="teams-container">
                
                <!-- Tarjeta Equipo 1 -->
                <div class="coach-team-card">
                    <div class="card-header-img">
                        <img src="../../assets/img/robot.jpeg" alt="Robot Team">
                        <span class="category-badge">Preparatoria</span>
                    </div>
                    <div class="card-body">
                        <h3>RoboTigers</h3>
                        <p class="event-name"><i class="fas fa-map-marker-alt"></i> Torneo Nacional 2025</p>
                        
                        <div class="members-preview">
                            <span>Integrantes: 4</span>
                            <div class="avatars">
                                <div class="avatar">JP</div>
                                <div class="avatar">AL</div>
                                <div class="avatar">+2</div>
                            </div>
                        </div>

                        <div class="card-actions">
                            <button class="btn-outline">Editar</button>
                            <button class="btn-solid">Ver Detalles</button>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Equipo 2 -->
                <div class="coach-team-card">
                    <div class="card-header-img placeholder-img">
                        <i class="fas fa-robot fa-3x"></i>
                        <span class="category-badge">Universidad</span>
                    </div>
                    <div class="card-body">
                        <h3>MechaWarriors</h3>
                        <p class="event-name"><i class="fas fa-map-marker-alt"></i> Regional Norte</p>
                        
                        <div class="members-preview">
                            <span>Integrantes: 2</span>
                            <div class="avatars">
                                <div class="avatar">RM</div>
                                <div class="avatar">SO</div>
                            </div>
                        </div>

                        <div class="card-actions">
                            <button class="btn-outline">Editar</button>
                            <button class="btn-solid">Ver Detalles</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>
</div>

<!-- Script Lógica -->
<script src="../../assets/js/entrenador_script.js"></script>

</body>
</html>