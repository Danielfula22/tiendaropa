<?php
// Incluir el archivo de conexión a la base de datos
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar si la conexión se ha establecido correctamente
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Obtener el término de búsqueda desde el formulario (si existe)
$searchTerm = isset($_GET['TXTBUSCAR']) ? mysqli_real_escape_string($conexion, $_GET['TXTBUSCAR']) : '';

// Construir la consulta SQL para contar los registros, filtrando si hay un término de búsqueda
$countQuery = "SELECT COUNT(*) AS TOTAL FROM proveedor";
if ($searchTerm) {
    $countQuery .= " WHERE Nombre LIKE '%$searchTerm%'";
}
$SQL_REGISTROS = mysqli_query($conexion, $countQuery);
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

// Configurar paginación
$POR_PAGINA = 4;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);

// Construir la consulta principal de proveedores con paginación y filtrado por nombre si se proporciona un término de búsqueda
$CONSULTA = "SELECT ID_Proveedor, Nombre, Telefono, Correo FROM proveedor";
if ($searchTerm) {
    $CONSULTA .= " WHERE Nombre LIKE '%$searchTerm%'";
}
$CONSULTA .= " LIMIT $DESDE, $POR_PAGINA"; // Paginación aplicada

$EJECUTAR = mysqli_query($conexion, $CONSULTA);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Administrador - Proveedores</title>
    <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
    <link href="../ESTILOS/responsiva.css" rel="stylesheet">
    <link href="../ESTILOS/TABLA_ADMINISTRADOR.CSS" rel="stylesheet">
    <style>
        /* Estilos adicionales para los botones de acción */
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
        }
        .action-btn img {
            width: 24px; /* Ajusta el tamaño de la imagen según sea necesario */
            height: 24px;
        }
    </style>
</head>
<body>
<?php include('../INCLUDE/HEADER_VENDEDOR.PHP'); ?>

<!-- Contenido principal -->
<div class="search-bar-container">
    <form method="get" action="" class="search-form">
        <input type="search" name="TXTBUSCAR" placeholder="Buscar por nombre de proveedor..." class="search-input" value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <input type="submit" class="search-btn" name="buscar" value="CONSULTAR">
    </form>
    <a class="add-personnel-btn" href="../OTRO_VENDEDOR/INSERTAR_PROVEEDOR.PHP">AGREGAR PROVEEDOR</a>
</div>

<!-- Paginación arriba de la tabla -->
<div class="pagination">
    <?php for ($i = 1; $i <= $TOTAL_PAGINAS; $i++) { ?>
        <a href="?PAGINA=<?php echo $i; ?>&TXTBUSCAR=<?php echo urlencode($searchTerm); ?>" class="<?php echo $i == $PAGINA ? 'active' : 'page-link'; ?>"><?php echo $i; ?></a>
    <?php } ?>
</div>

<!-- Tabla de proveedores -->
<table class="styled-table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Actualizar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($FILA = mysqli_fetch_assoc($EJECUTAR)) {
            $ID = $FILA['ID_Proveedor'];
            $NOM = $FILA['Nombre'];
            $TEL = $FILA['Telefono'];
            $CORREO = $FILA['Correo'];
        ?>
            <tr>
                <td data-label="Nombre"><?php echo $NOM; ?></td>
                <td data-label="Teléfono"><?php echo $TEL; ?></td>
                <td data-label="Correo"><?php echo $CORREO; ?></td>
                <!-- Celda para el botón de actualización -->
                <td data-label="Actualizar">
                    <a href="../OTRO_VENDEDOR/ACTUALIZAR_PROVEEDORES.PHP?id=<?php echo urlencode($ID); ?>" class="action-btn" title="Actualizar">
                        <img src="../IMAGENES/actualizar.png" style="width: 40px; height: 40px;" alt="Editar">
                    </a>
                </td>
                <!-- Celda para el botón de eliminación -->
               
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
