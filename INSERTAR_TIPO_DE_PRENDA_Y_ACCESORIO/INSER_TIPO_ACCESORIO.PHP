<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

// Verificar si la tabla 'tipo_accesorio' existe y crearla si no existe
$checkTableQuery = "SHOW TABLES LIKE 'tipo_accesorio'";
$tableExists = mysqli_query($conexion, $checkTableQuery);

if (mysqli_num_rows($tableExists) == 0) {
    // Crear la tabla si no existe
    $createTableSQL = "
        CREATE TABLE tipo_accesorio (
            ID_Tipo_accesorio INT AUTO_INCREMENT PRIMARY KEY,
            Nombre VARCHAR(50) NOT NULL,
            Foto VARCHAR(255) NOT NULL
        );
    ";
    if (!mysqli_query($conexion, $createTableSQL)) {
        die("Error al crear la tabla 'tipo_accesorio': " . mysqli_error($conexion));
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_tipo_accesorio = mysqli_real_escape_string($conexion, $_POST['nombre_tipo_accesorio']);
    $foto = $_FILES['Foto']['name'];

    // Si se ha subido una nueva foto
    if ($foto) {
        // Obtener la extensión del archivo
        $ext = pathinfo($foto, PATHINFO_EXTENSION);

        // Validar si la extensión es una imagen válida
        $ext = strtolower($ext);
        $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $extensionesValidas)) {
            echo "<script>alert('Extensión de imagen no válida'); window.location.href='PRODUCTOS.PHP';</script>";
            exit();
        }

        // Definir el directorio de destino y mover la foto con su extensión
        $directorioDestino = '../IMAGENES/';
        $archivoDestino = $directorioDestino . basename($nombre_tipo_accesorio . '.' . $ext); // Usamos el nombre + la extensión

        // Mover la imagen a la carpeta de destino
        if (!move_uploaded_file($_FILES['Foto']['tmp_name'], $archivoDestino)) {
            echo "<script>alert('Error al subir la foto'); window.location.href='PRODUCTOS.PHP';</script>";
            exit();
        }
    } else {
        // Si no se sube una nueva foto, asignar un valor vacío
        $archivoDestino = '';
    }

    // Insertar datos en la tabla 'tipo_accesorio'
    $SQL = "INSERT INTO tipo_accesorio (Nombre, Foto) VALUES ('$nombre_tipo_accesorio', '$archivoDestino')";
    $RESULT = mysqli_query($conexion, $SQL);

    // Mostrar una alerta de registro exitoso y redirigir
    if ($RESULT) {
        echo "<script>alert('Tipo de accesorio registrado exitosamente'); window.location.href='../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/PRODUCTOS.PHP';</script>";
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
        }

        .btn-submit:hover {
            background-color: #264653;
            transform: scale(1.02);
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

<div class="form-container">
    <form name="insert_tipo_accesorio" action="" method="POST" enctype="multipart/form-data">
        <h2>Insertar Nuevo Tipo de Accesorio</h2>

        <div class="form-group">
            <label for="nombre_tipo_accesorio">Nombre del Tipo de Accesorio:</label>
            <input type="text" name="nombre_tipo_accesorio" required>
        </div>

        <div class="form-group">
            <label for="Foto">Foto del Tipo de Accesorio:</label>
            <input type="file" name="Foto" accept="image/*">
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
