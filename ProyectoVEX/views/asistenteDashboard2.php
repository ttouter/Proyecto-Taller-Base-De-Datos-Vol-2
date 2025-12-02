<?php
session_start(); 
if (!isset($_SESSION['asistente_logged_in']) || $_SESSION['asistente_logged_in'] !== true) {
    header('Location: inicioSesion_entrenador.php'); // o la vista de login de asistente
    exit;
}
$nombre_asistente = htmlspecialchars($_SESSION['asistente_nombre']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistente Dashboard - VEX Robotics</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        /* Estilos de Reporte */
        #reporte-general-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }
        .equipo-card-reporte {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            background: #fdfdfd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }
        .equipo-card-reporte h3 { color: var(--primary-color); border-bottom: 2px solid var(--light-bg); padding-bottom: 10px; margin-bottom: 15px; font-size: 1.2rem; }
        .equipo-card-reporte p { margin-bottom: 10px; }
        .equipo-card-reporte ul { list-style: disc; padding-left: 20px; margin-top: 5px; flex-grow: 1; }
        .equipo-card-reporte em { color: var(--light-text); font-style: italic; }
        .equipo-card-reporte .reporte-footer { margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--border-color); font-size: 0.9rem; color: var(--light-text); }
        .equipo-card-reporte .reporte-footer strong { color: var(--dark-text); }

        /* Estilos para Asignación de Juez */
        #asignar-jueces-container {
            display: grid;
            grid-template-columns: 1fr; /* 1 columna por defecto */
            gap: 20px;
        }

        @media (min-width: 768px) {
             #asignar-jueces-container {
                grid-template-columns: 1fr 2fr; /* 2 columnas en pantallas grandes */
                align-items: start;
             }
        }
        
        #select-equipos-asignar {
            width: 100%;
            height: 250px;
            font-size: 1rem;
            padding: 10px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
        }

        #select-equipos-asignar option[disabled] { color: #ccc; background: #f8f9fa; font-style: italic; }
        #select-equipos-asignar option.conflicto { color: var(--accent-color); font-weight: bold; background: #fff3cd; }
        
        /* Estilos para el Modal de Entrenador */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none; /* Oculto por defecto */
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            width: 90%;
            max-width: 500px;
        }
        
        .modal-content h2 { color: var(--primary-color); margin-top: 0; margin-bottom: 20px; }

        .clickable-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .clickable-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* --- Estilos para CHECKBOX --- */
        .checkbox-group { 
            display: flex; 
            align-items: center; 
            margin-bottom: 10px; 
        }
        .checkbox-label { 
            font-weight: normal; 
            margin-bottom: 0; 
            margin-left: 10px; 
            color: var(--dark-text);
        }
        input[type="checkbox"] { 
            width: auto; 
            height: 20px;
            width: 20px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>VEX Robotics</h2>
                <p>Panel de Administración</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="asistenteDashboard.php" class="active">Dashboard</a></li>
                <li><a href="#equipos">Mis Equipos</a></li>
                <li><a href="#participantes">Participantes</a></li>
                <li><a href="asistente_logout.php" class="logout">Cerrar Sesión</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="content-header">
                <h1>Dashboard de Asistente</h1>
                <div class="user-info">
                    <span><?php echo $nombre_asistente; ?></span>
                </div>
            </header>

            <div class="form-section" id="eventos">
                <h2>Registrar Evento</h2>
                <form id="eventoForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombreEvento">Nombre del Evento *</label>
                            <input type="text" id="nombreEvento" name="nombreEvento" required>
                        </div>
                        <div class="form-group">
                            <label for="lugarEvento">Lugar *</label>
                            <input type="text" id="lugarEvento" name="lugarEvento" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaEvento">Fecha *</label>
                            <input type="date" id="fechaEvento" name="fechaEvento" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Guardar Evento</button>
                </form>
            </div>

            <div class="form-section" id="escuelas">
                <h2>Registrar Escuela de Procedencia</h2>
                <form id="escuelaForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="codEscuela">Código de Escuela *</label>
                            <input type="text" id="codEscuela" name="codEscuela" required>
                        </div>
                        <div class="form-group">
                            <label for="nombreEscuela">Nombre de la Escuela *</label>
                            <input type="text" id="nombreEscuela" name="nombreEscuela" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Guardar Escuela</button>
                </form>
            </div>

            <div class="form-section" id="equipos">
                <h2>Registrar Equipo</h2>
                <form id="equipoForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombreEquipo">Nombre del Equipo *</label>
                            <input type="text" id="nombreEquipo" name="nombreEquipo" required>
                        </div>
                        <div class="form-group">
                            <label for="categoriaEquipo">Categoría *</label>
                            <select id="categoriaEquipo" name="categoriaEquipo" required>
                                <option value="">Seleccionar categoría</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="escuelaEquipo">Escuela *</label>
                            <select id="escuelaEquipo" name="escuelaEquipo" required>
                                <option value="">Seleccionar escuela</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eventoEquipo">Evento *</label>
                            <select id="eventoEquipo" name="eventoEquipo" required>
                                <option value="">Seleccionar evento</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group" style="flex-basis: 100%;">
                            <label for="entrenadorEquipo">Asignar Entrenador (Opcional)</label>
                            <select id="entrenadorEquipo" name="entrenadorEquipo">
                                <option value="">-- Seleccione una escuela primero --</option>
                            </select>
                            <small class="field-info">Solo se mostrarán entrenadores de la escuela seleccionada.</small>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Guardar Equipo</button>
                </form>
            </div>

            <div class="form-section" id="participantes">
                <h2>Registrar Participante (Admin)</h2>
                <div id="message" class="message"></div>
                <form id="registroForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="numControl">Número de Control *</label>
                            <input type="number" id="numControl" name="numControl" required>
                        </div>
                        <div class="form-group">
                            <label for="edad">Edad *</label>
                            <input type="number" id="edad" name="edad" min="7" max="100" required>
                            <small id="edadInfo" class="field-info"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoPat">Apellido Paterno *</label>
                            <input type="text" id="apellidoPat" name="apellidoPat" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoMat">Apellido Materno *</label>
                            <input type="text" id="apellidoMat" name="apellidoMat" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="sexo">Sexo *</label>
                            <select id="sexo" name="sexo" required>
                                <option value="">Seleccionar</option>
                                <option value="Hombre">Hombre</option>
                                <option value="Mujer">Mujer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="idEquipo">Seleccionar Equipo *</label>
                            <select id="idEquipo" name="idEquipo" required>
                                <option value="">Seleccionar equipo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="categoriaInfo">Categoría Asignada</label>
                        <input type="text" id="categoriaInfo" readonly class="readonly-field">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn-primary">Completar Registro</button>
                    </div>
                </form>
            </div>


            <div class="form-section" id="asistentes">
                <h2>Registrar Asistente (Juez o Entrenador)</h2>
                <form id="asistenteForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombreAsistente">Nombre *</label>
                            <input type="text" id="nombreAsistente" name="nombreAsistente" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoPatAsistente">Apellido Paterno *</label>
                            <input type="text" id="apellidoPatAsistente" name="apellidoPatAsistente" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoMatAsistente">Apellido Materno *</label>
                            <input type="text" id="apellidoMatAsistente" name="apellidoMatAsistente" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="emailAsistente">Email (Será su usuario) *</label>
                            <input type="email" id="emailAsistente" name="emailAsistente" required>
                        </div>
                        <div class="form-group">
                            <label for="sexoAsistente">Sexo *</label>
                            <select id="sexoAsistente" name="sexoAsistente" required>
                                <option value="">Seleccionar</option>
                                <option value="Hombre">Hombre</option>
                                <option value="Mujer">Mujer</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Roles del Asistente *</label>
                            <div class="checkbox-group">
                                <input type="checkbox" id="rolEsJuez" name="esJuez" value="1">
                                <label for="rolEsJuez" class="checkbox-label">Es Juez</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" id="rolEsEntrenador" name="esEntrenador" value="1">
                                <label for="rolEsEntrenador" class="checkbox-label">Es Entrenador</label>
                            </div>
                            <small class="field-info">Puede seleccionar uno o ambos roles.</small>
                        </div>
                        <div class="form-group" id="gradoEstudiosGroup" style="display: none;">
                            <label for="gradoEstudios">Grado de Estudios (Solo Jueces) *</label>
                            <select id="gradoEstudios" name="gradoEstudios">
                                <option value="">Seleccionar nivel...</option>
                                <option value="Licenciatura/Ingeniería (Pasante)">Licenciatura/Ingeniería (Pasante)</option>
                                <option value="Licenciatura/Ingeniería (Titulado)">Licenciatura/Ingeniería (Titulado)</option>
                                <option value="Especialidad">Especialidad</option>
                                <option value="Maestría">Maestría</option>
                                <option value="Doctorado">Doctorado</option>
                                <option value="Post-Doctorado">Post-Doctorado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="escuelaAsistente">Escuela del Asistente *</label>
                            <select id="escuelaAsistente" name="escuelaAsistente" required>
                                <option value="">Seleccionar escuela</option>
                            </select>
                            <small class="field-info">Para jueces: escuela de procedencia. Para entrenadores: escuela a la que representan.</small>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">Guardar Asistente</button>
                    <small class="field-info" style="margin-top: 15px;">La contraseña inicial del asistente será su **Apellido Paterno**.</small>
                </form>
            </div>
            <div class="form-section" id="asignar-jueces">
                <h2>Asignar Equipos a Jueces</h2>
                <form id="juez-asignacion-form">
                    <div id="asignar-jueces-container">
                        <div class="form-group">
                            <label for="select-juez-asignar">1. Seleccione un Juez</label>
                            <select id="select-juez-asignar" name="idJuez" required>
                                <option value="">-- Jueces Disponibles --</option>
                            </select>
                            <small id="juez-escuela-info" class="field-info"></small>
                        </div>
                        <div class="form-group">
                            <label for="select-equipos-asignar">2. Asigne Equipos (Ctrl+Click para varios)</label>
                            <select id="select-equipos-asignar" name="idEquipos" multiple required>
                                <option disabled>Seleccione un juez primero...</option>
                            </select>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn-primary">Guardar Asignaciones</button>
                    </div>
                </form>
            </div>

            <div class="form-section" id="reporte-general">
                <h2>Reporte General de Equipos</h2>
                <div id="reporte-general-container">
                    <p>Cargando reporte...</p>
                </div>
            </div>

            <div id="entrenador-modal" class="modal-overlay">
                <div class="modal-content">
                    <h2 id="modal-titulo-equipo">Asignar Entrenador</h2>
                    <form id="modal-entrenador-form">
                        <input type="hidden" id="modal-equipo-id" name="idEquipo">
                        
                        <div class="form-group">
                            <label for="modal-entrenador-select">Seleccionar Entrenador</label>
                            <select id="modal-entrenador-select" name="idEntrenador">
                                <option value="">-- Quitar Asignación --</option>
                            </select>
                        </div>
                        
                        <div class="btn-group" style="margin-top: 20px;">
                            <button type="submit" class="btn-primary">Guardar Cambios</button>
                            <button type="button" class="btn-secondary" id="modal-cerrar-btn">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="admin_dashboard.js" defer></script>

</body>
</html>