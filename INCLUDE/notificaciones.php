<?php
session_start();
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');


error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Error: El usuario no está autenticado.");
} else {
    echo "ID de usuario: " . $_SESSION['user_id'];
}


$user_id = $_SESSION['user_id'] ?? null; // Evitar error si la sesión no está iniciada

$notificaciones = []; // Inicializar la variable para evitar errores

if ($user_id) {
    // Consulta para obtener las notificaciones no leídas del usuario
    $query = "SELECT ID_Notificacion, mensaje, fecha FROM notificaciones WHERE ID_Usuario = ? AND estado = 0 ORDER BY fecha DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $notificaciones[] = $row;
    }

    $stmt->close();
}

$conn->close();
?>

