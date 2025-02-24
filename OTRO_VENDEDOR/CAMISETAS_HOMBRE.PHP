<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_VENDEDOR.PHP");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $color = $_POST['color'];
    $talla = $_POST['talla'];
    $costo = $_POST['costo'];
    $stock = $_POST['stock'];
    $id_tipo_prenda = $_POST['id_tipo_prenda'];
    $id_proveedor = $_POST['id_proveedor'];
    $foto = $_FILES['foto'];

    // Insertar datos en la tabla prenda sin la ruta de la foto
    $SQL = "INSERT INTO prenda (Nombre, Color, Talla, Costo, Stock, ID_Tipo_prenda, ID_Proveedor, Foto) 
            VALUES ('$nombre', '$color', '$talla', $costo, '$stock', $id_tipo_prenda, $id_proveedor, '')";
    $RESULT = mysqli_query($conexion, $SQL) or die(mysqli_error($conexion));

    // Manejar la subida de la foto si la inserción fue exitosa
    if ($RESULT) {
        $ID_Prenda = mysqli_insert_id($conexion);
        $DESTINO = "../IMAGENES/" . $ID_Prenda . ".jpg";
        $ARCHIVO = $_FILES['foto']['tmp_name'];
        
        // Mueve el archivo a la carpeta de destino
        if (move_uploaded_file($ARCHIVO, $DESTINO)) {
            // Actualiza la ubicación de la foto en la base de datos
            $SQL_UPDATE = "UPDATE prenda SET Foto='$DESTINO' WHERE ID_Prenda=$ID_Prenda";
            mysqli_query($conexion, $SQL_UPDATE) or die(mysqli_error($conexion));
        }

        // Mostrar una alerta de registro exitoso y redirigir a la página anterior
        echo "<script>alert('Registro exitoso'); window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Prenda</title>
    <link rel="stylesheet" href="../CSS/update.css">
</head>
<body>

<div class="form-container">
    <form name="insert_prenda" action="" method="POST" enctype="multipart/form-data">
        <h2> Insertar Nueva Prenda </h2>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" name="color" required>
        </div>

        <div class="form-group">
            <label for="talla">Talla:</label>
            <select name="talla" required>
                <option value="">---</option>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
            </select>
        </div>

        <div class="form-group">
            <label for="costo">Costo:</label>
            <input type="number" step="0.01" name="costo" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock:</label>
            <select name="stock" required>
                <option value="Disponible">Disponible</option>
                <option value="Agotado">Agotado</option>
            </select>
        </div>

        <div class="form-group">
            <label for="id_tipo_prenda">Tipo de Prenda:</label>
            <select name="id_tipo_prenda" required>
                <option value="">Seleccione un tipo de prenda</option>
                <?php
                // Mostrar todos los tipos de prenda para elegir
                $sql_tipo_prenda = "SELECT ID_Tipo_prenda, Nombre FROM tipo_prenda";
                $result_tipo_prenda = mysqli_query($conexion, $sql_tipo_prenda);
                while ($row = mysqli_fetch_assoc($result_tipo_prenda)) {
                    echo "<option value='" . $row['ID_Tipo_prenda'] . "'>" . $row['Nombre'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_proveedor">Proveedor:</label>
            <select name="id_proveedor" required>
                <option value="">Seleccione un proveedor</option>
                <?php
                $sql_proveedor = "SELECT ID_Proveedor, Nombre FROM proveedor";
                $result_proveedor = mysqli_query($conexion, $sql_proveedor);
                while ($row = mysqli_fetch_assoc($result_proveedor)) {
                    echo "<option value='" . $row['ID_Proveedor'] . "'>" . $row['ID_Proveedor'] . " - " . $row['Nombre'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="foto">Adjuntar Foto:</label>
            <input type="file" name="foto" id="foto" required>
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
