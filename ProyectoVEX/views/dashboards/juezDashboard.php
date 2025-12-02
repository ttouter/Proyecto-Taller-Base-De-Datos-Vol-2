<?php
session_start();
$nombre_juez = isset($_SESSION['juez_nombre']) ? $_SESSION['juez_nombre'] : "Juez Evaluador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Juez - VEX Robotics</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">

    <!-- Estilos -->
    <link rel="stylesheet" href="../../assets/css/styles_asistenteDashboard.css">
    <link rel="stylesheet" href="../../assets/css/styles_juez.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="logo-juez">⚖️</div>
            <h2>VEX Evaluate</h2>
            <p>Panel de Juez</p>
        </div>

        <ul class="sidebar-menu">
            <li><a href="#inicio" class="nav-link active"><i class="fas fa-chart-pie"></i> Inicio</a></li>
            <li><a href="#equipos" class="nav-link"><i class="fas fa-users-cog"></i> Mis Equipos</a></li>
            <li><a href="#evaluacion" class="nav-link hidden-nav" id="nav-evaluacion"><i class="fas fa-clipboard-check"></i> Evaluando...</a></li>
            <li><a href="../login/terminarSesion_juez.php" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">
        
        <header class="content-header">
            <h1>Zona de Evaluación</h1>
            <div class="user-info">
                <span>Juez: <?php echo $nombre_juez; ?></span>
                <i class="fas fa-gavel fa-lg" style="margin-left: 10px; color: #c0392b;"></i>
            </div>
        </header>

        <!-- SECCIÓN: INICIO -->
        <div id="inicio" class="content-section active">
            <div class="welcome-banner">
                <h2>Bienvenido a la competencia</h2>
                <p>Selecciona un equipo de tu lista para comenzar la evaluación según las rúbricas oficiales.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card red">
                    <div class="icon"><i class="fas fa-tasks"></i></div>
                    <div class="info">
                        <h3>Asignados</h3>
                        <p class="number">12 Equipos</p>
                    </div>
                </div>
                <div class="stat-card yellow">
                    <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="info">
                        <h3>Pendientes</h3>
                        <p class="number">8</p>
                    </div>
                </div>
                <div class="stat-card green">
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <div class="info">
                        <h3>Completados</h3>
                        <p class="number">4</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN: MIS EQUIPOS -->
        <div id="equipos" class="content-section">
            <div class="form-section">
                <h2>Equipos Asignados</h2>
                <p>Haz clic en el botón <strong>"Evaluar"</strong> para abrir la rúbrica.</p>
                
                <div class="teams-grid">
                    <!-- Tarjeta Equipo 1 -->
                    <div class="team-card">
                        <div class="team-header">
                            <span class="team-id">#101</span>
                            <span class="badge pending">Pendiente</span>
                        </div>
                        <h3>RoboTigers</h3>
                        <p class="school">Tec Madero</p>
                        <p class="category">Preparatoria</p>
                        <button class="btn-evaluar" data-id="101" data-name="RoboTigers">Evaluar Equipo</button>
                    </div>
                    <!-- Tarjeta Equipo 2 -->
                    <div class="team-card">
                        <div class="team-header">
                            <span class="team-id">#205</span>
                            <span class="badge completed">Evaluado</span>
                        </div>
                        <h3>IronGiants</h3>
                        <p class="school">CETIS 109</p>
                        <p class="category">Universidad</p>
                        <button class="btn-evaluar secondary" data-id="205" data-name="IronGiants">Editar Evaluación</button>
                    </div>
                    <!-- Tarjeta Equipo 3 -->
                    <div class="team-card">
                        <div class="team-header">
                            <span class="team-id">#303</span>
                            <span class="badge pending">Pendiente</span>
                        </div>
                        <h3>CyberPunk</h3>
                        <p class="school">Inst. Cultural</p>
                        <p class="category">Secundaria</p>
                        <button class="btn-evaluar" data-id="303" data-name="CyberPunk">Evaluar Equipo</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN: FORMULARIO DE EVALUACIÓN -->
        <div id="evaluacion" class="content-section">
            <div class="evaluation-container">
                
                <!-- CABECERA DE EVALUACIÓN (AQUÍ ESTÁ EL CAMBIO) -->
                <div class="eval-header">
                    <div class="eval-info">
                        <h2 id="eval-team-title">Equipo...</h2>
                        <span class="subtitle">Evaluación en curso</span>
                    </div>
                    
                    <div class="eval-controls">
                        <!-- PUNTAJE FLOTANTE -->
                        <div class="live-score-box">
                            <span class="score-label">Puntaje Total</span>
                            <span id="score-total" class="score-value">0</span>
                        </div>
                        
                        <button class="btn-close-eval" id="btn-cancelar-eval">
                            <i class="fas fa-times"></i> Salir
                        </button>
                    </div>
                </div>

                <!-- TABS PARA CATEGORÍAS -->
                <div class="eval-tabs">
                    <button class="tab-btn active" data-tab="tab-diseno">Diseño</button>
                    <button class="tab-btn" data-tab="tab-progra">Programación</button>
                    <button class="tab-btn" data-tab="tab-construccion">Construcción</button>
                </div>

                <form id="formEvaluacion" action="../../controllers/control_evaluacion.php" method="POST">
                    <input type="hidden" name="idEquipo" id="input-id-equipo">
                    
                    <!-- TAB 1: DISEÑO -->
                    <div id="tab-diseno" class="tab-content active">
                        <h3>Diseño</h3>
                        <div class="rubric-grid">
                            <div class="rubric-item">
                                <label>Registro de Fechas (0-5)</label>
                                <input type="number" name="registroDeFechas" min="0" max="5" required>
                            </div>
                            <div class="rubric-item">
                                <label>Justificación de Cambios (0-5)</label>
                                <input type="number" name="justificacionDeCambios" min="0" max="5" required>
                            </div>
                            <div class="rubric-item">
                                <label>Diagramas e Imágenes (0-5)</label>
                                <input type="number" name="diagramasEImagenes" min="0" max="5" required>
                            </div>
                            <div class="rubric-item">
                                <label>Video y Animación (0-5)</label>
                                <input type="number" name="videoYAnimacion" min="0" max="5" required>
                            </div>
                            <div class="rubric-item">
                                <label>Modelado Autodesk (0-5)</label>
                                <input type="number" name="disenoYModelado" min="0" max="5" required>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: PROGRAMACIÓN -->
                    <div id="tab-progra" class="tab-content">
                        <h3>Programación</h3>
                        <div class="rubric-grid">
                            <div class="rubric-item">
                                <label>Uso de Funciones (0-5)</label>
                                <input type="number" name="usoFunciones" min="0" max="5">
                            </div>
                            <div class="rubric-item">
                                <label>Complejidad del Programa (0-10)</label>
                                <input type="number" name="complejidad" min="0" max="10">
                            </div>
                            <div class="rubric-item">
                                <label>Código Modular (0-5)</label>
                                <input type="number" name="codigoModular" min="0" max="5">
                            </div>
                            <div class="rubric-item">
                                <label>Sistema Autónomo (0-10)</label>
                                <input type="number" name="sistemaAutonomo" min="0" max="10">
                            </div>
                            <div class="rubric-item">
                                <label>Control Driver (Joystick) (0-10)</label>
                                <input type="number" name="controlDriver" min="0" max="10">
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: CONSTRUCCIÓN -->
                    <div id="tab-construccion" class="tab-content">
                        <h3>Construcción</h3>
                        <div class="rubric-grid">
                            <div class="rubric-item">
                                <label>Prototipo Estético (0-5)</label>
                                <input type="number" name="estetica" min="0" max="5">
                            </div>
                            <div class="rubric-item">
                                <label>Estructuras Estables (0-5)</label>
                                <input type="number" name="estabilidad" min="0" max="5">
                            </div>
                            <div class="rubric-item">
                                <label>Gestión de Cables (0-5)</label>
                                <input type="number" name="cableado" min="0" max="5">
                            </div>
                            <div class="rubric-item">
                                <label>Uso de Sensores (0-5)</label>
                                <input type="number" name="sensores" min="0" max="5">
                            </div>
                            <div class="rubric-item">
                                <label>Tren de Engranes (0-5)</label>
                                <input type="number" name="engranes" min="0" max="5">
                            </div>
                        </div>
                    </div>

                    <!-- BOTÓN FINAL -->
                    <div class="form-actions">
                        <button type="submit" class="btn-primary btn-large">Guardar Evaluación Final</button>
                    </div>

                </form>
            </div>
        </div>

    </main>
</div>

<!-- Scripts -->
<script src="../../assets/js/juez_script.js"></script>

</body>
</html>