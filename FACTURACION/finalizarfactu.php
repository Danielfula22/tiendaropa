<?php 
ob_start(); // Iniciar el buffer de salida

include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP'); 
include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); 

// Configuración para la paginación
$por_pagina = 8;  // Cantidad de resultados por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Página actual
$inicio = ($pagina - 1) * $por_pagina; // Definir el inicio de los resultados

// Comprobar si se está realizando una búsqueda
$buscar = isset($_GET['buscar']) ? mysqli_real_escape_string($conexion, $_GET['buscar']) : '';

// Consulta principal para obtener las facturas
$consulta = "
    SELECT F.ID_Factura, F.Fecha, 
           CONCAT(U.Nombre, ' ', U.Apellido) AS Cliente,
           (SELECT SUM(Cantidad * Precio_unitario) 
            FROM detalle_factura DF 
            WHERE DF.ID_Factura = F.ID_Factura) AS TotalFactura,
           F.ID_Vendedor, F.Estado AS EstadoFactura, U.Estado AS EstadoUsuario
    FROM Factura F
    LEFT JOIN Usuario U ON F.ID_Cliente = U.ID_Usuario
    WHERE CONCAT(U.Nombre, ' ', U.Apellido) LIKE '%$buscar%'
    ORDER BY F.ID_Factura DESC
    LIMIT $inicio, $por_pagina";

$ejecutar = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
    <link href="../estilos_importattt.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            background-color: #f8f9fa;
        }
        /* Estilos para el título y buscador */
        .title-search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .title-container h1 {
            font-size: 37px;
            font-weight: bold;
        }
        .title-container hr {
            border: 3px solid #004085; /* Línea azul oscura */
            width: 100%;
        }
        .search-bar {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 250px;
        }
        .search-btn {
            padding: 6px 12px;
            border-radius: 4px;
            background-color: #28a745; /* Botón de color verde claro */
            color: white;
            border: none;
        }
        .search-btn:hover {
            background-color: #218838;
        }
        /* Otros estilos generales */
        .badge-success {
            background-color: #28a745 !important;
        }
        .badge-danger {
            background-color: #dc3545 !important;
        }
        .pagination-container a.active {
            background-color: #007bff;
            color: white;
            border: none;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="title-search-container">
        <div class="title-container">
            <h1>LISTA DE FACTURAS</h1>
                            <hr> <!-- Línea azul oscura -->
        </div>
        <form method="GET" action="" style="display: flex; align-items: center;">
            <input type="text" class="search-bar" name="buscar" placeholder="Buscar factura..." value="<?php echo htmlspecialchars($buscar); ?>">
            <button type="submit" class="search-btn">Buscar</button>
        </form>
    </div>

    <div class="table-container">
        <form method="POST" action="">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Estado Cliente</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($ejecutar) {
                            while ($fila = mysqli_fetch_assoc($ejecutar)) {
                                $idf = $fila['ID_Factura'];
                                $fecha = $fila['Fecha'] ?? 'No disponible';
                                $cliente = $fila['Cliente'] ?? 'Sin nombre';
                                $total_factura = $fila['TotalFactura'] ?? 0;
                                $id_vendedor = $fila['ID_Vendedor'] ?? null;
                                $estado_factura = $fila['EstadoFactura'] ?? 'Desconocido';
                                $estado_usuario = $fila['EstadoUsuario'] ?? 'Activo';

                                if ($estado_usuario === 'Inactivo') {
                                    $estado_usuario = 'Activo';
                                }

                                if ($estado_factura === 'Anulado') {
                                    $estado_usuario = 'Anulado';
                                }
                    ?>
                    <tr>
                        <td>
                            <span class="badge badge-<?php echo $estado_usuario === 'Anulado' ? 'danger' : 'success'; ?>">
                                <?php echo htmlspecialchars($estado_usuario); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($cliente); ?></td>
                        <td>$<?php echo number_format($total_factura, 2); ?></td>
                        <td>
                            <?php
                                if ($id_vendedor) {
                                    $sub_sql_2 = "SELECT Nombre FROM Usuario WHERE ID_Usuario = $id_vendedor";
                                    $execute = mysqli_query($conexion, $sub_sql_2);
                                    if ($execute && $usuario = mysqli_fetch_assoc($execute)) {
                                        echo htmlspecialchars($usuario['Nombre']);
                                    } else {
                                        echo "Usuario no encontrado";
                                    }
                                } else {
                                    echo "No disponible";
                                }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($fecha); ?></td>
                        <td class="btn-actions">
                            <?php if ($estado_factura !== 'Anulado') { ?>
                                <a onClick="return confirm('¿Estás seguro de anular esta factura?');" 
                                   href="finalizarfactu.php?anular=<?php echo urlencode($idf); ?>" 
                                   class="btn btn-danger btn-sm">Anular</a>
                            <?php } else { ?>
                                <span class="btn btn-secondary btn-sm" disabled>Anulada</span>
                            <?php } ?>
                            <a href="../FACTURACION/pdf2.php?factura=<?php echo urlencode($idf); ?>&cliente=<?php echo urlencode($cliente); ?>&estado=<?php echo urlencode($estado_factura); ?>" 
                               class="btn btn-info btn-sm">PDF</a>
                        </td>
                    </tr>
                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No se encontraron facturas</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
    <center>
        <div class="pagination-container">
            <?php
                $consulta_total = "SELECT COUNT(*) AS total FROM Factura F";
                $resultado_total = mysqli_query($conexion, $consulta_total);
                $total_filas = mysqli_fetch_assoc($resultado_total)['total'];
                $total_paginas = ceil($total_filas / $por_pagina);

                for ($i = 1; $i <= $total_paginas; $i++) {
                    $active_class = $i == $pagina ? 'active' : '';
                    echo "<a href='finalizarfactu.php?pagina=$i' class='btn btn-secondary btn-sm mx-1 $active_class'>" . $i . "</a>";
                }
            ?>
        </div>
    </center>
</div>

<?php include('../INCLUDE/FOOTER.PHP'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($_GET['anular'])) {
    $factura_id = $_GET['anular'];
    $query = "UPDATE Factura SET Estado = 'Anulado' WHERE ID_Factura = $factura_id";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        header("Location: finalizarfactu.php?anulada=1&factura_id=" . urlencode($factura_id));
        exit();
    } else {
        echo "<script>alert('Error al anular la factura. Inténtalo nuevamente.');</script>";
    }
}
ob_end_flush();
?>
