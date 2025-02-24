<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "tienda de ropa";

// Conectar a la base de datos
$conn = new mysqli($servidor, $usuario, $password, $base_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Marcar todas las notificaciones como leídas (estado = 1)
$sql = "UPDATE notificaciones SET estado = 1";
if ($conn->query($sql)) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>
