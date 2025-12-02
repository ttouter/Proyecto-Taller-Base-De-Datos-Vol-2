<?php
session_start();

// 1. Seguridad
if (!isset($_SESSION['rol_activo']) || $_SESSION['rol_activo'] !== 'juez') {
    header("Location: ../login/login_unificado.php");
    exit();
}

require_once '../../models/ModeloEvaluacion.php';

// 2. Cargar Datos
$idJuez = $_SESSION['usuario_id'];
$nombre_juez = $_SESSION['usuario_nombre'] ?? "Juez";

$equiposAsignados = ModeloEvaluacion::obtenerEquiposAsignados($idJuez);

// Contadores
$totalAsignados = count($equiposAsignados);
$completados = 0;
foreach($equiposAsignados as $eq) { if($eq['estado'] == 'Evaluado') $completados++; }
$pendientes = $totalAsignados - $completados;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Juez - VEX Robotics</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">

    <link rel="stylesheet" href="../../assets/css/styles_asistenteDashboard.css">
    <link rel="stylesheet" href="../../assets/css/styles_juez.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="dashboard-container">

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

    <main class="main-content">
        
        <header class="content-header">
            <h1>Zona de Evaluación</h1>
            <div class="user-info">
                <span>Juez: <?php echo htmlspecialchars($nombre_juez); ?></span>
                <i class="fas fa-gavel fa-lg" style="margin-left: 10px; color: #c0392b;"></i>
            </div>
        </header>

        <!-- SECCIÓN: INICIO -->
        <div id="inicio" class="content-section active">
            <div class="welcome-banner">
                <h2>Bienvenido a la competencia</h2>
                <p>Selecciona un equipo de tu lista para comenzar la evaluación.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card red">
                    <div class="icon"><i class="fas fa-tasks"></i></div>
                    <div class="info">
                        <h3>Asignados</h3>
                        <p class="number"><?php echo $totalAsignados; ?> Equipos</p>
                    </div>
                </div>
                <div class="stat-card yellow">
                    <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="info">
                        <h3>Pendientes</h3>
                        <p class="number"><?php echo $pendientes; ?></p>
                    </div>
                </div>
                <div class="stat-card green">
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <div class="info">
                        <h3>Completados</h3>
                        <p class="number"><?php echo $completados; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN: MIS EQUIPOS -->
        <div id="equipos" class="content-section">
            <div class="form-section">
                <h2>Equipos Asignados</h2>
                <div class="teams-grid">
                    <?php if(empty($equiposAsignados)): ?>
                        <p>No tienes equipos asignados por el administrador.</p>
                    <?php else: ?>
                        <?php foreach ($equiposAsignados as $eq): ?>
                        <div class="team-card">
                            <div class="team-header">
                                <span class="team-id">#<?php echo $eq['idEquipo']; ?></span>
                                <span class="badge <?php echo ($eq['estado']=='Evaluado')?'completed':'pending'; ?>">
                                    <?php echo $eq['estado']; ?>
                                </span>
                            </div>
                            <h3><?php echo htmlspecialchars($eq['nombreEquipo']); ?></h3>
                            <p class="school"><?php echo htmlspecialchars($eq['nombreEscuela']); ?></p>
                            <p class="category"><?php echo htmlspecialchars($eq['categoria']); ?></p>
                            
                            <button class="btn-evaluar" 
                                    data-id="<?php echo $eq['idEquipo']; ?>" 
                                    data-name="<?php echo htmlspecialchars($eq['nombreEquipo']); ?>">
                                <?php echo ($eq['estado']=='Evaluado') ? 'Editar Evaluación' : 'Evaluar Equipo'; ?>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- SECCIÓN: FORMULARIO DE EVALUACIÓN (Idéntica pero conectada) -->
        <div id="evaluacion" class="content-section">
            <div class="evaluation-container">
                <div class="eval-header">
                    <div class="eval-info">
                        <h2 id="eval-team-title">Equipo...</h2>
                        <span class="subtitle">Evaluación en curso</span>
                    </div>
                    <div class="eval-controls">
                        <div class="live-score-box">
                            <span class="score-label">Puntaje Total</span>
                            <span id="score-total" class="score-value">0</span>
                        </div>
                        <button class="btn-close-eval" id="btn-cancelar-eval">
                            <i class="fas fa-times"></i> Salir
                        </button>
                    </div>
                </div>

                <div class="eval-tabs">
                    <button class="tab-btn active" data-tab="tab-diseno">Diseño</button>
                    <button class="tab-btn" data-tab="tab-progra">Programación</button>
                    <button class="tab-btn" data-tab="tab-construccion">Construcción</button>
                </div>

                <form id="formEvaluacion" action="../../controllers/control_evaluacion.php" method="POST">
                    <input type="hidden" name="idEquipo" id="input-id-equipo">
                    
                    <!-- TAB 1: DISEÑO -->
                    <div id="tab-diseno" class="tab-content active">
                        <div class="rubric-grid">
                            <div class="rubric-item">
                                <label>Registro de Fechas (0-5)</label>
                                <input type="number" name="registroDeFechas" min="0" max="5" value="0" required>
                            </div>
                            <!-- ... resto de campos de diseño (igual que antes) ... -->
                            <!-- Por brevedad, asumo que copias los inputs del archivo original -->
                            <div class="rubric-item"><label>Justificación (0-5)</label><input type="number" name="justificacionDeCambios" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Diagramas (0-5)</label><input type="number" name="diagramasEImagenes" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Video (0-5)</label><input type="number" name="videoYAnimacion" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Modelado (0-5)</label><input type="number" name="disenoYModelado" min="0" max="5" value="0"></div>
                        </div>
                    </div>

                    <!-- TAB 2: PROGRAMACIÓN -->
                    <div id="tab-progra" class="tab-content">
                        <div class="rubric-grid">
                            <div class="rubric-item"><label>Uso Funciones (0-5)</label><input type="number" name="usoFunciones" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Complejidad (0-10)</label><input type="number" name="complejidad" min="0" max="10" value="0"></div>
                            <div class="rubric-item"><label>Código Modular (0-5)</label><input type="number" name="codigoModular" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Sist. Autónomo (0-10)</label><input type="number" name="sistemaAutonomo" min="0" max="10" value="0"></div>
                            <div class="rubric-item"><label>Driver (0-10)</label><input type="number" name="controlDriver" min="0" max="10" value="0"></div>
                        </div>
                    </div>

                    <!-- TAB 3: CONSTRUCCIÓN -->
                    <div id="tab-construccion" class="tab-content">
                        <div class="rubric-grid">
                            <div class="rubric-item"><label>Estética (0-5)</label><input type="number" name="estetica" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Estabilidad (0-5)</label><input type="number" name="estabilidad" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Cableado (0-5)</label><input type="number" name="cableado" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Sensores (0-5)</label><input type="number" name="sensores" min="0" max="5" value="0"></div>
                            <div class="rubric-item"><label>Engranes (0-5)</label><input type="number" name="engranes" min="0" max="5" value="0"></div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary btn-large">Guardar Evaluación Final</button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</div>
<script src="../../assets/js/juez_script.js"></script>
</body>
</html>