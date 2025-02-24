<?php
ob_start();
include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

// Verificar si el parámetro 'id' está presente y es numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_entrega = intval($_GET['id']); // Asegura que el ID sea un número

    // Consultar los datos de la entrega
    $sql_entrega = "
    SELECT 
        e.ID_Entrega, 
        e.Nombre_del_cliente AS NombreClienteEntrega, 
        e.Cedula_del_cliente AS CedulaClienteEntrega, 
        e.Correo AS CorreoCliente,
        e.Direccion_de_la_entrega, 
        e.Departamento, 
        e.Fecha_de_entrega, 
        e.Estado, 
        e.ID_Modo_entrega, 
        e.ID_Domiciliario
    FROM entrega e
    WHERE e.ID_Entrega = ?";

    $stmt = mysqli_prepare($conexion, $sql_entrega);
    mysqli_stmt_bind_param($stmt, "i", $id_entrega);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $entrega = mysqli_fetch_assoc($resultado);

    // Si no se encuentra la entrega, redirigir con mensaje
    if (!$entrega) {
        echo "<script>alert('Entrega no encontrada'); window.location.href='LISTA_ENTREGAS.PHP';</script>";
        exit();
    }
} else {
    // Si no es un ID válido, redirigir
    echo "<script>alert('ID de entrega no válido'); window.location.href='LISTA_ENTREGAS.PHP';</script>";
    exit();
}

// Consultar modos de entrega para mostrar nombres
$modosEntregaQuery = "SELECT ID_Modo_entrega, Descripcion FROM modo_entrega";
$modosEntregaResult = mysqli_query($conexion, $modosEntregaQuery);

// Consultar domiciliarios para mostrar nombres
$domiciliariosQuery = "SELECT ID_Domiciliario, Nombre FROM domiciliario";
$domiciliariosResult = mysqli_query($conexion, $domiciliariosQuery);

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los valores del formulario
    $direccion = $_POST['Direccion_de_la_entrega'];
    $fecha_entrega = $_POST['Fecha_de_entrega'];
    $departamento = $_POST['Departamento'];
    $estado = $_POST['Estado'];
    $id_modo_entrega = $_POST['ID_Modo_entrega'];
    $id_domiciliario = $_POST['ID_Domiciliario'];

    // Actualizar los datos de la entrega usando una consulta preparada
    $sql_update = "UPDATE entrega SET 
                    Direccion_de_la_entrega = ?, 
                    Fecha_de_entrega = ?, 
                    Departamento = ?,  
                    Estado = ?, 
                    ID_Modo_entrega = ?, 
                    ID_Domiciliario = ? 
                    WHERE ID_Entrega = ?";

    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssssiii", 
        $direccion, $fecha_entrega, $departamento, 
        $estado, $id_modo_entrega, $id_domiciliario, $id_entrega);

    // Ejecutar la actualización y verificar el éxito
    if (mysqli_stmt_execute($stmt_update)) {
        echo "<script>alert('Entrega actualizada exitosamente'); window.location.href='../ENTREGA/ENTREGA.PHP';</script>";
    } else {
        echo "<script>alert('Error al actualizar la entrega'); window.location.href='LISTA_ENTREGAS.PHP';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Entrega</title>
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
        input[type="date"],
        select {
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
        input[type="date"]:focus,
        select:focus {
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
    <form action="" method="POST">
        <h2>Actualizar Entrega</h2>

        <div class="form-grid">
            <div>
                <label>Nombre del Cliente:</label>
                <input type="text" value="<?php echo htmlspecialchars($entrega['NombreClienteEntrega']); ?>" disabled>
            </div>

            <div>
                <label>Cédula del Cliente:</label>
                <input type="text" value="<?php echo htmlspecialchars($entrega['CedulaClienteEntrega']); ?>" disabled>
            </div>

            <div>
                <label>Correo:</label>
                <input type="email" value="<?php echo htmlspecialchars($entrega['CorreoCliente']); ?>" disabled>
            </div>

            <div>
                <label>Dirección de Entrega:</label>
                <input type="text" name="Direccion_de_la_entrega" value="<?php echo htmlspecialchars($entrega['Direccion_de_la_entrega']); ?>" required>
            </div>

            <div>
                <label>Fecha de Entrega:</label>
                <input type="date" name="Fecha_de_entrega" value="<?php echo htmlspecialchars($entrega['Fecha_de_entrega']); ?>" required>
            </div>

            <div>
                <label>Departamento:</label>
                <input type="text" name="Departamento" value="<?php echo htmlspecialchars($entrega['Departamento']); ?>" required>
            </div>

            <div>
                <label>Estado de la entrega:</label>
                <select name="Estado" required>
                    <option value="cancelado" <?php if ($entrega['Estado'] == 'cancelado') echo 'selected'; ?>>Cancelado</option>
                    <option value="pendiente" <?php if ($entrega['Estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                    <option value="en proceso" <?php if ($entrega['Estado'] == 'en proceso') echo 'selected'; ?>>En Proceso</option>
                </select>
            </div>

            <div>
                <label>Modo de Entrega:</label>
                <select name="ID_Modo_entrega" required>
                    <?php while ($modo = mysqli_fetch_assoc($modosEntregaResult)) : ?>
                        <option value="<?php echo $modo['ID_Modo_entrega']; ?>" <?php if ($modo['ID_Modo_entrega'] == $entrega['ID_Modo_entrega']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($modo['Descripcion']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label>Domiciliario:</label>
                <select name="ID_Domiciliario" required>
                    <?php while ($domiciliario = mysqli_fetch_assoc($domiciliariosResult)) : ?>
                        <option value="<?php echo $domiciliario['ID_Domiciliario']; ?>" <?php if ($domiciliario['ID_Domiciliario'] == $entrega['ID_Domiciliario']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($domiciliario['Nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
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
