<?php 
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Inicializar variables
$searchTerm = isset($_GET['TXTBUSCAR']) ? mysqli_real_escape_string($conexion, $_GET['TXTBUSCAR']) : ''; // Evitar inyecciones SQL
$porPagina = 10; // Elementos por página
$pagina = isset($_GET['PAGINA']) && is_numeric($_GET['PAGINA']) ? (int)$_GET['PAGINA'] : 1; // Página actual
$inicio = ($pagina - 1) * $porPagina; // Calcular el inicio de la consulta

// Obtener el total de registros
$consultaTotal = "SELECT COUNT(*) as total FROM compras";
$resultadoTotal = mysqli_query($conexion, $consultaTotal);
$rowTotal = mysqli_fetch_assoc($resultadoTotal);
$totalRegistros = $rowTotal['total'];
$TOTAL_PAGINAS = ceil($totalRegistros / $porPagina); // Calcular total de páginas

// Consulta para obtener datos paginados y filtrados
$consulta = "
    SELECT compras.*, tipo_pago.Nombre as TipoPagoNombre
    FROM compras
    LEFT JOIN tipo_pago ON compras.ID_Tipo_Pago = tipo_pago.ID_Tipo_Pago
    WHERE compras.ID_Compra LIKE '%$searchTerm%' OR compras.Nombre LIKE '%$searchTerm%'
    ORDER BY compras.ID_Compra DESC
    LIMIT $inicio, $porPagina
";
$ejecutar = mysqli_query($conexion, $consulta);

// Verificar si hay datos
if (!$ejecutar) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
<link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
<link href="../ESTILOS/responsiva.css" rel="stylesheet">
<link href="../ESTILOS/TABLA_ADMINISTRADOR.CSS" rel="stylesheet">
<link href="../estilos_importattt.css" rel="stylesheet">

<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>

<div class="title-container">
    <h1>COMPRAS ONLINE</h1>
    <hr>
</div>
<br>

<style>
    .ver-mas-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease, transform 0.3s ease;
        display: inline-block;
        margin-top: 5px;
    }

    .ver-mas-btn:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    .productos-lista {
        list-style-type: none;
        padding: 0;
        margin-top: 8px;
        font-size: 14px;
        color: #333;
        padding-left: 20px;
        border-left: 2px solid #ddd;
        background-color: #f9f9f9;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .productos-lista li {
        padding: 5px 0;
    }
</style>

<div class="search-bar-container">
    <form method="get" action="" class="search-form">
        <input type="search" name="TXTBUSCAR" placeholder="Buscar por ID o Nombre..." class="search-input" value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <input type="submit" class="search-btn" name="buscar" value="CONSULTAR">
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
                <th>Factura</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = mysqli_fetch_assoc($ejecutar)) {
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

                $productos = explode(',', $productosComprados);
                $productosTexto = '';
                foreach ($productos as $producto) {
                    $productosTexto .= "<li>$producto</li>";
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
                    <ul id="productos-<?php echo $idCompra; ?>" class="productos-lista" style="display:none;">
                        <?php echo $productosTexto; ?>
                    </ul>
                </td>
                <td>
                    <a href="pdf.php?compra=<?php echo $idCompra; ?>">
                        <img src="../IMAGENES/pdf.png" alt="pdf" width="30" height="30">
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $TOTAL_PAGINAS; $i++) { ?>
            <a href="?PAGINA=<?php echo $i; ?>&TXTBUSCAR=<?php echo urlencode($searchTerm); ?>" class="<?php echo $i == $pagina ? 'active' : 'page-link'; ?>"><?php echo $i; ?></a>
        <?php } ?>
    </div>

    <?php
    if (isset($_GET['cancelar'])) {
        $idCancelar = mysqli_real_escape_string($conexion, $_GET['cancelar']);
        $eliminar = "UPDATE compras SET Estado=0 WHERE ID_Compra='$idCancelar'";
        $ejecutar = mysqli_query($conexion, $eliminar);

        if ($ejecutar) {
            echo "<script>alert('Compra cancelada correctamente');</script>";
            echo "<script>window.open('FINALIZARCOMPRA.PHP', '_self');</script>";
        }
    }
    ?>
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
</body>
</html>
