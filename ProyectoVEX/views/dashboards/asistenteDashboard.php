<?php
session_start(); 

// Validar sesión
if (!isset($_SESSION['asistente_logged_in']) || $_SESSION['asistente_logged_in'] !== true) {
    header('Location: ../login/inicioSesion_entrenador.php');
    exit;
}

// =========================================================
// NUEVO: Importar modelo y cargar listas para los selects
// =========================================================
require_once '../../models/ModeloProcesos.php';

// Obtener lista de escuelas desde la BD (usando el SP ListarEscuelas)
$listaEscuelas = ModeloProcesos::listarEscuelas();

// Obtener lista de eventos desde la BD (usando el SP ListarEventos)
$listaEventos = ModeloProcesos::listarEventos();

$nombre_asistente = htmlspecialchars($_SESSION['asistente_nombre']);
$id_asistente = $_SESSION['asistente_id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Entrenador - VEX Robotics</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/fav-robot.ico">
    <link rel="stylesheet" href="../../assets/css/styles_asistenteDashboard.css">
</head>
<body>

<div class="dashboard-container">

    <!-- ====================== NAV / SIDEBAR ====================== -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h2>VEX Robotics</h2>
            <p>Panel del Entrenador</p>
        </div>

        <ul class="sidebar-menu">
            <li><a href="#completar-registro" class="active">Completar Registro</a></li>
            <li><a href="#registro-equipo">Registrar Equipo</a></li>
            <li><a href="#registro-participantes">Registrar Participantes</a></li>
            <li><a href="../login/terminarSesion_asistente.php" class="logout">Cerrar Sesión</a></li>
        </ul>
    </nav>


    <!-- ====================== CONTENIDO PRINCIPAL ====================== -->
    <main class="main-content">

        <header class="content-header">
            <h1>Bienvenido, <?php echo $nombre_asistente; ?></h1>
        </header>


        <!-- ========================================================= -->
        <!-- =========== 1. COMPLETAR REGISTRO ENTRENADOR ============ -->
        <!-- ========================================================= -->
        <section class="form-section" id="completar-registro">
            <h2>Completar registro como Entrenador</h2>

            <form action="../../controllers/control_completarEntrenador.php" method="POST">
                <input type="hidden" name="idAsistente" value="<?php echo $id_asistente; ?>">

                <div class="form-group">
                    <label for="codEscuela">Escuela de procedencia *</label>
                    
                    <!-- CAMBIO: Select dinámico de Escuelas -->
                    <select name="codEscuela" id="codEscuela" required>
                        <option value="">-- Seleccione su escuela --</option>
                        <?php if (!empty($listaEscuelas)): ?>
                            <?php foreach ($listaEscuelas as $escuela): ?>
                                <option value="<?php echo htmlspecialchars($escuela['codEscuela']); ?>">
                                    <?php echo htmlspecialchars($escuela['nombreEscuela']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No hay escuelas registradas</option>
                        <?php endif; ?>
                    </select>
                </div>

                <button type="submit" class="btn-primary">Guardar Información</button>
            </form>
        </section>


        <!-- ========================================================= -->
        <!-- =============== 2. REGISTRO DE EQUIPOS ================== -->
        <!-- ========================================================= -->
        <section class="form-section" id="registro-equipo">
            <h2>Registrar Equipo</h2>

            <form action="../../controllers/control_registrarEquipo.php" method="POST">

                <input type="hidden" name="idAsistente" value="<?php echo $id_asistente; ?>">

                <div class="form-row">

                    <div class="form-group">
                        <label for="nombreEquipo">Nombre del equipo *</label>
                        <input type="text" id="nombreEquipo" name="nombreEquipo" required>
                    </div>

                    <div class="form-group">
                        <label for="categoria">Categoría *</label>
                        <select id="categoria" name="idCategoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="1">Primaria</option>
                            <option value="2">Secundaria</option>
                            <option value="3">Preparatoria</option>
                            <option value="4">Universidad</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="evento">Evento *</label>
                        
                        <!-- CAMBIO: Select dinámico de Eventos -->
                        <select id="evento" name="evento" required>
                            <option value="">-- Seleccione el evento --</option>
                            <?php if (!empty($listaEventos)): ?>
                                <?php foreach ($listaEventos as $evento): ?>
                                    <!-- El value es el nombre porque tu tabla Equipo usa nombre_Evento como FK -->
                                    <option value="<?php echo htmlspecialchars($evento['nombre']); ?>">
                                        <?php echo htmlspecialchars($evento['nombre']) . " (" . $evento['fecha'] . ")"; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No hay eventos disponibles</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="escuelaEquipo">Escuela del equipo *</label>
                        
                        <!-- CAMBIO: Select dinámico de Escuelas (Reutilizamos la lista) -->
                        <select id="escuelaEquipo" name="codEscuela" required>
                            <option value="">-- Seleccione la escuela --</option>
                            <?php if (!empty($listaEscuelas)): ?>
                                <?php foreach ($listaEscuelas as $escuela): ?>
                                    <option value="<?php echo htmlspecialchars($escuela['codEscuela']); ?>">
                                        <?php echo htmlspecialchars($escuela['nombreEscuela']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No hay escuelas registradas</option>
                            <?php endif; ?>
                        </select>
                    </div>

                </div>

                <button type="submit" class="btn-primary">Registrar Equipo</button>
            </form>
        </section>


        <!-- ========================================================= -->
        <!-- ============= 3. REGISTRAR PARTICIPANTES =============== -->
        <!-- ========================================================= -->
        <section class="form-section" id="registro-participantes">
            <h2>Registrar Participantes</h2>

            <form action="../../controllers/control_registrarParticipante.php" method="POST">

                <div class="form-row">

                    <div class="form-group">
                        <label for="numControl">Número de control *</label>
                        <input type="number" name="numControl" id="numControl" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="apellidoPat">Apellido Paterno *</label>
                        <input type="text" name="apellidoPat" id="apellidoPat" required>
                    </div>

                    <div class="form-group">
                        <label for="apellidoMat">Apellido Materno *</label>
                        <input type="text" name="apellidoMat" id="apellidoMat" required>
                    </div>

                    <div class="form-group">
                        <label for="edad">Edad *</label>
                        <input type="number" name="edad" id="edad" required>
                    </div>

                    <div class="form-group">
                        <label for="sexo">Sexo *</label>
                        <select name="sexo" id="sexo" required>
                            <option value="">Seleccione</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="equipo">ID del equipo *</label>
                        <!-- NOTA: Idealmente esto también debería ser un Select cargado con los equipos del entrenador -->
                        <input type="number" name="idEquipo" id="equipo" placeholder="ID generado al registrar equipo" required>
                    </div>

                </div>

                <button type="submit" class="btn-primary">Registrar Participante</button>

            </form>
        </section>

    </main>
</div>

</body>
</html>