<?php
ob_start();
include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_VENDEDOR.PHP");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_proveedor = intval($_GET['id']); // Asegura que el ID sea un número

    // Consultar datos del proveedor
    $sql_proveedor = "SELECT * FROM proveedor WHERE ID_Proveedor = ?";
    $stmt = mysqli_prepare($conexion, $sql_proveedor);
    mysqli_stmt_bind_param($stmt, "i", $id_proveedor); // Vinculamos el parámetro como entero
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $proveedor = mysqli_fetch_assoc($resultado);

    if (!$proveedor) {
        echo "<script>alert('Proveedor no encontrado'); window.location.href='LISTA_PROVEEDORES.PHP';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de proveedor no válido'); window.location.href='LISTA_PROVEEDORES.PHP';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['Nombre'];
    $telefono = $_POST['Telefono'];
    $correo = $_POST['Correo'];

    // Actualizar datos del proveedor usando una consulta preparada
    $sql_update = "UPDATE proveedor SET 
                    Nombre=?, 
                    Telefono=?, 
                    Correo=? 
                    WHERE ID_Proveedor=?";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "sssi", $nombre, $telefono, $correo, $id_proveedor); // Vinculamos los parámetros

    if (mysqli_stmt_execute($stmt_update)) {
        // Manejar la subida de la foto solo si se proporciona una nueva
        if ($_FILES['foto']['tmp_name']) {
            $destino = "../IMAGENES/proveedores/" . $id_proveedor . ".jpg";
            move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
        }
        echo "<script>alert('Proveedor actualizado exitosamente'); window.location.href='../OTRO_VENDEDOR/PROVEEDORES.PHP';</script>";
    } else {
        echo "<script>alert('Error al actualizar proveedor'); window.location.href='LISTA_PROVEEDORES.PHP';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Proveedor</title>
    <link rel="stylesheet" href="../CSS/update.css">
</head>
<body>
<div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Actualizar Proveedor</h2>

        <label>Nombre:</label>
        <input type="text" name="Nombre" value="<?php echo htmlspecialchars($proveedor['Nombre']); ?>" required>

        <label>Teléfono:</label>
        <input type="text" name="Telefono" value="<?php echo htmlspecialchars($proveedor['Telefono']); ?>" required>

        <label>Correo:</label>
        <input type="email" name="Correo" value="<?php echo htmlspecialchars($proveedor['Correo']); ?>" required>

        

        <input type="submit" value="Actualizar">
    </form>
</div>
<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
