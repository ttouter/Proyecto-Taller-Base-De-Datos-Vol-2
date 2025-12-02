<?php
require_once __DIR__ . '/../config/conexion.php';

class Usuario {
    
    // Método estático para registrar usuario
    public static function registrar($datos) {
        // Usamos global para acceder a la conexión definida en conexion.php
        global $pdo;

        try {
            // 1. Verificamos que la conexión exista antes de usarla
            if (!$pdo) {
                throw new Exception("No hay conexión a la base de datos.");
            }

            // 2. Preparamos la consulta llamando al Procedimiento Almacenado
            // Nota: Asegúrate que el SP acepte exactamente estos parámetros en este orden
            $sql = "CALL AltaAsistente(:nombre, :apellidoPat, :apellidoMat, :sexo, :email, :password, @mensaje)";
            
            $stmt = $pdo->prepare($sql);
            
            // 3. Ejecutamos pasando los valores y encriptando la contraseña al vuelo
            // Usamos null coalescing (??) para evitar el error "Undefined array key" si falta algún dato
            $stmt->execute([
                ':nombre'      => $datos['nombre'] ?? '',
                ':apellidoPat' => $datos['ap_paterno'] ?? '',
                ':apellidoMat' => $datos['ap_materno'] ?? '',
                ':sexo'        => $datos['sexo'] ?? '',
                ':email'       => $datos['email'] ?? '',
                ':password'    => password_hash($datos['password'], PASSWORD_DEFAULT)
            ]);

            // 4. Recuperamos el mensaje de salida (OUT parameter) del SP
            $stmt->closeCursor(); // Buena práctica: liberar el puntero antes de la siguiente consulta
            $result = $pdo->query("SELECT @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);

            return $result['mensaje'];

        } catch (PDOException $e) {
            // Error específico de Base de Datos
            return "Error en BD: " . $e->getMessage();
        } catch (Exception $e) {
            // Error general
            return "Error: " . $e->getMessage();
        }
    }
}
?>