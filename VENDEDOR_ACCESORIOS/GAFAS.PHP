<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Eliminar accesorio si se envía un formulario con el ID
if (isset($_POST['eliminar']) && isset($_POST['ID_Accesorio'])) {
    $idAccesorio = intval($_POST['ID_Accesorio']);
    $queryEliminar = "DELETE FROM accesorio WHERE ID_Accesorio = $idAccesorio";
    $resultadoEliminar = mysqli_query($conexion, $queryEliminar);

    if ($resultadoEliminar) {
        echo "<script>alert('Accesorio eliminado exitosamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar el accesorio');</script>";
    }
}

// Paginación
$SQL_REGISTROS = mysqli_query($conexion, "SELECT COUNT(*) AS TOTAL FROM accesorio WHERE ID_Tipo_accesorio IN (SELECT ID_Tipo_accesorio FROM tipo_accesorio WHERE Nombre = 'Gafas de sol')");
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

$POR_PAGINA = 15;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Gafas de Sol</title>
    <link href="../ESTILOS/CATALOGO_PRUEBA.CSS" rel="stylesheet">
    <link href="../ESTILOS/MAS_IMPORTANTES.CSS" rel="stylesheet">
    <link href="../CSS_BOTONES//actualizar_eliminar.css" rel="stylesheet">

</head>
<body>


<?php include('../INCLUDE/HEADER_VENDEDOR.PHP'); ?>

 <!--Productos -->


                <!-- Producto 1 -->
<br>
                <center>               
                     <h1>GAFAS</h1><br><br> 
                 </center>
<div class="catalogo-container">
    <?php
    // Consultar los registros de tipo "Gafas de sol" con paginación
    $CONSULTA = "SELECT * FROM accesorio WHERE ID_Tipo_accesorio IN (SELECT ID_Tipo_accesorio FROM tipo_accesorio WHERE Nombre = 'Gafas de sol') LIMIT $DESDE, $POR_PAGINA";
    $EJECUTAR = mysqli_query($conexion, $CONSULTA);

    while ($FILA = mysqli_fetch_assoc($EJECUTAR)) {
        $ID_ACCESORIO = $FILA['ID_Accesorio'];
        $NOMBRE = $FILA['Nombre'];
        $COSTO = $FILA['Costo'];
        $STOCK = $FILA['Stock'];
        $DESCRIPCION = $FILA['Descripcion'];
        $IMAGEN = "../IMAGENES/" . $FILA['Foto'];
    ?>
        <div class="producto-card">
            <img src="<?php echo $IMAGEN; ?>" alt="<?php echo $NOMBRE; ?>" class="producto-imagen">
            <div class="producto-info">
                <h3 class="producto-nombre"><?php echo $NOMBRE; ?></h3>
                <p class="producto-descripcion">Descripción: <?php echo $DESCRIPCION; ?></p>
                <p class="producto-precio">Precio: $<?php echo number_format($COSTO, 2); ?></p>
                <p class="producto-stock">Stock: <?php echo $STOCK; ?></p>
                <div class="acciones">
                <button class="btn-actualizar" onclick="window.location.href='../ELIMINAR_ACTUALIZAR_PRODUCTOS_ADMINISTRADOR/ACTUALIZAR_ACCESORIOS.PHP?id=<?php echo $ID_ACCESORIO; ?>'">Actualizar</button>
                    <a href="../ELIMINAR_ACTUALIZAR_PRODUCTOS_ADMINISTRADOR/ELIMINAR_PRODUCTO.PHP?ID=<?php echo $ID_ACCESORIO; ?>" 
                       onclick="return confirm('¿Estás seguro de que quieres eliminar este accesorio?')" 
                       class="btn-eliminar">Eliminar</a>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Tarjeta de Agregar Nueva Gafa de Sol -->
    <div class="producto-card">
        <img src="../IMAGENES/mas.png" alt="Agregar nueva gafa de sol" class="producto-imagen">
        <div class="producto-info">
            <h3 class="producto-nombre">Agregar Nueva Gafa de Sol</h3>
            <div class="acciones">
            <button class="btn-agregar" onclick="window.location.href='../OTRO_VENDEDOR/CAMISETAS_HOMBRE.PHP'">Agregar</button>
            </div>
        </div>
    </div>
</div>

<?php include('../INCLUDE/FOOTER.PHP'); ?>
</body>
</html>
