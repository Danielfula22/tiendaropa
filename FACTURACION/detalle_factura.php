<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facturación - Detalle Factura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e9ecef;
        }
        .container {
            max-width: 900px;
            margin-top: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .btn-custom {
            width: 100%;
        }
        .total-factura {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

<?php 
    include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP'); 
    include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); 
?>

<div class="container">
    <h2 class="text-center mb-4">Facturación - Detalle Factura</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar Producto</div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="txtBuscarID" class="form-label">Buscar por ID:</label>
                            <input type="text" id="txtBuscarID" class="form-control" placeholder="Ingrese ID de la prenda">
                        </div>
                        <div class="mb-3">
                            <label for="selectProducto" class="form-label">Producto:</label>
                            <select name="selectProducto" id="selectProducto" class="form-select">
                                <optgroup label="Prendas">
                                    <?php
                                    $consultaPrenda = "SELECT * FROM Prenda";
                                    $ejecutarPrenda = mysqli_query($conexion, $consultaPrenda);
                                    while ($res = mysqli_fetch_assoc($ejecutarPrenda)) {
                                        $stock = ($res['Stock'] === 'sin limite') ? 'sin limite' : $res['Stock'];
                                        echo "<option value='prenda-{$res['ID_Prenda']}' data-stock='{$stock}'>
                                            {$res['Nombre']} - {$res['Talla']} - $ {$res['Costo']} (Stock: {$stock})
                                        </option>";
                                    }
                                    ?>
                                </optgroup>
                                <optgroup label="Accesorios">
                                    <?php
                                    $consultaAccesorio = "SELECT * FROM Accesorio";
                                    $ejecutarAccesorio = mysqli_query($conexion, $consultaAccesorio);
                                    while ($res = mysqli_fetch_assoc($ejecutarAccesorio)) {
                                        echo "<option value='accesorio-{$res['ID_Accesorio']}'>
                                            {$res['Nombre']} - $ {$res['Costo']}
                                        </option>";
                                    }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="txtCantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="txtCantidad" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="txtTalla" class="form-label">Talla:</label>
                            <input type="text" name="txtTalla" class="form-control" id="txtTalla">
                        </div>
                        <button type="submit" name="txtInsertarProducto" class="btn btn-success btn-custom">Agregar Producto</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <img src="../IMAGENES/procesar.jpg" alt="Imagen decorativa" class="img-fluid rounded">
        </div>
    </div>

    <script>
        document.getElementById("txtBuscarID").addEventListener("input", function() {
            let buscarID = this.value.toLowerCase();
            let opciones = document.getElementById("selectProducto").options;
            
            for (let i = 0; i < opciones.length; i++) {
                if (opciones[i].value.includes(`prenda-${buscarID}`)) {
                    opciones[i].selected = true;
                    break;
                }
            }
        });
    </script>
</div>



    <?php
    if (isset($_POST['txtInsertarProducto'])) {
        list($tipo, $idProducto) = explode("-", $_POST['selectProducto']);
        $cantidad = $_POST['txtCantidad'];
        $talla = $_POST['txtTalla'];

        if ($tipo === 'prenda') {
            $sqlStock = "SELECT Stock, Costo FROM Prenda WHERE ID_Prenda = $idProducto";
        } else {
            $sqlStock = "SELECT Costo FROM Accesorio WHERE ID_Accesorio = $idProducto";
        }

        $ejecutarStock = mysqli_query($conexion, $sqlStock);
        $producto = mysqli_fetch_assoc($ejecutarStock);
        $precio = $producto['Costo'];
        $stockDisponible = isset($producto['Stock']) && strtolower($producto['Stock']) !== 'sin limite' ? intval($producto['Stock']) : 'sin limite';

        if ($tipo === 'prenda' && $stockDisponible !== 'sin limite' && $stockDisponible < $cantidad) {
            echo "<script>alert('No hay suficiente stock disponible. Stock actual: $stockDisponible');</script>";
        } else {
            $subtotal = $precio * $cantidad;
            $sqlUltimaFactura = "SELECT MAX(ID_Factura) AS ID_Factura FROM Factura";
            $ejecutarFactura = mysqli_query($conexion, $sqlUltimaFactura);
            $factura = mysqli_fetch_assoc($ejecutarFactura);
            $idFactura = $factura['ID_Factura'];

            $insertDetalle = "INSERT INTO detalle_factura (ID_Factura, " . ($tipo === 'prenda' ? "ID_Prenda" : "ID_Accesorio") . ", Cantidad, Precio_unitario, Subtotal, Talla) 
                              VALUES ($idFactura, $idProducto, $cantidad, $precio, $subtotal, '$talla')";
            mysqli_query($conexion, $insertDetalle);

            if ($tipo === 'prenda' && $stockDisponible !== 'sin limite') {
                $nuevoStock = $stockDisponible - $cantidad;
                $updateStock = "UPDATE Prenda SET Stock = $nuevoStock WHERE ID_Prenda = $idProducto";
                mysqli_query($conexion, $updateStock);
            }

            echo "<script>window.open('detalle_factura.php', '_self');</script>";
        }
    }
    ?>
</div>

<h2 class="text-center mt-4">Productos Agregados</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Talla</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar si se quiere eliminar un producto
                if (isset($_GET['eliminar'])) {
                    $idEliminar = mysqli_real_escape_string($conexion, $_GET['eliminar']);
                    $eliminarQuery = "DELETE FROM detalle_factura WHERE ID_Detalle_factura = '$idEliminar'";
                    mysqli_query($conexion, $eliminarQuery);
                    echo "<script>window.location.href = window.location.pathname;</script>"; // Recargar la página
                }

                // Consultar los productos agregados en la última factura
                $consultaDetalles = "SELECT DF.*, COALESCE(P.Nombre, A.Nombre) AS NombreProducto FROM detalle_factura DF 
                                     LEFT JOIN Prenda P ON DF.ID_Prenda = P.ID_Prenda 
                                     LEFT JOIN Accesorio A ON DF.ID_Accesorio = A.ID_Accesorio 
                                     WHERE DF.ID_Factura = (SELECT MAX(ID_Factura) FROM Factura)";
                $ejecutarDetalles = mysqli_query($conexion, $consultaDetalles);
                
                while ($detalle = mysqli_fetch_assoc($ejecutarDetalles)) {
                    echo "<tr>
                        <td>{$detalle['ID_Detalle_factura']}</td>
                        <td>{$detalle['NombreProducto']}</td>
                        <td>{$detalle['Cantidad']}</td>
                        <td>{$detalle['Talla']}</td>
                        <td>\${$detalle['Precio_unitario']}</td>
                        <td>\${$detalle['Subtotal']}</td>
                        <td><a href='?eliminar={$detalle['ID_Detalle_factura']}' class='btn btn-danger btn-sm'>Eliminar</a></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between mt-4">
    <a href="../FACTURACION/finalizarfactu.php" class="btn btn-primary">Finalizar Factura</a>
    <a href="../FACTURACION/cancelar_factura.php" class="btn btn-warning">Cancelar Factura</a>
</div>

<?php 
    include('../INCLUDE/FOOTER.PHP');
?>


</body>
</html>
