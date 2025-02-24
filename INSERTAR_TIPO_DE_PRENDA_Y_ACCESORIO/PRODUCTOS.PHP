<?php
// Incluir el archivo de conexión a la base de datos
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar si la conexión se ha establecido correctamente
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Obtener los términos de búsqueda desde el formulario (si existen)
$searchTermPrenda = isset($_GET['BUSCAR_PRENDA']) ? mysqli_real_escape_string($conexion, $_GET['BUSCAR_PRENDA']) : '';
$searchTermAccesorio = isset($_GET['BUSCAR_ACCESORIO']) ? mysqli_real_escape_string($conexion, $_GET['BUSCAR_ACCESORIO']) : '';

// Consulta para "tipo_prenda"
$consultaPrenda = "SELECT ID_Tipo_prenda, Nombre, Foto FROM tipo_prenda";
if ($searchTermPrenda) {
    $consultaPrenda .= " WHERE Nombre LIKE '%$searchTermPrenda%'";
}
$consultaPrenda .= " ORDER BY Nombre ASC";
$resultadoPrenda = mysqli_query($conexion, $consultaPrenda);

// Consulta para "tipo_accesorio"
$consultaAccesorio = "SELECT ID_Tipo_accesorio, Nombre, Foto FROM tipo_accesorio";
if ($searchTermAccesorio) {
    $consultaAccesorio .= " WHERE Nombre LIKE '%$searchTermAccesorio%'";
}
$consultaAccesorio .= " ORDER BY Nombre ASC";
$resultadoAccesorio = mysqli_query($conexion, $consultaAccesorio);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de Prendas y Accesorios</title>
    <link rel="stylesheet" href="../ESTILOS/responsiva.css">
    <link rel="stylesheet" href="../ESTILOS/TABLA_ADMINISTRADOR.CSS">
    <link href="../estilos_importattt.css" rel="stylesheet">

    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Contenedor de tablas */
        .tables-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
            padding: 10px;
        }

        /* Estilo para cada tabla */
        .table-wrapper {
            width: 48%;
            box-sizing: border-box;
        }

        /* Tabla estilizada */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        /* Estilo para los formularios de búsqueda */
        .search-form {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            justify-content: space-between;
        }

        /* Input de búsqueda */
        .search-input {
            width: 70%;
            padding: 5px;
            margin-bottom: 10px;
        }

        /* Botones de búsqueda y reset */
        .search-btn, .reset-btn {
            padding: 5px 10px;
            margin-left: 5px;
        }

        /* Estilos para los botones de reset */
        .reset-btn {
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
        }

        .reset-btn:hover {
            background-color: darkred;
        }

        /* Botones de acción */
        .action-btn {
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 5px;
        }

        .update-btn {
            background-color: orange;
        }

        .delete-btn {
            background-color: red;
        }

        .action-btn:hover {
            opacity: 0.8;
        }

        /* Botón para agregar tipo */
        .add-personnel-btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 5px 15px;
            margin-top: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .add-personnel-btn:hover {
            background-color: darkgreen;
        }

        /* Media Query para pantallas de tamaño pequeño (móviles) */
        @media (max-width: 768px) {
            .tables-container {
                flex-direction: column;
                align-items: center;
            }

            .table-wrapper {
                width: 100%;
            }

            .search-form {
                justify-content: flex-start;
                width: 100%;
            }

            .search-input {
                width: 65%;
                margin-right: 10px;
            }

            .search-btn {
                width: 30%;
            }

            .add-personnel-btn {
                margin-top: 15px;
            }

            .styled-table th, .styled-table td {
                font-size: 14px;
            }

            .action-btn {
                padding: 5px 8px;
            }

            .search-form {
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }

            /* Alineación de los botones de buscar y agregar en dispositivos móviles */
            .search-btn, .add-personnel-btn {
                width: 48%; /* Los botones compartirán el 50% del espacio cada uno */
                margin: 5px 0;
            }
        }

        /* Media Query para pantallas más grandes (PC) */
        @media (min-width: 769px) {
            .table-wrapper {
                width: 48%;
            }

            .styled-table th, .styled-table td {
                font-size: 16px;
            }

            .action-btn {
                padding: 10px;
            }

            .add-personnel-btn {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>


<!-- Título con línea debajo -->
<div class="title-container">
    <h1>PRODUCTOS EN LA TIENDA</h1>
    <hr>
</div>
<br>

<div class="tables-container">
    <!-- Tabla tipo_prenda -->
    <div class="table-wrapper">
        <form method="get" action="" class="search-form">
            <h3>Buscar Tipos de Prenda</h3>
            <input type="search" name="BUSCAR_PRENDA" placeholder="Buscar tipo de prenda..." class="search-input" value="<?php echo htmlspecialchars($searchTermPrenda); ?>">
            <input type="submit" class="search-btn" value="Buscar">
            <?php if ($searchTermPrenda) { ?>
                <button type="button" class="reset-btn" onclick="window.location.href='?';">X</button>
            <?php } ?>
        </form>
        <center>
        <a class="add-personnel-btn" href="../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/INSER_TIPO_PRENDA.PHP">AGREGAR TIPO DE PRENDA</a> <!-- Botón para agregar tipo de prenda -->
        </center>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Foto</th>
                    <th>Actualizar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultadoPrenda)) { ?>
                    <tr>
                        <td><?php echo $fila['Nombre']; ?></td>
                        <td>
                            <?php if (!empty($fila['Foto'])) { ?>
                                <img src="../IMAGENES/<?php echo htmlspecialchars($fila['Foto']); ?>" alt="Foto de <?php echo htmlspecialchars($fila['Nombre']); ?>" style="width: 100px; height: auto;">
                            <?php } else { ?>
                                <p>No disponible</p>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/actualizar_tipo_prenda.php?id=<?php echo urlencode($fila['ID_Tipo_prenda']); ?>" class="action-btn">
                                <img src="../IMAGENES/actualizar.png" style="width: 40px; height: 40px;" alt="Editar">
                            </a>
                        </td>
                        <td>
                            <a href="../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/eliminar_tipo_prenda.php?id=<?php echo urlencode($fila['ID_Tipo_prenda']); ?>" class="action-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este tipo de prenda?');">
                                <img src="../IMAGENES/eliminar.png" style="width: 40px; height: 40px;" alt="Eliminar">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla tipo_accesorio -->
    <div class="table-wrapper">
        <form method="get" action="" class="search-form">
            <h3>Buscar Tipos de Accesorio</h3>
            <input type="search" name="BUSCAR_ACCESORIO" placeholder="Buscar tipo de accesorio..." class="search-input" value="<?php echo htmlspecialchars($searchTermAccesorio); ?>">
            <input type="submit" class="search-btn" value="Buscar">
            <?php if ($searchTermAccesorio) { ?>
                <button type="button" class="reset-btn" onclick="window.location.href='?';">X</button>
            <?php } ?>
        </form>
        <center>
        <a class="add-personnel-btn" href="../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/INSER_TIPO_ACCESORIO.PHP">AGREGAR TIPO DE ACCESORIO</a> <!-- Botón para agregar tipo de accesorio -->
        </center>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Foto</th>
                    <th>Actualizar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultadoAccesorio)) { ?>
                    <tr>
                        <td><?php echo $fila['Nombre']; ?></td>
                        <td>
                            <?php if (!empty($fila['Foto'])) { ?>
                                <img src="../IMAGENES/<?php echo htmlspecialchars($fila['Foto']); ?>" alt="Foto de <?php echo htmlspecialchars($fila['Nombre']); ?>" style="width: 100px; height: auto;">
                            <?php } else { ?>
                                <p>No disponible</p>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/actualizar_tipo_accesorio.php?id=<?php echo urlencode($fila['ID_Tipo_accesorio']); ?>" class="action-btn">
                                <img src="../IMAGENES/actualizar.png" style="width: 40px; height: 40px;" alt="Editar">
                            </a>
                        </td>
                        <td>
                            <a href="../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/eliminar_tipo_accesorio.php?id=<?php echo urlencode($fila['ID_Tipo_accesorio']); ?>" class="action-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este tipo de accesorio?');">
                                <img src="../IMAGENES/eliminar.png" style="width: 40px; height: 40px;" alt="Eliminar">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>


</body>
</html>
