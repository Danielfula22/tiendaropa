
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
$countQuery = "
    SELECT COUNT(*) AS TOTAL 
    FROM pedido p 
    LEFT JOIN entrega e ON p.ID_Entrega = e.ID_Entrega";
if ($searchTerm) {
    $countQuery .= " WHERE p.Nombre_del_cliente LIKE '%$searchTerm%' 
                    OR p.Direccion_de_la_entrega LIKE '%$searchTerm%' 
                    OR p.Correo LIKE '%$searchTerm%'
                    OR p.Cedula_del_cliente LIKE '%$searchTerm%'";
}
$SQL_REGISTROS = mysqli_query($conexion, $countQuery);
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

// Configurar paginación
$POR_PAGINA = 4;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);

// Consulta principal para obtener los datos de ambas tablas
$CONSULTA = "
SELECT 
    p.ID_Pedido,
    p.Nombre_del_cliente AS Nombre_Pedido,
    p.Cedula_del_cliente AS Cedula_Pedido,
    p.Correo,
    p.Direccion_de_la_entrega,
    p.Departamento AS Departamento,
    e.ID_Entrega,
    e.Fecha_de_entrega,
    e.Estado,
    e.ID_Modo_entrega,  -- Usar ID_Modo_entrega directamente
    e.ID_Domiciliario
FROM pedido p
LEFT JOIN entrega e ON p.ID_Entrega = e.ID_Entrega";

if ($searchTerm) {
    $CONSULTA .= " WHERE p.Nombre_del_cliente LIKE '%$searchTerm%' 
                   OR p.Direccion_de_la_entrega LIKE '%$searchTerm%'
                   OR p.Correo LIKE '%$searchTerm%'
                   OR p.Cedula_del_cliente LIKE '%$searchTerm%'";
}
$CONSULTA .= " LIMIT $DESDE, $POR_PAGINA";
$EJECUTAR = mysqli_query($conexion, $CONSULTA);

// Array para asignar nombres descriptivos a ID_Modo_entrega
$modoEntrega = [
    1 => 'Recoger en tienda',
    2 => 'Envío a domicilio',
    3 => 'Entrega express'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio del Administrador</title>

    <!-- Enlaces a estilos -->
  <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
    <link href="../ESTILOS/index.css" rel="stylesheet">
    <link href="../ESTILOS/menu.css" rel="stylesheet">
    <link href="../ESTILOS/categorias.css" rel="stylesheet">
    <link href="../ESTILOS/ico_perfil.css" rel="stylesheet">
    <link href="../ESTILOS/responsiva.css" rel="stylesheet">
    <link href="../ESTILOS/menu_de los demas.css" rel="stylesheet">
    <link href="../ESTILOS/responsivo_articulos.css" rel="stylesheet">
    <link href="../ESTILOS/TABLA_ADMINISTRADOR.CSS" rel="stylesheet">
</head>
<body>



<?php include('../INCLUDE/HEADER_DOMICILIARIO.PHP'); ?>



<!-- Paginación -->
<div class="pagination">
    <?php for ($i = 1; $i <= $TOTAL_PAGINAS; $i++) { ?>
        <a href="?PAGINA=<?php echo $i; ?>&TXTBUSCAR=<?php echo urlencode($searchTerm); ?>" class="<?php echo $i == $PAGINA ? 'active' : 'page-link'; ?>"><?php echo $i; ?></a>
    <?php } ?>
</div>

<!-- Tabla para mostrar los resultados -->
<table class="styled-table">
    <thead>
        <tr>
            <th>ID Pedido</th>
            <th>Nombre Cliente (Pedido)</th>
            <th>Cédula Cliente (Pedido)</th>
            <th>Correo</th>
            <th>Dirección de Entrega</th>
            <th>Departamento</th>
            <th>Fecha de Entrega</th>
            <th>Estado</th>
            <th>Modo de Entrega</th>
            <th>Domiciliario</th>
            <th>Actualizar</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($FILA = mysqli_fetch_assoc($EJECUTAR)) { ?>
        <tr>
            <td><?php echo $FILA['ID_Pedido']; ?></td>
            <td><?php echo $FILA['Nombre_Pedido']; ?></td>
            <td><?php echo $FILA['Cedula_Pedido']; ?></td>
            <td><?php echo $FILA['Correo']; ?></td>
            <td><?php echo $FILA['Direccion_de_la_entrega']; ?></td>
            <td><?php echo $FILA['Departamento']; ?></td>
            <td><?php echo $FILA['Fecha_de_entrega']; ?></td>
            <td><?php echo $FILA['Estado']; ?></td>
            <td><?php echo isset($modoEntrega[$FILA['ID_Modo_entrega']]) ? $modoEntrega[$FILA['ID_Modo_entrega']] : 'Modo desconocido'; ?></td>
            <td><?php echo $FILA['ID_Domiciliario']; ?></td>
            <td>
                <a href="../PEDIDO/ACTUALIZAR_PEDIDO.PHP?id=<?php echo urlencode($FILA['ID_Pedido']); ?>" class="action-btn">
                    <img src="../IMAGENES/actualizar.png" alt="Actualizar" style="width: 30px; height: 30px;">
                </a>
            </td>
           
        </tr>
        <?php } ?>
    </tbody>
</table>



<?php include("../INCLUDE/FOOTER.PHP"); ?>

</body>
</html>
