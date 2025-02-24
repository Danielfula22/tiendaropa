<?php
ob_start();
include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

// Verificar que el ID de la prenda es válido y es un número entero
if (isset($_GET['ID']) && filter_var($_GET['ID'], FILTER_VALIDATE_INT)) {
    $id_prenda = $_GET['ID'];

    // Consultar datos de la prenda
    $sql_prenda = "SELECT * FROM prenda WHERE ID_Prenda = $id_prenda";
    $resultado = mysqli_query($conexion, $sql_prenda);

    // Comprobar si se encontró la prenda
    if (mysqli_num_rows($resultado) == 0) {
        echo "<script>alert('Prenda no encontrada'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
        exit();
    }

    // Obtener los datos de la prenda
    $prenda = mysqli_fetch_assoc($resultado);
} else {
    echo "<script>alert('ID de prenda no válido'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['Nombre'];
    $color = $_POST['Color'];
    $talla = $_POST['Talla'];
    $costo = $_POST['Costo'];
    $stock = $_POST['Stock'];
    $foto = $_FILES['foto'];

    // Actualizar datos de la prenda
    $sql_update = "UPDATE prenda SET 
                    Nombre='$nombre', 
                    Color='$color', 
                    Talla='$talla', 
                    Costo='$costo', 
                    Stock='$stock' 
                    WHERE ID_Prenda=$id_prenda";

    if (mysqli_query($conexion, $sql_update)) {
        // Manejar la subida de la foto solo si se proporciona una nueva
        if ($foto['tmp_name']) {
            $destino = "../IMAGENES/" . $id_prenda . ".jpg";
            move_uploaded_file($foto['tmp_name'], $destino);

            // Actualizar la ruta de la foto en la base de datos
            $sql_update_foto = "UPDATE prenda SET Foto='$destino' WHERE ID_Prenda=$id_prenda";
            mysqli_query($conexion, $sql_update_foto);
        }
        echo "<script>alert('Prenda actualizada exitosamente'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    } else {
        echo "<script>alert('Error al actualizar prenda'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Prenda</title>
    <style>
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

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <form name="update_prenda" action="" method="POST" enctype="multipart/form-data">
        <h2>Actualizar Coleccion</h2>

        <div class="form-row">
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" name="Nombre" value="<?php echo $prenda['Nombre']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Color">Color:</label>
                <input type="text" name="Color" value="<?php echo $prenda['Color']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Talla">Talla:</label>
                <select name="Talla" required>
                    <option value="XS" <?php echo ($prenda['Talla'] == 'XS') ? 'selected' : ''; ?>>XS</option>
                    <option value="S" <?php echo ($prenda['Talla'] == 'S') ? 'selected' : ''; ?>>S</option>
                    <option value="M" <?php echo ($prenda['Talla'] == 'M') ? 'selected' : ''; ?>>M</option>
                    <option value="L" <?php echo ($prenda['Talla'] == 'L') ? 'selected' : ''; ?>>L</option>
                    <option value="XL" <?php echo ($prenda['Talla'] == 'XL') ? 'selected' : ''; ?>>XL</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Costo">Costo:</label>
                <input type="number" step="0.01" name="Costo" value="<?php echo $prenda['Costo']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Stock">Stock:</label>
                <select name="Stock" required>
                    <option value="Disponible" <?php echo ($prenda['Stock'] == 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                    <option value="Agotado" <?php echo ($prenda['Stock'] == 'Agotado') ? 'selected' : ''; ?>>Agotado</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Actualizar Foto:</label>
                <input type="file" name="foto">
            </div>
        </div>

        <div class="form-group">
            <input type="submit" value="Actualizar" class="btn-submit">
        </div>
    </form>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>

</body>
</html>

<?php
ob_end_flush();
?>
