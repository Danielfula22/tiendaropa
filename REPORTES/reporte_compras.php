<?php 
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Inicializar $searchTerm y $TOTAL_PAGINAS
$searchTerm = isset($_GET['TXTBUSCAR']) ? $_GET['TXTBUSCAR'] : ''; // Si no está definida, la inicializa como vacía.

$porPagina = 10; // Número de elementos por página
$pagina = isset($_GET['PAGINA']) ? (int)$_GET['PAGINA'] : 1; // Página actual, por defecto la primera.

$inicio = ($pagina - 1) * $porPagina; // Calcular el inicio de la consulta.

$consultaTotal = "SELECT COUNT(*) as total FROM compras";
$resultadoTotal = mysqli_query($conexion, $consultaTotal);
$rowTotal = mysqli_fetch_assoc($resultadoTotal);
$totalRegistros = $rowTotal['total'];
$TOTAL_PAGINAS = ceil($totalRegistros / $porPagina); // Calcular el total de páginas

// Consulta para obtener los datos filtrados y paginados
$consulta = "
    SELECT compras.*, tipo_pago.Nombre as TipoPagoNombre
    FROM compras
    LEFT JOIN tipo_pago ON compras.ID_Tipo_Pago = tipo_pago.ID_Tipo_Pago
    WHERE compras.ID_Compra LIKE '%$searchTerm%' OR compras.Nombre LIKE '%$searchTerm%' OR compras.Cedula LIKE '%$searchTerm%' OR compras.Email LIKE '%$searchTerm%'
    ORDER BY compras.ID_Compra DESC
    LIMIT $inicio, $porPagina
";
$ejecutar = mysqli_query($conexion, $consulta);
?>

<link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
<link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
<link href="../ESTILOS/responsiva.css" rel="stylesheet">
<link href="../estilos_importattt.css" rel="stylesheet">

<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>

<!-- Contenedor para el título y buscador -->
<div class="title-search-container">
    <div class="title-container">
        <h1>Reporte de Compras</h1>
        <hr class="linea-titulo">
    </div>
    <form method="get" action="" class="search-form">
        <input type="search" name="TXTBUSCAR" placeholder="Buscar por ID, Nombre, Cédula o Email..." class="search-input" value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <input type="submit" class="search-btn" name="buscar" value="Consultar">
        <button type="button" class="pdf-btn" onclick="window.location.href='../FACTURACION/pdf3.php';">
            <img src="../IMAGENES/pdf.png" alt="Descargar PDF">
        </button>
    </form>
</div>

<form method="POST" action="FINALIZARCOMPRA.PHP">
    <table class="styled-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Email</th>
                <th>Número de Teléfono</th>
                <th>Lugar de Envío</th>
                <th>Dirección de Entrega</th>
                <th>Tipo de Pago</th>
                <th>Total</th>
                <th>Productos Comprados</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($fila = mysqli_fetch_assoc($ejecutar)) {
                $idCompra = $fila['ID_Compra'];
                $tipoPagoNombre = $fila['TipoPagoNombre'];
                $nombre = $fila['Nombre'];
                $email = $fila['Email'];
                $cedula = $fila['Cedula'];
                $direccionEntrega = $fila['Direccion_Entrega'];
                $productosComprados = $fila['Productos_Comprados'];
                $total = $fila['Total'];
                $lugarEnvio = $fila['Lugar_Envio'];
                $telefono = $fila['Numero_Telefono'];
                $estado = $fila['Estado'] == 1 ? 'Activo' : 'Cancelado';

                $productos = explode(',', $productosComprados); // Convertir los productos a un arreglo
                $productosTexto = '';
                foreach ($productos as $producto) {
                    $productosTexto .= "<div class='producto-item'>" . htmlspecialchars($producto) . "</div>"; // Agregar productos a la lista con un formato más ordenado
                }
            ?>
            <tr>
                <td><?php echo htmlspecialchars($nombre); ?></td>
                <td><?php echo htmlspecialchars($cedula); ?></td>
                <td><?php echo htmlspecialchars($email); ?></td>
                <td><?php echo htmlspecialchars($telefono); ?></td>
                <td><?php echo htmlspecialchars($lugarEnvio); ?></td>
                <td><?php echo htmlspecialchars($direccionEntrega); ?></td>
                <td><?php echo htmlspecialchars($tipoPagoNombre); ?></td>
                <td><?php echo htmlspecialchars($total); ?></td>
                <td>
                    <button type="button" class="ver-mas-btn" onclick="toggleProductos('<?php echo $idCompra; ?>')">Ver más</button>
                    <div id="productos-<?php echo $idCompra; ?>" class="productos-desplegables" style="display:none;">
                        <div class="productos-contenido">
                            <?php echo $productosTexto; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $TOTAL_PAGINAS; $i++) { ?>
            <a href="?PAGINA=<?php echo $i; ?>&TXTBUSCAR=<?php echo urlencode($searchTerm); ?>" class="<?php echo $i == $pagina ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php } ?>
    </div>
</form>

<?php include('../INCLUDE/FOOTER.PHP'); ?>

<script>
function toggleProductos(idCompra) {
    var productosLista = document.getElementById('productos-' + idCompra);
    var botonVerMas = document.querySelector(`#productos-${idCompra}`).previousElementSibling;

    if (productosLista.style.display === 'none') {
        productosLista.style.display = 'block';
        botonVerMas.textContent = 'Ver menos';
    } else {
        productosLista.style.display = 'none';
        botonVerMas.textContent = 'Ver más';
    }
}
</script>

<style>
/* Contenedor para el título y el buscador */
.title-search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.title-container {
    display: inline-block;
}

.title-container h1 {
    margin: 0;
    font-size: 36px;
    color: #333;
    font-weight: bold;
}

.linea-titulo {
    border: 0;
    border-top: 4px solid #4CAF50;
    margin-top: 10px;
    width: 120px;
    margin-left: auto;
    margin-right: auto;
}

/* Estilo del formulario de búsqueda */
.search-form {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    align-items: center;
}

.search-input {
    padding: 10px;
    width: 250px;
    border: 1px solid #ccc;
    border-radius: 30px;
    font-size: 14px;
}

.search-btn {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.search-btn:hover {
    background-color: #45a049;
}

/* Botón PDF */
.pdf-btn {
    border: none;
    background: none;
    cursor: pointer;
    padding: 0;
}

.pdf-btn img {
    width: 40px;
    height: 40px;
}

/* Estilo de la tabla */
.styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 16px;
    min-width: 100%;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.styled-table thead tr {
    background-color: #4CAF50;
    color: #ffffff;
    text-align: left;
    font-weight: bold;
}

.styled-table th, .styled-table td {
    padding: 14px 20px;
    text-align: center;
}

.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f9f9f9;
}

.styled-table tbody tr:hover {
    background-color: #f1f1f1;
    transform: scale(1.02);
}

/* Estilo del botón "Ver más" */
.ver-mas-btn {
    background-color: #008CBA;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.ver-mas-btn:hover {
    background-color: #005f73;
}

.ver-mas-btn:focus {
    outline: none;
}

/* Estilo para el desplegable */
.productos-desplegables {
    margin-top: 10px;
    padding: 15px;
    background-color: #f3f3f3;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.productos-contenido {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.producto-item {
    background-color: #ffffff;
    padding: 12px;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
    transition: background-color 0.3s ease;
}

.producto-item:hover {
    background-color: #f1f1f1;
}

/* Estilo de la paginación */
.pagination {
    text-align: center;
    margin-top: 30px;
}

.pagination a {
    padding: 12px;
    margin: 0 8px;
    background-color: #4CAF50;
    color: white;
    border-radius: 30px;
    text-decoration: none;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.pagination a.active {
    background-color: #45a049;
}

.pagination a:hover {
    background-color: #45a049;
}
</style>
