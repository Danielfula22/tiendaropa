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
$countQuery = "SELECT COUNT(*) AS TOTAL FROM Usuario WHERE ID_Rol = 3";
if ($searchTerm) {
    $countQuery .= " AND (Nombre LIKE '%$searchTerm%' OR Apellido LIKE '%$searchTerm%')";
}
$SQL_REGISTROS = mysqli_query($conexion, $countQuery);
if (!$SQL_REGISTROS) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

// Configurar paginación
$POR_PAGINA = 5;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);

// Construir la consulta principal de usuarios con paginación y filtrado por rol 3
$CONSULTA = "SELECT * FROM Usuario WHERE ID_Rol = 3";
if ($searchTerm) {
    $CONSULTA .= " AND (Nombre LIKE '%$searchTerm%' OR Apellido LIKE '%$searchTerm%')";
}
$CONSULTA .= " LIMIT $DESDE, $POR_PAGINA";

$EJECUTAR = mysqli_query($conexion, $CONSULTA);
if (!$EJECUTAR) {
    die("Error en la consulta principal: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
    <link href="../ESTILOS/responsiva.css" rel="stylesheet">
    <link href="../ESTILOS/TABLA_ADMINISTRADOR.CSS" rel="stylesheet">
    <link href="../estilos_importattt.css" rel="stylesheet">

</head>
<body>
<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>

<!-- Título con línea debajo -->
<div class="title-container">
    <h1>FACTURAS</h1>
    <hr>
</div>
<br>
<!-- Contenido principal -->
<div class="search-bar-container">
    <form method="get" action="" class="search-form">
        <input type="search" name="TXTBUSCAR" placeholder="Buscar por nombre o apellido..." class="search-input" value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <input type="submit" class="search-btn" name="buscar" value="CONSULTAR">
    </form>
    <center>
    <a class="add-personnel-btn" href="../FACTURACION/personar_nuevo.php">NUEVO USUARIO</a>
    </center>
</div>

<!-- Tabla de usuarios -->
<table class="styled-table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Documento</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Teléfono</th>
            <th>Estado</th>
            <th>Factura</th> <!-- Nueva columna -->
        </tr>
    </thead>
    <tbody>
    <?php
    while ($FILA = mysqli_fetch_assoc($EJECUTAR)) {
        $ID_USUARIO = $FILA['ID_Usuario'];
        $NOMBRE = $FILA['Nombre'];
        $APELLIDO = $FILA['Apellido'];
        $CORREO = $FILA['Correo'];
        $DOCUMENTO = $FILA['N_Documento'];
        $DIRECCION = $FILA['Direccion'];
        $CIUDAD = $FILA['Ciudad'];
        $TELEFONO = $FILA['Telefono'];
        $ESTADO = $FILA['Estado'];
    ?>
        <tr>
            <td data-label="Nombre"><?php echo $NOMBRE; ?></td>
            <td data-label="Apellido"><?php echo $APELLIDO; ?></td>
            <td data-label="Correo"><?php echo $CORREO; ?></td>
            <td data-label="Documento"><?php echo $DOCUMENTO; ?></td>
            <td data-label="Dirección"><?php echo $DIRECCION; ?></td>
            <td data-label="Ciudad"><?php echo $CIUDAD; ?></td>
            <td data-label="Teléfono"><?php echo $TELEFONO; ?></td>
            <td data-label="Estado"><?php echo $ESTADO; ?></td>
           
            </td>
            <td data-label="Factura"> <!-- Nueva celda -->
                <a href="../FACTURACION/factura_tt.php?FACTURAR=<?php echo $ID_USUARIO; ?>">
                    <img src="../IMAGENES/pdf.png" style="width: 40px; height: 40px;">
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<!-- Paginación arriba de la tabla -->
<div class="pagination">
    <?php for ($i = 1; $i <= $TOTAL_PAGINAS; $i++) { ?>
        <a href="?PAGINA=<?php echo $i; ?>&TXTBUSCAR=<?php echo urlencode($searchTerm); ?>" class="<?php echo $i == $PAGINA ? 'active' : 'page-link'; ?>"><?php echo $i; ?></a>
    <?php } ?>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
