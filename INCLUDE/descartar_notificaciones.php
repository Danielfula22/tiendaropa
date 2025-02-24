<?php
session_start();
include '../CONEXION/CONEXION_BASE_DE_DATOS.PHP'; // Asegúrate de que este archivo contiene la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'descartar') {
    try {
        // Suponiendo que las notificaciones están en una tabla llamada 'notificaciones'
        $sql = "DELETE FROM notificaciones WHERE usuario_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['usuario_id']]);

        echo "success";
    } catch (Exception $e) {
        echo "error";
    }
} else {
    echo "invalid_request";
}
?>
des
