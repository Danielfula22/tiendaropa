<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_VENDEDOR.PHP");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Insertar datos en la tabla proveedor
    $SQL = "INSERT INTO proveedor (Nombre, Telefono, Correo) 
            VALUES ('$nombre', '$telefono', '$correo')";
    $RESULT = mysqli_query($conexion, $SQL) or die(mysqli_error($conexion));

    // Mostrar una alerta de registro exitoso y redirigir
    if ($RESULT) {
        echo "<script>alert('Proveedor registrado exitosamente'); window.location.href='../OTRO_VENDEDOR/PROVEEDORES.PHP';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proveedor</title>
    <link rel="stylesheet" href="../CSS/update.css">
</head>
<body>

<div class="form-container">
    <form name="insert_proveedor" action="" method="POST">
        <h2> Insertar Nuevo Proveedor </h2>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" required>
        </div>

        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" required>
        </div>

        <div class="form-group">
            <input type="submit" name="ENVIAR" value="Guardar" class="btn-submit">
        </div>
    </form>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>

<?php
ob_end_flush(); // Cierra el buffer de salida
?>
