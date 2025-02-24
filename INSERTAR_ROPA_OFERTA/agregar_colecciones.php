<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

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
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 80%;
            margin: 30px auto;
            background: #fffaf0;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border: 2px solid #f4a261;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            color: #264653;
            margin-bottom: 30px;
            font-size: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #6b705c;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select,
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #b7b7a4;
            border-radius: 8px;
            font-size: 16px;
            background-color: #fefae0;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        select:focus,
        input[type="number"]:focus,
        input[type="file"]:focus {
            border-color: #e76f51;
            outline: none;
            background-color: #ffffff;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: #2a9d8f;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #264653;
            transform: scale(1.02);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        /* Para pantallas más pequeñas */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <form name="insert_prenda" action="" method="POST" enctype="multipart/form-data">
        <h2>Insertar Coleccion Nueva </h2>

        <div class="form-row">
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
