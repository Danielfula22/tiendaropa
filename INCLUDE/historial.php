<?php
session_start();
require '../CONEXION/CONEXION_BASE_DE_DATOS.PHP';

if (!isset($conexion)) {
    die("Error de conexión a la base de datos.");
}

if (!isset($_SESSION['ID_Usuario'])) {
    die("Acceso denegado. Debes iniciar sesión.");
}

$id_usuario = $_SESSION['ID_Usuario'];
$sql = "SELECT Nombre, Cedula, Total, ID_Compra FROM compras WHERE ID_Usuario = ? ORDER BY ID_Compra DESC";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f9f9f9;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            max-width: 600px;
            margin: auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 8px 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        .close-btn {
            margin-top: 20px;
            padding: 8px 12px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Historial de Facturas</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Total</th>
            <th>Factura</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['Cedula']); ?></td>
            <td><?php echo htmlspecialchars($row['Total']); ?></td>
            <td>
                <a href="../FACTURACION/pdf.php?compra=<?php echo $row['ID_Compra']; ?>">
                    <img src="../IMAGENES/pdf.png" alt="pdf" width="30" height="30">
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <button class="close-btn" onclick="window.close()">Cerrar</button>

    <?php
    $stmt->close();
    $conexion->close();
    ?>
</body>
</html>






