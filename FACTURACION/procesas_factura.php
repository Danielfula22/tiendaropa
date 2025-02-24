<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <title>Generar Factura</title>
</head>
<body>
    <?php include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP'); ?>

    <!-- Botón para abrir la ventana emergente -->
    <div class="container mt-5">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#facturaModal">Generar Factura</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="facturaModal" tabindex="-1" aria-labelledby="facturaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="facturaModalLabel">Generar Factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="facturaForm" method="POST" action="">
                        <!-- Formulario de datos -->
                        <div class="form-group">
                            <label for="ID_USUARIO">ID Cliente</label>
                            <input type="text" class="form-control" name="ID_USUARIO" required>
                        </div>
                        <div class="form-group">
                            <label for="FECHA">Fecha</label>
                            <input type="date" class="form-control" name="FECHA" required>
                        </div>
                        <div class="form-group">
                            <label for="ID_VENDEDOR">ID Vendedor</label>
                            <input type="text" class="form-control" name="ID_VENDEDOR" required>
                        </div>
                        <div class="form-group">
                            <label for="OBSERVACIONES">Observaciones</label>
                            <textarea class="form-control" name="OBSERVACIONES"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="TOTAL">Total</label>
                            <input type="number" class="form-control" name="TOTAL" required>
                        </div>
                        <button type="submit" class="btn btn-success">Generar Factura</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Manejo del formulario en PHP -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Datos obtenidos del formulario
        $id_cliente = $_POST['ID_USUARIO'] ?? null;
        $fecha = $_POST['FECHA'] ?? null;
        $hora = date('H:i:s');
        $id_vendedor = $_POST['ID_VENDEDOR'] ?? null;
        $observaciones = $_POST['OBSERVACIONES'] ?? '';
        $total = $_POST['TOTAL'] ?? 0;

        // Datos predeterminados
        $id_tienda = 1; // Suponemos que tienes una tienda fija
        $nit = "900123456"; // Cambia este valor si es necesario
        $id_tipo_pago = 1; // Cambia este valor si usas diferentes tipos de pago

        // Verificamos la conexión a la base de datos
        if ($conexion) {
            $sql = "INSERT INTO Factura (
                        ID_Tienda, NIT, Fecha, Hora, ID_Cliente, 
                        ID_Vendedor, ID_Tipo_Pago, Observaciones, Total
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            if ($stmt) {
                // Asignamos parámetros y ejecutamos la consulta
                $stmt->bind_param(
                    'issssissi',
                    $id_tienda, $nit, $fecha, $hora, $id_cliente, 
                    $id_vendedor, $id_tipo_pago, $observaciones, $total
                );

                if ($stmt->execute()) {
                    echo "<script>alert('Factura generada con éxito');</script>";
                    echo "<script>window.location.href = '../FACTURACION/detalle_factura.php';</script>";
                } else {
                    echo "<script>alert('Error al generar la factura: {$stmt->error}');</script>";
                }
            } else {
                echo "<script>alert('Error al preparar la consulta: {$conexion->error}');</script>";
            }
        } else {
            echo "<script>alert('Error de conexión a la base de datos');</script>";
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
