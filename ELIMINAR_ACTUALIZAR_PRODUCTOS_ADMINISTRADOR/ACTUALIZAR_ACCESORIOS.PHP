<?php
ob_start();
include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

// Verificar que el ID del accesorio es válido y es un número entero
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id_accesorio = $_GET['id'];

    // Consultar datos del accesorio
    $sql_accesorio = "SELECT * FROM accesorio WHERE ID_Accesorio = $id_accesorio";
    $resultado = mysqli_query($conexion, $sql_accesorio);
    
    if (mysqli_num_rows($resultado) == 0) {
        echo "<script>alert('Accesorio no encontrado'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
        exit();
    }

    $accesorio = mysqli_fetch_assoc($resultado);
} else {
    echo "<script>alert('ID de accesorio no válido'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['Nombre'];
    $costo = $_POST['Costo'];
    $stock = $_POST['Stock'];
    $descripcion = $_POST['Descripcion'];
    $id_tipo_accesorio = $_POST['ID_Tipo_accesorio'];
    $id_proveedor = $_POST['ID_Proveedor'];

    // Actualizar datos del accesorio sin la foto primero
    $sql_update = "UPDATE accesorio SET 
                    Nombre='$nombre', 
                    Costo='$costo', 
                    Stock='$stock', 
                    Descripcion='$descripcion',
                    ID_Tipo_accesorio='$id_tipo_accesorio',
                    ID_Proveedor='$id_proveedor'
                    WHERE ID_Accesorio=$id_accesorio";

    if (mysqli_query($conexion, $sql_update)) {
        // Manejar la subida de la foto solo si se proporciona una nueva
        if (!empty($_FILES['foto']['tmp_name'])) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $destino = "../IMAGENES/" . $id_accesorio . "." . $ext;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $sql_update_foto = "UPDATE accesorio SET Foto='$destino' WHERE ID_Accesorio=$id_accesorio";
                mysqli_query($conexion, $sql_update_foto);
            }
        }
        echo "<script>alert('Accesorio actualizado exitosamente'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    } else {
        echo "<script>alert('Error al actualizar accesorio'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Accesorio</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        /* Contenedor del formulario */
        .form-container {
            max-width: 90%;
            margin: 30px auto;
            background: #fffaf0;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border: 2px solid #f4a261;
            animation: fadeIn 1s ease-out;
        }

        /* Animación */
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #6b705c;
            font-size: 16px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #b7b7a4;
            border-radius: 8px;
            font-size: 16px;
            background-color: #fefae0;
            transition: all 0.3s ease;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #2a9d8f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            grid-column: span 2;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #264653;
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    
<div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Actualizar Accesorio</h2>
        <div class="form-grid">
            <div>
                <label for="Nombre">Nombre:</label>
                <input type="text" name="Nombre" value="<?php echo htmlspecialchars($accesorio['Nombre']); ?>" required>
            </div>
            <div>
                <label for="Costo">Costo:</label>
                <input type="number" name="Costo" step="0.01" value="<?php echo htmlspecialchars($accesorio['Costo']); ?>" required>
            </div>
            <div>
                <label for="Stock">Stock:</label>
                <input type="number" name="Stock" value="<?php echo htmlspecialchars($accesorio['Stock']); ?>" required>
            </div>
          
            <div>
                <label for="Descripcion">Descripción:</label>
                <textarea name="Descripcion" required><?php echo htmlspecialchars($accesorio['Descripcion']); ?></textarea>
            </div>
            <div>
                <label for="ID_Tipo_accesorio">Tipo de Accesorio:</label>
                <select name="ID_Tipo_accesorio" required>
                    <?php
                    $sql_tipo = "SELECT ID_Tipo_accesorio, Nombre FROM tipo_accesorio";
                    $resultado_tipo = mysqli_query($conexion, $sql_tipo);
                    while ($tipo = mysqli_fetch_assoc($resultado_tipo)) {
                        $selected = ($accesorio['ID_Tipo_accesorio'] == $tipo['ID_Tipo_accesorio']) ? 'selected' : '';
                        echo "<option value='{$tipo['ID_Tipo_accesorio']}' $selected>{$tipo['Nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="ID_Proveedor">Proveedor:</label>
                <select name="ID_Proveedor" required>
                    <?php
                    $sql_proveedor = "SELECT ID_Proveedor, Nombre FROM proveedor";
                    $resultado_proveedor = mysqli_query($conexion, $sql_proveedor);
                    while ($proveedor = mysqli_fetch_assoc($resultado_proveedor)) {
                        $selected = ($accesorio['ID_Proveedor'] == $proveedor['ID_Proveedor']) ? 'selected' : '';
                        echo "<option value='{$proveedor['ID_Proveedor']}' $selected>{$proveedor['Nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="foto">Actualizar Foto:</label>
                <input type="file" name="foto">
            </div>
            <div>
                <input type="submit" value="Actualizar">
            </div>
        </div>
    </form>
</div>
<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
<?php
ob_end_flush();
?>
