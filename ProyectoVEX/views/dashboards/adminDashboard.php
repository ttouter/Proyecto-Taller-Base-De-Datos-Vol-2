<?php
session_start();

// 1. Verificación de Seguridad
if (!isset($_SESSION['rol_activo']) || $_SESSION['rol_activo'] !== 'organizador') {
    header("Location: ../login/login_unificado.php");
    exit();
}

require_once '../../models/ModeloAdmin.php';
require_once '../../models/ModeloProcesos.php'; 

// 2. Obtener Datos
$resumen = ModeloAdmin::obtenerResumen(); 
$listaEquipos = ModeloAdmin::listarEquipos(); // Se usa en la tabla de resumen
$listaUsuarios = ModeloAdmin::listarUsuarios();
$listaEscuelas = ModeloProcesos::listarEscuelas(); 

$nombre_admin = $_SESSION['usuario_nombre'] ?? "Administrador";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Organizador - VEX Robotics</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">
    
    <!-- ESTILOS -->
    <link rel="stylesheet" href="../../assets/css/styles_asistenteDashboard.css">
    <link rel="stylesheet" href="../../assets/css/styles_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Estilos rápidos para el Modal dentro del Dashboard */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 2000; 
            left: 0; top: 0; 
            width: 100%; height: 100%; 
            background-color: rgba(0,0,0,0.5); 
            justify-content: center; 
            align-items: center;
        }
        .modal-content-box {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown { from {transform: translateY(-20px); opacity: 0;} to {transform: translateY(0); opacity: 1;} }
        .close-modal { float: right; font-size: 24px; cursor: pointer; color: #aaa; }
        .close-modal:hover { color: #000; }

        /* Estilos para la tabla de Reportes */
        .rank-badge {
            background-color: #2C2C54;
            color: #F9E595;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .top-1 { background-color: #f1c40f; color: #fff; transform: scale(1.2); box-shadow: 0 0 10px rgba(241, 196, 15, 0.5); }
        .top-2 { background-color: #bdc3c7; color: #fff; }
        .top-3 { background-color: #cd7f32; color: #fff; }
        
        .score-total { font-size: 1.2em; font-weight: bold; color: #2C2C54; }
    </style>
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

        <ul class="sidebar-menu">
            <li><a href="#resumen" class="nav-link active"><i class="fas fa-home"></i> Resumen</a></li>
            <li><a href="#reportes" class="nav-link"><i class="fas fa-trophy"></i> Reportes / Ranking</a></li>
            <li><a href="#eventos" class="nav-link"><i class="fas fa-calendar-alt"></i> Gestión de Eventos</a></li>
            <li><a href="#escuelas" class="nav-link"><i class="fas fa-university"></i> Escuelas</a></li>
            <li><a href="#usuarios" class="nav-link"><i class="fas fa-users"></i> Monitor Usuarios</a></li>
            <li><a href="../login/terminarSesion_organizador.php" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">
        
        <header class="content-header">
            <h1>Panel de Administración</h1>
            <div class="user-info">
                <span>Hola, <?php echo htmlspecialchars($nombre_admin); ?></span>
                <i class="fas fa-user-circle fa-lg" style="margin-left: 10px; color: #2C2C54;"></i>
            </div>
        </header>

        <!-- SECCIÓN: RESUMEN -->
        <div id="resumen" class="content-section active">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="icon"><i class="fas fa-robot"></i></div>
                    <div class="info">
                        <h3>Equipos</h3>
                        <p class="number"><?php echo $resumen['total_equipos']; ?></p>
                    </div>
                </div>
                <div class="stat-card yellow">
                    <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="info">
                        <h3>Eventos Activos</h3>
                        <p class="number"><?php echo $resumen['eventos_activos']; ?></p>
                    </div>
                </div>
                <div class="stat-card red">
                    <div class="icon"><i class="fas fa-gavel"></i></div>
                    <div class="info">
                        <h3>Jueces</h3>
                        <p class="number"><?php echo $resumen['total_jueces']; ?></p>
                    </div>
                </div>
                <div class="stat-card green">
                    <div class="icon"><i class="fas fa-user-friends"></i></div>
                    <div class="info">
                        <h3>Participantes</h3>
                        <p class="number"><?php echo $resumen['total_participantes']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Tabla de Últimos Equipos (Restaurada) -->
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
                            <?php if(empty($listaEquipos)): ?>
                                <tr><td colspan="5">No hay equipos registrados aún.</td></tr>
                            <?php else: ?>
                                <?php foreach ($listaEquipos as $equipo): ?>
                                <tr>
                                    <td><?php echo $equipo['idEquipo']; ?></td>
                                    <td><?php echo htmlspecialchars($equipo['nombreEquipo']); ?></td>
                                    <td><?php echo htmlspecialchars($equipo['categoria']); ?></td>
                                    <td><?php echo htmlspecialchars($equipo['nombreEscuela']); ?></td>
                                    <td>
                                        <span class="status <?php echo ($equipo['estado'] == 'Activo') ? 'active' : 'pending'; ?>">
                                            <?php echo $equipo['estado']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SECCIÓN: REPORTES (NUEVA) -->
        <div id="reportes" class="content-section">
            <div class="form-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                    <h2 style="color: #2C2C54; margin:0;">🏆 Ranking General del Torneo</h2>
                    <div>
                        <button onclick="cargarReporte()" class="btn-primary"><i class="fas fa-sync"></i> Actualizar</button>
                        <button onclick="window.print()" class="btn-secondary"><i class="fas fa-print"></i> Imprimir</button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="data-table" id="tabla-reporte">
                        <thead>
                            <tr>
                                <th>Posición</th>
                                <th>Equipo</th>
                                <th>Escuela</th>
                                <th>Diseño</th>
                                <th>Programación</th>
                                <th>Construcción</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="7" style="text-align:center;">Cargando datos...</td></tr>
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
                                <th>Rol Detectado</th>
                                <th>Acciones</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($listaUsuarios)): ?>
                                <tr><td colspan="5">No hay usuarios registrados.</td></tr>
                            <?php else: ?>
                                <?php foreach ($listaUsuarios as $usr): ?>
                                <tr>
                                    <td><?php echo $usr['idAsistente']; ?></td>
                                    <td><?php echo htmlspecialchars($usr['nombre'] . ' ' . $usr['apellidoPat']); ?></td>
                                    <td><?php echo htmlspecialchars($usr['email']); ?></td>
                                    <td>
                                        <span class="badge <?php echo (strpos($usr['rol_detectado'], 'Juez') !== false) ? 'role-judge' : 'role-coach'; ?>">
                                            <?php echo $usr['rol_detectado']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-icon edit" 
                                                onclick="abrirModalRol(<?php echo $usr['idAsistente']; ?>, '<?php echo htmlspecialchars($usr['nombre']); ?>')"
                                                title="Asignar Rol">
                                            <i class="fas fa-user-tag"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- MODAL PARA ASIGNAR ROL -->
    <div id="modalAsignarRol" class="modal">
        <div class="modal-content-box">
            <span class="close-modal" onclick="cerrarModal()">&times;</span>
            <h2 style="color: #2C2C54; margin-bottom: 20px;">Gestionar Rol de Usuario</h2>
            <p id="modalUserName" style="margin-bottom: 15px; font-weight: bold; color: #555;">Usuario: ...</p>
            
            <form action="../../controllers/control_asignar_rol.php" method="POST">
                <input type="hidden" name="idAsistente" id="modalIdAsistente">
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Tipo de Rol</label>
                    <select name="tipoRol" id="selectTipoRol" onchange="toggleGradoEstudios()" required>
                        <option value="entrenador">Entrenador</option>
                        <option value="juez">Juez</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Escuela / Institución</label>
                    <select name="codEscuela" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach($listaEscuelas as $esc): ?>
                            <option value="<?php echo $esc['codEscuela']; ?>">
                                <?php echo htmlspecialchars($esc['nombreEscuela']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" id="groupGradoEstudios" style="margin-bottom: 15px; display: none;">
                    <label>Grado de Estudios</label>
                    <select name="gradoEstudios">
                        <option value="Licenciatura">Licenciatura</option>
                        <option value="Maestria">Maestría</option>
                        <option value="Doctorado">Doctorado</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%;">Guardar Cambios</button>
            </form>
        </div>
    </div>

</div>

<!-- Scripts -->
<script src="../../assets/js/admin_script.js"></script>
<script>
    // Lógica para el modal de roles
    const modal = document.getElementById('modalAsignarRol');
    const inputId = document.getElementById('modalIdAsistente');
    const labelUser = document.getElementById('modalUserName');
    const selectRol = document.getElementById('selectTipoRol');
    const groupGrado = document.getElementById('groupGradoEstudios');

    function abrirModalRol(id, nombre) {
        inputId.value = id;
        labelUser.textContent = "Usuario: " + nombre;
        modal.style.display = "flex";
        toggleGradoEstudios(); 
    }

    function cerrarModal() {
        modal.style.display = "none";
    }

    function toggleGradoEstudios() {
        if(selectRol.value === 'juez') {
            groupGrado.style.display = 'block';
        } else {
            groupGrado.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            cerrarModal();
        }
    }

    // --- Lógica para cargar Reportes con Fetch API ---
    function cargarReporte() {
        fetch('../../controllers/control_reporte_general.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tabla-reporte tbody');
                tbody.innerHTML = ''; // Limpiar tabla

                if(data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;">No hay evaluaciones registradas aún.</td></tr>';
                    return;
                }
                
                data.forEach((equipo, index) => {
                    // Determinar clase para el top 3
                    let badgeClass = 'rank-badge';
                    if (index === 0) badgeClass += ' top-1';
                    if (index === 1) badgeClass += ' top-2';
                    if (index === 2) badgeClass += ' top-3';

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><div class="${badgeClass}">${index + 1}</div></td>
                        <td><strong>${equipo.nombreEquipo}</strong></td>
                        <td>${equipo.nombreEscuela}</td>
                        <td>${equipo.PuntosDiseno} pts</td>
                        <td>${equipo.PuntosProgra} pts</td>
                        <td>${equipo.PuntosConstruccion} pts</td>
                        <td class="score-total">${equipo.GranTotal}</td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Error cargando reporte:', error);
                document.querySelector('#tabla-reporte tbody').innerHTML = '<tr><td colspan="7" style="color:red; text-align:center;">Error al cargar datos.</td></tr>';
            });
    }

    // Cargar reporte automáticamente si entran directo con el hash #reportes
    if(window.location.hash === '#reportes') {
        cargarReporte();
    }
    
    // Asignar el evento al click del menú también
    document.querySelector('a[href="#reportes"]').addEventListener('click', cargarReporte);

</script>

</body>
</html>