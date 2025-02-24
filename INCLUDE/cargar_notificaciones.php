<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda de ropa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Verificar que el usuario esté en sesión
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// CONSULTA MEJORADA
$sql = "SELECT ID_Notificacion, mensaje FROM notificaciones WHERE ID_Usuario = ? ORDER BY ID_Notificacion DESC LIMIT 10";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$notificaciones = [];
while ($row = $result->fetch_assoc()) {
    $notificaciones[] = [
        "id" => $row["ID_Notificacion"],
        "mensaje" => $row["mensaje"]
    ];
}

$stmt->close();
$conn->close();

echo json_encode($notificaciones);
?>
