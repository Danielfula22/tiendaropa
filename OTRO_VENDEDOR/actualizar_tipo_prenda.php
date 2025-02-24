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

    // Actualizar el tipo de prenda en la base de datos
    $sql_update = "UPDATE tipo_prenda SET Nombre = ? WHERE ID_Tipo_prenda = ?";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "si", $nombre, $id_tipo_prenda);

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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin: 5px 0;
        }

        .form-container input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
<?php include('../INCLUDE/HEADER_VENDEDOR.PHP'); ?>

<div class="form-container">
    <h2>Actualizar Tipo de Prenda</h2>

    <form action="" method="POST">
        <label>Nombre del tipo de prenda:</label>
        <input type="text" name="Nombre" value="<?php echo htmlspecialchars($tipoPrenda['Nombre']); ?>" required>

        <input type="submit" value="Actualizar">
    </form>
</div>

<?php include('../INCLUDE/FOOTER.PHP'); ?>
</body>
</html>
