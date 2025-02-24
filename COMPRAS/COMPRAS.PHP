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
$countQuery = "SELECT COUNT(*) AS TOTAL FROM compras";
if ($searchTerm) {
    $countQuery .= " WHERE ID_Compra LIKE '%$searchTerm%' OR Nombre LIKE '%$searchTerm%'";
}
$SQL_REGISTROS = mysqli_query($conexion, $countQuery);
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

// Configurar paginación
$POR_PAGINA = 4;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);

// Consulta principal para obtener los datos de la tabla compra
$CONSULTA = "SELECT ID_Compra, ID_Usuario, ID_Tipo_Pago, Nombre, Email, Cedula, Direccion_Entrega, Productos_Comprados, Total, Lugar_Envio, Numero_Telefono, Estado FROM compras";
if ($searchTerm) {
    $CONSULTA .= " WHERE ID_Compra LIKE '%$searchTerm%' OR Nombre LIKE '%$searchTerm%'";
}
$CONSULTA .= " LIMIT $DESDE, $POR_PAGINA";

$EJECUTAR = mysqli_query($conexion, $CONSULTA);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Administrador - Compras</title>
    <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
    <link href="../ESTILOS/responsiva.css" rel="stylesheet">
    <link href="../ESTILOS/TABLA_ADMINISTRADOR.CSS" rel="stylesheet">
</head>
<body>
<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>

<div class="search-bar-container">
    <form method="get" action="" class="search-form">
        <input type="search" name="TXTBUSCAR" placeholder="Buscar por ID o Nombre..." class="search-input" value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <input type="submit" class="search-btn" name="buscar" value="CONSULTAR">
    </form>
    <a class="add-personnel-btn" href="../COMPRAS/INSERTAR_COMPRA.PHP">AGREGAR COMPRA</a>
</div>

<!-- Paginación -->
<div class="pagination">
    <?php for ($i = 1; $i <= $TOTAL_PAGINAS; $i++) { ?>
        <a href="?PAGINA=<?php echo $i; ?>&TXTBUSCAR=<?php echo urlencode($searchTerm); ?>" class="<?php echo $i == $PAGINA ? 'active' : 'page-link'; ?>"><?php echo $i; ?></a>
    <?php } ?>
</div>

<!-- Tabla de compras -->
<table class="styled-table">
    <thead>
        <tr>
            <th>ID Compra</th>
            <th>Usuario</th>
            <th>Tipo de Pago</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Cédula</th>
            <th>Dirección Entrega</th>
            <th>Productos Comprados</th>
            <th>Total</th>
            <th>Lugar Envío</th>
            <th>Teléfono</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($FILA = mysqli_fetch_assoc($EJECUTAR)) {
            $ID_COMPRA = $FILA['ID_Compra'];
            $ID_USUARIO = $FILA['ID_Usuario'];
            $ID_TIPO_PAGO = $FILA['ID_Tipo_Pago'];
            $NOMBRE = $FILA['Nombre'];
            $EMAIL = $FILA['Email'];
            $CEDULA = $FILA['Cedula'];
            $DIRECCION = $FILA['Direccion_Entrega'];
            $PRODUCTOS = $FILA['Productos_Comprados'];
            $TOTAL = $FILA['Total'];
            $LUGAR_ENVIO = $FILA['Lugar_Envio'];
            $TELEFONO = $FILA['Numero_Telefono'];
            $ESTADO = $FILA['Estado'];

            // Determinar el estado de la compra
            $estado_compra = ($ESTADO == 1) ? 'Activo' : 'Anulado';
        ?>
            <tr>
                <td><?php echo $ID_COMPRA; ?></td>
                <td><?php echo $ID_USUARIO; ?></td>
                <td><?php echo $ID_TIPO_PAGO; ?></td>
                <td><?php echo $NOMBRE; ?></td>
                <td><?php echo $EMAIL; ?></td>
                <td><?php echo $CEDULA; ?></td>
                <td><?php echo $DIRECCION; ?></td>
                <td><?php echo $PRODUCTOS; ?></td>
                <td><?php echo $TOTAL; ?></td>
                <td><?php echo $LUGAR_ENVIO; ?></td>
                <td><?php echo $TELEFONO; ?></td>
                <td><?php echo $estado_compra; ?></td>
                <td>
                    <a onClick="javascript: return confirm('¿Estás seguro de anular esta compra?');" href="?anular=<?php echo $ID_COMPRA; ?>">ANULAR</a>
                    <a href="../FACTURACION/pdf.php?id_compra=<?php echo $ID_COMPRA; ?>" target="_blank">PDF</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
// Anular una compra
if (isset($_GET['anular'])) {
    $ID_ANULAR = $_GET['anular'];
    $ANULAR_QUERY = "UPDATE compra SET Estado=2 WHERE ID_Compra='$ID_ANULAR'";
    $EJECUTAR_ANULAR = mysqli_query($conexion, $ANULAR_QUERY);

    if ($EJECUTAR_ANULAR) {
        echo "<script>alert('Compra anulada');</script>";
        echo "<script>window.open('COMPRAS.PHP','_self');</script>";
    }
}
?>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
