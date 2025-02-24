<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_VENDEDOR.PHP");

// Verificar si la tabla 'tipo_accesorio' existe y crearla si no existe
$checkTableQuery = "SHOW TABLES LIKE 'tipo_accesorio'";
$tableExists = mysqli_query($conexion, $checkTableQuery);

if (mysqli_num_rows($tableExists) == 0) {
    // Crear la tabla si no existe
    $createTableSQL = "
        CREATE TABLE tipo_accesorio (
            ID_Tipo_accesorio INT AUTO_INCREMENT PRIMARY KEY,
            Nombre VARCHAR(50) NOT NULL
        );
    ";
    if (!mysqli_query($conexion, $createTableSQL)) {
        die("Error al crear la tabla 'tipo_accesorio': " . mysqli_error($conexion));
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_tipo_accesorio = mysqli_real_escape_string($conexion, $_POST['nombre_tipo_accesorio']);

    // Insertar datos en la tabla 'tipo_accesorio'
    $SQL = "INSERT INTO tipo_accesorio (Nombre) VALUES ('$nombre_tipo_accesorio')";
    $RESULT = mysqli_query($conexion, $SQL);

    // Mostrar una alerta de registro exitoso y redirigir
    if ($RESULT) {
        echo "<script>alert('Tipo de accesorio registrado exitosamente'); window.location.href='../OTRO_VENDEDOR/PRODUCTOS.PHP';</script>";
        exit();
    } else {
        die("Error al registrar el tipo de accesorio: " . mysqli_error($conexion));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Tipo de Accesorio</title>
    <link rel="stylesheet" href="../CSS/update.css">
</head>
<body>

<div class="form-container">
    <form name="insert_tipo_accesorio" action="" method="POST">
        <h2> Insertar Nuevo Tipo de Accesorio </h2>

        <div class="form-group">
            <label for="nombre_tipo_accesorio">Nombre del Tipo de Accesorio:</label>
            <input type="text" name="nombre_tipo_accesorio" required>
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
