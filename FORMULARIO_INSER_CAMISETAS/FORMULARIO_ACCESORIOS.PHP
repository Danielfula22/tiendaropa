<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $costo = $_POST['costo'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    $id_tipo_accesorio = $_POST['id_tipo_accesorio'];
    $id_proveedor = $_POST['id_proveedor'];

    // Procesar la carga de la imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $ruta_temporal = $_FILES['foto']['tmp_name'];
        $carpeta_destino = "../IMAGENES/";

        // Mover la imagen a la carpeta de destino
        move_uploaded_file($ruta_temporal, $carpeta_destino . $foto);
    } else {
        $foto = null; // Si no se carga una imagen, queda null
    }

    // Insertar datos en la tabla accesorio
    $SQL = "INSERT INTO accesorio (Nombre, Costo, Stock, Descripcion, Foto, ID_Tipo_accesorio, ID_Proveedor) 
            VALUES ('$nombre', $costo, '$stock', '$descripcion', '$foto', $id_tipo_accesorio, $id_proveedor)";
    $RESULT = mysqli_query($conexion, $SQL) or die(mysqli_error($conexion));

    // Mostrar una alerta de registro exitoso y redirigir a la misma página
    if ($RESULT) {
        echo "<script>alert('Registro exitoso'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Accesorio</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: white; /* Beige claro */
            margin: 0;
            padding: 0;
        }

        /* Contenedor del formulario */
        .form-container {
            max-width: 90%; /* Ocupar el 90% del ancho de la pantalla */
            margin: 30px auto;
            background: #fffaf0; /* Beige más claro */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border: 2px solid #f4a261; /* Color terracota */
            animation: fadeIn 1s ease-out; /* Aplicar la animación */
        }

        /* Animación para que el formulario aparezca suavemente */
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

        /* Títulos */
        h2 {
            text-align: center;
            color: #264653; /* Verde oscuro */
            margin-bottom: 30px;
            font-size: 32px;
        }

        /* Estilo del grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsivo */
            gap: 25px;
        }

        /* Labels */
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #6b705c; /* Marrón suave */
            font-size: 16px;
        }

        /* Campos de entrada */
        input[type="text"],
        input[type="number"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #b7b7a4; /* Beige oscuro */
            border-radius: 8px;
            font-size: 16px;
            background-color: #fefae0; /* Beige claro */
            transition: all 0.3s ease;
        }

        /* Enfocar campos */
        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: #e76f51; /* Terracota */
            outline: none;
            background-color: #ffffff;
        }

        /* Botón de guardar */
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #2a9d8f; /* Verde turquesa */
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
            background-color: #264653; /* Verde oscuro */
            transform: scale(1.02);
        }

        /* Campos de ancho completo */
        .full-width {
            grid-column: span 2;
        }

    </style>
</head>
<body>

<div class="form-container">
    <form name="insert_accesorio" action="" method="POST" enctype="multipart/form-data">
        <h2>Registrar Nuevo Accesorio</h2>
        <div class="form-grid">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label for="costo">Costo:</label>
                <input type="number" step="0.01" name="costo" required>
            </div>
            <div>
                <label for="stock">Stock:</label>
                <select name="stock" required>
                    <option value="Disponible">Disponible</option>
                    <option value="Agotado">Agotado</option>
                </select>
            </div>
            <div class="full-width">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" rows="4" required></textarea>
            </div>
            <div>
                <label for="id_tipo_accesorio">Tipo de Accesorio:</label>
                <select name="id_tipo_accesorio" required>
                    <option value="">Seleccione un tipo de accesorio</option>
                    <?php
                    $sql_tipo_accesorio = "SELECT ID_Tipo_accesorio, Nombre FROM tipo_accesorio";
                    $result_tipo_accesorio = mysqli_query($conexion, $sql_tipo_accesorio);
                    while ($row = mysqli_fetch_assoc($result_tipo_accesorio)) {
                        echo "<option value='" . $row['ID_Tipo_accesorio'] . "'>" . $row['Nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
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
            <div class="full-width">
                <label for="foto">Foto:</label>
                <input type="file" name="foto" accept="image/*" required>
            </div>
            <div class="full-width">
                <input type="submit" name="ENVIAR" value="Guardar">
            </div>
        </div>
    </form>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
<?php ob_end_flush(); ?>
</body>
</html>
