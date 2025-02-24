<?php
ob_start();
include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_pedido = intval($_GET['id']); // Asegura que el ID sea un número

    // Consultar datos del pedido
    $sql_pedido = "SELECT * FROM pedido WHERE ID_Pedido = ?";
    $stmt = mysqli_prepare($conexion, $sql_pedido);
    mysqli_stmt_bind_param($stmt, "i", $id_pedido); // Vinculamos el parámetro como entero
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $pedido = mysqli_fetch_assoc($resultado);

    if (!$pedido) {
        echo "<script>alert('Pedido no encontrado'); window.location.href='LISTA_PEDIDOS.PHP';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de pedido no válido'); window.location.href='LISTA_PEDIDOS.PHP';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['Fecha'];
    $estado = $_POST['Estado'];
    $id_entrega = $_POST['ID_Entrega'];

    // Actualizar datos del pedido usando una consulta preparada
    $sql_update = "UPDATE pedido SET 
                    Fecha=?, 
                    Estado=?, 
                    ID_Entrega=? 
                    WHERE ID_Pedido=?";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssii", $fecha, $estado, $id_entrega, $id_pedido); // Vinculamos los parámetros

    if (mysqli_stmt_execute($stmt_update)) {
        echo "<script>alert('Pedido actualizado exitosamente'); window.location.href='../PEDIDOS/PEDIDOS.PHP';</script>";
    } else {
        echo "<script>alert('Error al actualizar el pedido'); window.location.href='LISTA_PEDIDOS.PHP';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Pedido</title>
    <link rel="stylesheet" href="../CSS/update.css">
</head>
<body>
<div class="form-container">
    <form action="" method="POST">
        <h2>Actualizar Pedido</h2>

        <label>Fecha:</label>
        <input type="date" name="Fecha" value="<?php echo htmlspecialchars($pedido['Fecha']); ?>" required>

        <label>Estado:</label>
        <input type="text" name="Estado" value="<?php echo htmlspecialchars($pedido['Estado']); ?>" required>

        <label>ID Entrega:</label>
        <input type="text" name="ID_Entrega" value="<?php echo htmlspecialchars($pedido['ID_Entrega']); ?>" required>

        <input type="submit" value="Actualizar">
    </form>
</div>
<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
