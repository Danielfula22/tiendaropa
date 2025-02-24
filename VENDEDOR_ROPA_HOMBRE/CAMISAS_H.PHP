<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Paginación
$SQL_REGISTROS = mysqli_query($conexion, "SELECT COUNT(*) AS TOTAL FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Camisas')");
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
    <title>Catálogo de Camisas</title>
    <link href="../ESTILOS/CATALOGO_PRUEBA.CSS" rel="stylesheet">
    <link href="../ESTILOS/MAS_IMPORTANTES.CSS" rel="stylesheet">
    <link href="../CSS_BOTONES/actualizar_eliminar.css" rel="stylesheet">
    <link href="../CSS_BOTONES/actualizar _eliminar_prendas.css" rel="stylesheet">
</head>
<body>



<?php include('../INCLUDE/HEADER_VENDEDOR.PHP'); ?>

<br>
<center>

<h1>CAMISAS</h1>

</center>

<div class="catalogo-container">
    <?php
    // Consultar los registros de tipo "Camisas" con paginación
    $CONSULTA = "SELECT * FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Camisas') LIMIT $DESDE, $POR_PAGINA";
    $EJECUTAR = mysqli_query($conexion, $CONSULTA);

    while ($FILA = mysqli_fetch_assoc($EJECUTAR)) {
        $ID_PRENDA = $FILA['ID_Prenda'];
        $NOMBRE = $FILA['Nombre'];
        $COLOR = $FILA['Color'];
        $TALLA = $FILA['Talla'];
        $COSTO = $FILA['Costo'];
        $STOCK = $FILA['Stock'];
        $IMAGEN = "../IMAGENES/" . $FILA['Foto'];
    ?>
        <div class="producto-card">
            <img src="<?php echo $IMAGEN; ?>" alt="<?php echo $NOMBRE; ?>" class="producto-imagen">
            <div class="producto-info">
                <h3 class="producto-nombre"><?php echo $NOMBRE; ?></h3>
                <p class="producto-color">Color: <?php echo $COLOR; ?></p>
                <p class="producto-talla">Talla: <?php echo $TALLA; ?></p>
                <p class="producto-precio">Precio: $<?php echo number_format($COSTO, 2); ?></p>
                <p class="producto-stock">Stock: <?php echo $STOCK; ?></p>
                <div class="acciones">
                <button class="btn-actualizar" onclick="window.location.href='../EILIMINAR_ACTUALIZAR_PRENDAS/ACTUALIZAR_PRENDAS.PHP?ID=<?php echo $ID_PRENDA; ?>'">Actualizar</button>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Tarjeta de Agregar Nueva Prenda -->
    <div class="producto-card">
        <img src="../IMAGENES/mas.png" alt="Agregar nueva prenda" class="producto-imagen">
        <div class="producto-info">
            <h3 class="producto-nombre">Agregar Nueva Camisa</h3>
            <div class="acciones">
            <button class="btn-agregar" onclick="window.location.href='../OTRO_VENDEDOR/CAMISETAS_HOMBRE.PHP'">Agregar</button>
            </div>
        </div>
    </div>
</div>

<?php include('../INCLUDE/FOOTER.PHP'); ?>
</body>
</html>
