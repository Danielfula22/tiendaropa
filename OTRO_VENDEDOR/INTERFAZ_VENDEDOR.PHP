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
$countQuery = "SELECT COUNT(*) AS TOTAL FROM usuario";
if ($searchTerm) {
    $countQuery .= " WHERE usuario.Nombre LIKE '%$searchTerm%'";
}
$SQL_REGISTROS = mysqli_query($conexion, $countQuery);
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

// Configurar paginación
$POR_PAGINA = 4;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);

// Construir la consulta principal de usuarios con paginación y filtrado por nombre si se proporciona un término de búsqueda
$CONSULTA = "SELECT usuario.*, rol.Nombre AS RolNombre FROM usuario 
             INNER JOIN rol ON usuario.ID_Rol = rol.id_Rol";
if ($searchTerm) {
    $CONSULTA .= " WHERE usuario.Nombre LIKE '%$searchTerm%'";
}
$CONSULTA .= " LIMIT $DESDE, $POR_PAGINA";

$EJECUTAR = mysqli_query($conexion, $CONSULTA);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Administrador</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
    <link href="../ESTILOS/responsiva.css" rel="stylesheet">
    <link href="../ESTILOS/TABLA_ADMINISTRADOR.CSS" rel="stylesheet">
</head>
<body>
<?php include('../INCLUDE/HEADER_VENDEDOR.PHP'); ?>

<!-- Contenido principal -->
<div class="search-bar-container">
    <form method="get" action="" class="search-form">
        <input type="search" name="TXTBUSCAR" placeholder="Buscar por nombre..." class="search-input" value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <input type="submit" class="search-btn" name="buscar" value="CONSULTAR">
        <a href="?" class="clear-btn" style="text-decoration:none; color: green; ">X</a> <!-- Botón para limpiar el filtro -->
    </form>
    <a class="add-personnel-btn" href="../OTRO_VENDEDOR/FORMULARIO_PERSONAL NUEVO.PHP">AGREGAR PERSONAL</a>
</div>

<!-- Paginación arriba de la tabla -->
<div class="pagination">
    <?php for ($i = 1; $i <= $TOTAL_PAGINAS; $i++) { ?>
        <a href="?PAGINA=<?php echo $i; ?>&TXTBUSCAR=<?php echo urlencode($searchTerm); ?>" class="<?php echo $i == $PAGINA ? 'active' : 'page-link'; ?>"><?php echo $i; ?></a>
    <?php } ?>
</div>

<!-- Tabla de usuarios -->
<table class="styled-table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Número de Documento</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Teléfono</th>
            <th>Estado</th>
            <th>Rol</th>
            <th>Actualizar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($FILA = mysqli_fetch_assoc($EJECUTAR)) {
            $ID = $FILA['ID_Usuario'];
            $NOM = $FILA['Nombre'];
            $APE = $FILA['Apellido'];
            $CORREO = $FILA['Correo'];
            $DOC = $FILA['N_Documento'];
            $DIR = $FILA['Direccion'];
            $CIUDAD = $FILA['Ciudad'];
            $TEL = $FILA['Telefono'];
            $ESTADO = $FILA['Estado'];
            $ROL_NOMBRE = $FILA['RolNombre'];
        ?>
            <tr>
                <td data-label="Nombre"><?php echo $NOM; ?></td>
                <td data-label="Apellido"><?php echo $APE; ?></td>
                <td data-label="Correo"><?php echo $CORREO; ?></td>
                <td data-label="Número de Documento"><?php echo $DOC; ?></td>
                <td data-label="Dirección"><?php echo $DIR; ?></td>
                <td data-label="Ciudad"><?php echo $CIUDAD; ?></td>
                <td data-label="Teléfono"><?php echo $TEL; ?></td>
                <td data-label="Estado"><?php echo $ESTADO; ?></td>
                <td data-label="Rol"><?php echo $ROL_NOMBRE; ?></td>
                
                <td data-label="Actualizar">
                    <a href="../OTRO_VENDEDOR/ACTUALIZAR_PERSONAL.PHP?ID=<?php echo $ID; ?>">
                        <img src="../IMAGENES/actualizar.png" style="width: 40px; height: 40px;">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
