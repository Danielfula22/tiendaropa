<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Paginación
$SQL_REGISTROS = mysqli_query($conexion, "SELECT COUNT(*) AS TOTAL FROM accesorio WHERE ID_Tipo_accesorio IN (SELECT ID_Tipo_accesorio FROM tipo_accesorio WHERE Nombre = 'Cinturones')");
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
    <title>Catálogo de Cinturones</title>
    <link href="../ESTILOS/CATALOGO_PRUEBA.CSS" rel="stylesheet">
    <link href="../ESTILOS/MAS_IMPORTANTES.CSS" rel="stylesheet">
    <link href="../CSS_BOTONES/actualizar_eliminar.css" rel="stylesheet">
</head>
<body>

<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>

<center>
    <h1>CINTURÓN</h1><br><br> 
</center>

<div class="catalogo-container">
    <?php
    // Consultar los registros de tipo "Cinturones" con paginación
    $CONSULTA = "SELECT * FROM accesorio WHERE ID_Tipo_accesorio IN (SELECT ID_Tipo_accesorio FROM tipo_accesorio WHERE Nombre = 'Cinturones') LIMIT $DESDE, $POR_PAGINA";
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
                <p class="producto-stock" id="stock-<?php echo $ID_ACCESORIO; ?>">Stock: <?php echo $STOCK; ?></p>
                <div class="acciones">
                    <button class="btn-actualizar" onclick="window.location.href='../ELIMINAR_ACTUALIZAR_PRODUCTOS_ADMINISTRADOR/ACTUALIZAR_ACCESORIOS.PHP?id=<?php echo $ID_ACCESORIO; ?>'">Actualizar</button>
                    <a href="../ELIMINAR_ACTUALIZAR_PRODUCTOS_ADMINISTRADOR/ELIMINAR_PRODUCTO.PHP?ID=<?php echo $ID_ACCESORIO; ?>" 
                       onclick="return confirm('¿Estás seguro de que quieres eliminar este accesorio?')" 
                       class="btn-eliminar">Eliminar</a>
                </div>
                
            </div>
        </div>
    <?php } ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    actualizarStockAccesorios();
});

function actualizarStockAccesorios() {
    let stockData = JSON.parse(localStorage.getItem('stockAccesorios')) || {};
    for (let id in stockData) {
        let stockElement = document.getElementById(`stock-${id}`);
        if (stockElement) {
            stockElement.textContent = `Stock: ${stockData[id]}`;
        }
    }
}

function cancelarAccesorio(idAccesorio) {
    let stockData = JSON.parse(localStorage.getItem('stockAccesorios')) || {};
    stockData[idAccesorio] = 0;
    localStorage.setItem('stockAccesorios', JSON.stringify(stockData));
    let stockElement = document.getElementById(`stock-${idAccesorio}`);
    if (stockElement) {
        stockElement.textContent = `Stock: 0`;
    }
}
</script>


    <!-- Tarjeta de Agregar Nueva Gafa de Sol -->
    <div class="producto-card">
        <img src="../IMAGENES/mas.png" alt="Agregar nueva gafa de sol" class="producto-imagen">
        <div class="producto-info">
            <h3 class="producto-nombre">Agregar Nuevo Cinturon</h3>
            <div class="acciones">
                <button class="btn-agregar" onclick="window.location.href='../FORMULARIO_INSER_CAMISETAS/FORMULARIO_ACCESORIOS.PHP'">Agregar</button>
            </div>
        </div>
    </div>
</div>

<?php include('../INCLUDE/FOOTER.PHP'); ?>


<style>
/* Contenedor del catálogo */
.catalogo-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    padding: 20px;
}

/* Estilo de cada tarjeta de producto */
.producto-card {
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #fff;
}

.producto-imagen {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.producto-info {
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.producto-nombre {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}

.producto-color {
    font-size: 14px;
    color: #666;
}

.tallas-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin: 10px 0;
}

.talla-wrapper {
    text-align: center;
}

.talla {
    background-color: #f1f1f1;
    padding: 5px;
    border-radius: 5px;
    cursor: pointer;
}

.talla:hover {
    background-color: #ddd;
}

.botones-cantidad {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.btn-cantidad {
    background-color: #ddd;
    border: none;
    padding: 5px;
    cursor: pointer;
    border-radius: 5px;
}

.producto-precio {
    font-size: 16px;
    font-weight: bold;
    margin: 10px 0;
}

.producto-stock {
    font-size: 14px;
    color: #666;
}

.acciones {
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.btn-actualizar, .btn-eliminar {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}

.btn-actualizar:hover, .btn-eliminar:hover {
    background-color: #2980b9;
}

.acciones-cancelar {
    margin-top: 10px;
    text-align: center;
}

.btn-cancelar {
    font-size: 14px;
    padding: 5px 10px;
    background-color:rgb(168, 153, 152);
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.btn-cancelar:hover {
    background-color: #c0392b;
}
</style>









<style>
    .talla.sin-stock {
        text-decoration: line-through;
        color: red;
    }
</style>


<style>
.tallas-container {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.talla-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 60px;
    position: relative;
}

.talla {
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: bold;
    text-align: center;
    position: relative;
    width: 100%;
}

.cantidad {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff5722;
    color: white;
    font-size: 12px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.botones-cantidad {
    display: flex;
    gap: 5px;
    margin-top: 5px;
}

.btn-cantidad {
    background: #007bff;
    color: white;
    border: none;
    padding: 4px 6px;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
}

.btn-cantidad:hover {
    background: #0056b3;
}

.acciones {
    margin-top: 12px;
}

.btn-actualizar, .btn-eliminar {
    padding: 6px 12px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-actualizar {
    background: #28a745;
    color: white;
}

.btn-eliminar {
    background: #dc3545;
    color: white;
}

.btn-actualizar:hover {
    background: #218838;
}

.btn-eliminar:hover {
    background: #c82333;
}
</style>



<style>
/* Estilo general */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

/* Contenedor del catálogo */
.catalogo-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

/* Estilo de las tarjetas de producto */
.producto-card {
    width: 250px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    text-align: center;
}

.producto-imagen {
    width: 100%;
    height: auto;
    border-bottom: 1px solid #eee;
}

.producto-info {
    padding: 15px;
}

.producto-nombre {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.producto-color {
    color: #777;
}

.producto-precio, .producto-stock {
    font-size: 16px;
    margin-top: 10px;
}

/* Estilo de los botones de acción */
.acciones {
    margin-top: 20px;
}

button, .btn-eliminar {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-actualizar {
    background-color: #4CAF50;
    color: white;
    border: none;
    margin-right: 10px;
}

.btn-actualizar:hover {
    background-color: #45a049;
}

.btn-eliminar {
    background-color: #f44336;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
}

.btn-eliminar:hover {
    background-color: #e53935;
}

.btn-agregar {
    background-color: #1e88e5;
    color: white;
    border: none;
    margin-left: 58px;
}

.btn-agregar:hover {
    background-color: #1976d2;
}

/* Estilo para las tallas */
.tallas-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
}

.talla {
    padding: 8px 15px;
    background-color: #e0e0e0;
    border-radius: 20px;
    cursor: pointer;
}

.talla:hover {
    background-color: #bdbdbd;
}

/* Estilo para marcar una talla como agotada */
.agotado {
    text-decoration: line-through;
    color: red;
    cursor: not-allowed;
}
</style>

</body>
</html>
