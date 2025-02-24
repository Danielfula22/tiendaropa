<?php
// Incluir el archivo de conexión a la base de datos
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar si la conexión se ha establecido correctamente
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Obtener el ID del tipo de prenda desde la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_tipo_prenda = intval($_GET['id']);

    // Consulta para obtener los datos del tipo de prenda
    $consultaTipoPrenda = "SELECT * FROM tipo_prenda WHERE ID_Tipo_prenda = ?";
    $stmt = mysqli_prepare($conexion, $consultaTipoPrenda);
    mysqli_stmt_bind_param($stmt, "i", $id_tipo_prenda);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $tipoPrenda = mysqli_fetch_assoc($resultado);

    if (!$tipoPrenda) {
        echo "<script>alert('Tipo de prenda no encontrado'); window.location.href='LISTA_TIPOS_PRENDA.PHP';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de tipo de prenda no válido'); window.location.href='LISTA_TIPOS_PRENDA.PHP';</script>";
    exit();
}

// Procesar el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['Nombre'];
    $foto = $_FILES['Foto']['name'];

    // Si se ha subido una nueva foto
    if ($foto) {
        // Obtener la extensión del archivo
        $ext = pathinfo($foto, PATHINFO_EXTENSION);
        
        // Validar si la extensión es una imagen válida (puedes agregar más extensiones si es necesario)
        $ext = strtolower($ext);
        $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $extensionesValidas)) {
            echo "<script>alert('Extensión de imagen no válida'); window.location.href='LISTA_TIPOS_PRENDA.PHP';</script>";
            exit();
        }

        // Definir el directorio de destino y mover la foto con su extensión
        $directorioDestino = '../IMAGENES/';
        $archivoDestino = $directorioDestino . basename($nombre . '.' . $ext);  // Usamos el nombre + la extensión

        // Mover la imagen a la carpeta de destino
        if (move_uploaded_file($_FILES['Foto']['tmp_name'], $archivoDestino)) {
            echo "<script>alert('Foto actualizada correctamente');</script>";
        } else {
            echo "<script>alert('Error al subir la foto');</script>";
        }
    } else {
        // Si no se sube una nueva foto, conservar la foto anterior
        $archivoDestino = $tipoPrenda['Foto'];
    }

    // Actualizar el tipo de prenda en la base de datos
    $sql_update = "UPDATE tipo_prenda SET Nombre = ?, Foto = ? WHERE ID_Tipo_prenda = ?";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssi", $nombre, $archivoDestino, $id_tipo_prenda);

    if (mysqli_stmt_execute($stmt_update)) {
        echo "<script>alert('Tipo de prenda actualizado exitosamente'); window.location.href='../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/PRODUCTOS.PHP';</script>";
    } else {
        echo "<script>alert('Error al actualizar el tipo de prenda'); window.location.href='LISTA_TIPOS_PRENDA.PHP';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Tipo de Prenda</title>
    <link rel="stylesheet" href="../ESTILOS/responsiva.css">
    <link rel="stylesheet" href="../ESTILOS/TABLA_ADMINISTRADOR.CSS">
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

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
        input[type="file"]:focus {
            border-color: #e76f51;
            outline: none;
            background-color: #ffffff;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #2a9d8f;
            color: #ffffff;
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

        .full-width {
            grid-column: span 2;
        }

        .current-image {
            text-align: center;
            margin-top: 10px;
        }

        .current-image img {
            max-width: 100px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>

<div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Actualizar Tipo de Prenda</h2>
        <div class="form-grid">
            <div>
                <label for="Nombre">Nombre del tipo de prenda:</label>
                <input type="text" name="Nombre" value="<?php echo htmlspecialchars($tipoPrenda['Nombre']); ?>" required>
            </div>

            <div>
                <label for="Foto">Actualizar Foto:</label>
                <input type="file" name="Foto" accept="image/*">
            </div>

            <div class="current-image">
                <label>Foto Actual:</label>
                <img src="../IMAGENES/<?php echo htmlspecialchars($tipoPrenda['Foto']); ?>" alt="Foto Actual">
            </div>

            <div class="full-width">
                <input type="submit" value="Actualizar">
            </div>
        </div>
    </form>
</div>

<?php include('../INCLUDE/FOOTER.PHP'); ?>

</body>
</html>
