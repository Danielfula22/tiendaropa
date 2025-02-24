<?php
ob_start();
include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

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
        echo "<script>alert('Proveedor actualizado exitosamente'); window.location.href='../PROVEEDORES/PROVEEDORES.PHP';</script>";
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
        input[type="email"],
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
        input[type="email"]:focus,
        input[type="file"]:focus {
            border-color: #e76f51; /* Terracota */
            outline: none;
            background-color: #ffffff;
        }

        /* Botón de actualizar */
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
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Actualizar Proveedor</h2>

        <div class="form-grid">
            <div>
                <label for="Nombre">Nombre:</label>
                <input type="text" name="Nombre" value="<?php echo htmlspecialchars($proveedor['Nombre']); ?>" required>
            </div>
            <div>
                <label for="Telefono">Teléfono:</label>
                <input type="text" name="Telefono" value="<?php echo htmlspecialchars($proveedor['Telefono']); ?>" required>
            </div>
            <div>
                <label for="Correo">Correo:</label>
                <input type="email" name="Correo" value="<?php echo htmlspecialchars($proveedor['Correo']); ?>" required>
            </div>

            <!-- Campo para subir foto (opcional) -->
            <div>
                <label for="foto">Foto (opcional):</label>
                <input type="file" name="foto">
            </div>

            <div class="full-width">
                <input type="submit" value="Actualizar">
            </div>
        </div>
    </form>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>

<?php ob_end_flush(); ?>
