<?php
require_once '../dompdf/autoload.inc.php'; // Ruta a la biblioteca DOMPDF
use Dompdf\Dompdf;

session_start();
require_once("../CONEXION/CONEXION_BASE_DE_DATOS.php");

if (isset($_GET['factura'])) {
    $idFactura = (int)$_GET['factura'];

    // Consulta para obtener los datos de la factura, incluyendo el estado
    $sqlFactura = "SELECT F.ID_Factura, F.Fecha, F.Hora, F.Estado,
                          U.Nombre AS Nombre_Cliente, 
                          U.Apellido AS Apellido_Cliente,
                          U.N_Documento AS Documento_Cliente,
                          U.Correo AS Correo_Cliente,
                          U.Direccion AS Direccion_Cliente,
                          U.Ciudad AS Ciudad_Cliente,
                          U.Telefono AS Telefono_Cliente,
                          V.Nombre AS VENDEDOR,
                          U.Estado AS Estado_Cliente
                   FROM Factura F
                   JOIN Usuario U ON F.ID_Cliente = U.ID_Usuario
                   JOIN Usuario V ON F.ID_Vendedor = V.ID_Usuario
                   WHERE F.ID_Factura = $idFactura";
    $resultadoFactura = mysqli_query($conexion, $sqlFactura);

    // Verifica si la factura existe
    if (!$resultadoFactura || mysqli_num_rows($resultadoFactura) == 0) {
        die("No se encontraron datos para la factura solicitada.");
    }

    $factura = mysqli_fetch_assoc($resultadoFactura);

    // Consulta para obtener el detalle de la factura
    $sqlDetalle = "SELECT 
                       CASE 
                           WHEN DF.ID_Prenda IS NOT NULL THEN P.Nombre
                           WHEN DF.ID_Accesorio IS NOT NULL THEN A.Nombre
                       END AS NOMBRE,
                       CASE 
                           WHEN DF.ID_Prenda IS NOT NULL THEN 'Prenda'
                           WHEN DF.ID_Accesorio IS NOT NULL THEN 'Accesorio'
                       END AS TIPO,
                       DF.Cantidad, 
                       DF.Precio_unitario AS VALOR_UNITARIO
                   FROM Detalle_Factura DF
                   LEFT JOIN Prenda P ON DF.ID_Prenda = P.ID_Prenda
                   LEFT JOIN Accesorio A ON DF.ID_Accesorio = A.ID_Accesorio
                   WHERE DF.ID_Factura = $idFactura";
    $resultadoDetalle = mysqli_query($conexion, $sqlDetalle);

    // Inicializar variable para el total
    $totalFactura = 0;

    // Datos predeterminados de la tienda
    $nombreTienda = "MAFE";
    $direccionTienda = "Carrera 7, Guateque";
    $nitTienda = "23623366-B";

    // Generar HTML de la factura
    ob_start(); // Capturar salida HTML
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .container {
                width: 90%;
                max-width: 1000px;
                margin: 30px auto;
                padding: 30px;
                background-color: #fff;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                border: 1px solid #ddd;
            }
            .header {
                text-align: center;
                margin-bottom: 40px;
                padding-bottom: 10px;
                border-bottom: 2px solid #ddd;
            }
            .header h1 {
                color: #6f4f2f;
                font-size: 36px;
                margin-bottom: 10px;
                font-weight: bold;
            }
            .header h2 {
                color: #333;
                font-size: 26px;
                font-weight: normal;
                margin-top: 5px;
            }
            .section-title {
                font-size: 20px;
                font-weight: bold;
                color: #6f4f2f;
                margin-bottom: 10px;
                border-bottom: 2px solid #6f4f2f;
                padding-bottom: 5px;
                margin-top: 20px;
            }
            .details p, .vendor-info p {
                font-size: 16px;
                color: #555;
                margin: 6px 0;
                line-height: 1.6;
            }
            .table-container {
                width: 100%;
                margin-top: 20px;
                border-collapse: collapse;
            }
            .table-container th, .table-container td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }
            .table-container th {
                background-color: #6f4f2f;
                color: white;
            }
            .table-container td {
                color: #555;
            }
            .table-container tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            .total {
                text-align: right;
                font-size: 18px;
                margin-top: 20px;
                font-weight: bold;
            }
            .address-info {
                text-align: center;
                font-size: 14px;
                margin-top: 20px;
            }
            .address-info table {
                width: 100%;
                text-align: center;
                margin-top: 10px;
                border: none;
            }
            .address-info td {
                padding: 5px;
                width: 33%;
                font-size: 14px;
                color: #555;
            }
            /* Estilo para el número de factura */
            .factura-no {
                font-family: 'Courier New', Courier, monospace;
                font-size: 22px;
                font-weight: bold;
                color: #1a1a1a;
                margin-top: 10px;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1><?php echo $nombreTienda; ?></h1>
            <div class="factura-no">Factura No.: <?php echo 'FAC' . str_pad($factura['ID_Factura'], 8, '0', STR_PAD_LEFT); ?></div>
            <div class="address-info">
                <table>
                    <tr>
                        <td><?php echo $direccionTienda; ?></td>
                        <td>NIT: <?php echo $nitTienda; ?></td>
                        <td>Fecha: <?php echo $factura['Fecha']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="details">
            <div class="section-title">Datos del Cliente</div>
            <p><strong>Nombre:</strong> <?php echo $factura['Nombre_Cliente'] . " " . $factura['Apellido_Cliente']; ?></p>
            <p><strong>Documento:</strong> <?php echo $factura['Documento_Cliente']; ?></p>
            <p><strong>Correo:</strong> <?php echo $factura['Correo_Cliente']; ?></p>
            <p><strong>Dirección:</strong> <?php echo $factura['Direccion_Cliente']; ?></p>
            <p><strong>Ciudad:</strong> <?php echo $factura['Ciudad_Cliente']; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $factura['Telefono_Cliente']; ?></p>
            <p><strong>Estado:</strong> <?php echo $factura['Estado_Cliente'] == 'Activo' ? 'Activo' : 'Inactivo'; ?></p>
        </div>

        <div class="vendor-info">
            <div class="section-title">Vendedor</div>
            <p><strong>Vendedor:</strong> <?php echo $factura['VENDEDOR']; ?></p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Valor Unitario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($detalle = mysqli_fetch_assoc($resultadoDetalle)) {
                        $totalFactura += $detalle['Cantidad'] * $detalle['VALOR_UNITARIO'];
                    ?>
                    <tr>
                        <td><?php echo $detalle['NOMBRE']; ?></td>
                        <td><?php echo $detalle['TIPO']; ?></td>
                        <td><?php echo $detalle['Cantidad']; ?></td>
                        <td>$<?php echo number_format($detalle['VALOR_UNITARIO'], 2); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="total">
            <p><strong>Total: $<?php echo number_format($totalFactura, 2); ?></strong></p>
        </div>
    </div>
    </body>
    </html>

    <?php
    $html = ob_get_clean();

    // Generar PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->render();

    // Mostrar el PDF
    $dompdf->stream("factura_$idFactura.pdf", array("Attachment" => 0));
}
?>
