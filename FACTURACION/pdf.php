<?php
require_once '../dompdf/autoload.inc.php'; // Ruta a la biblioteca Dompdf
use Dompdf\Dompdf;

session_start();
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (isset($_GET['compra'])) {
    $idCompra = $_GET['compra'];

    // Consulta para obtener los datos de la compra
    $sql = "SELECT * FROM compras WHERE ID_Compra = '$idCompra'";
    $resultado = mysqli_query($conexion, $sql);
    $compra = mysqli_fetch_assoc($resultado);

    // Consulta para obtener los datos de la tienda
    $sqlTienda = "SELECT * FROM tienda LIMIT 1";
    $resultadoTienda = mysqli_query($conexion, $sqlTienda);
    $tienda = mysqli_fetch_assoc($resultadoTienda);

    if ($compra && $tienda) {
        // Asignar variables desde la base de datos
        $numeroFactura = "FAC-" . str_pad($idCompra, 8, "0", STR_PAD_LEFT);
        $nombre = $compra['Nombre'];
        $email = $compra['Email'];
        $cedula = $compra['Cedula'];
        $direccion = $compra['Direccion_Entrega'];
        $productos = $compra['Productos_Comprados'];
        $total = $compra['Total'];
        $estado = $compra['Estado'] == 1 ? 'Activo' : 'Cancelado';
        $telefono = $compra['Numero_Telefono'];
        $fechaExpedicion = date("d-m-Y");
        
        $nombreTienda = $tienda['Nombre'];
        $direccionTienda = $tienda['Direccion'];
        $ciudadTienda = $tienda['Ciudad'];
        $nitTienda = $tienda['NIT'];

        // Generar HTML
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Factura Electrónica</title>
            <style>
                body {
                    font-family: "Courier New", monospace;
                    font-size: 12px;
                    margin: 0;
                    padding: 0;
                    background-color: #ffffff; /* Fondo blanco */
                    color: #333;
                }
                .ticket {
                    max-width: 300px;
                    margin: auto;
                    padding: 20px;
                    background-color: #fff;
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                }
                .ticket-header {
                    text-align: center;
                    margin-bottom: 15px;
                }
                .ticket-header h2 {
                    font-size: 16px;
                    margin: 5px 0;
                }
                .ticket-section {
                    margin-bottom: 15px;
                    border-bottom: 1px solid #ccc;
                    padding-bottom: 10px;
                }
                .ticket-section:last-of-type {
                    border-bottom: none;
                }
                .ticket-section h3 {
                    font-size: 14px;
                    margin-bottom: 10px;
                    text-decoration: underline;
                }
                .ticket-info p {
                    margin: 3px 0;
                    line-height: 1.4;
                }
                .ticket-products table {
                    width: 100%;
                    border-collapse: collapse;
                }
                .ticket-products th, .ticket-products td {
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                    padding: 5px;
                }
                .ticket-products th {
                    background-color: #f2e7d5;
                }
                .ticket-products td {
                    font-size: 12px;
                }
                .ticket-footer {
                    text-align: center;
                    margin-top: 15px;
                    font-size: 10px;
                }
                .total {
                    text-align: right;
                    font-size: 14px;
                    font-weight: bold;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="ticket">
                <div class="ticket-header">
                    <h2>' . htmlspecialchars($nombreTienda) . '</h2>
                    <p>' . htmlspecialchars($direccionTienda) . ', ' . htmlspecialchars($ciudadTienda) . '</p>
                    <p><strong>NIT:</strong> ' . htmlspecialchars($nitTienda) . '</p>
                    <p><strong>Factura No.:</strong> ' . htmlspecialchars($numeroFactura) . '</p>
                    <p><strong>Fecha:</strong> ' . htmlspecialchars($fechaExpedicion) . '</p>
                </div>
                <div class="ticket-section">
                    <h3>Información del Cliente</h3>
                    <p><strong>Cliente:</strong> ' . htmlspecialchars($nombre) . '</p>
                    <p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
                    <p><strong>Teléfono:</strong> ' . htmlspecialchars($telefono) . '</p>
                    <p><strong>Estado:</strong> ' . htmlspecialchars($estado) . '</p>
                </div>
                <div class="ticket-section">
                    <h3>Productos</h3>
                    <table class="ticket-products">
                        <thead>
                            <tr>
                                <th style="width: 70%;">Producto</th>
                                <th style="width: 30%;">Precio</th>
                            </tr>
                        </thead>
                        <tbody>';
        
        $productosArray = json_decode($productos, true);
        if ($productosArray) {
            foreach ($productosArray as $producto) {
                $html .= '
                <tr>
                    <td>' . htmlspecialchars($producto['nombre']) . '</td>
                    <td style="text-align: right;">$' . number_format($producto['precio'], 2) . '</td>
                </tr>';
            }
        } else {
            $html .= '
            <tr>
                <td colspan="2" style="text-align: center;">No hay productos</td>
            </tr>';
        }

        $html .= '
                        </tbody>
                    </table>
                </div>
                <div class="total">
                    <p>Total: $' . number_format($total, 2) . '</p>
                </div>
                <div class="ticket-footer">
                    <p>Gracias por su compra</p>
                    <p>© 2024 ' . htmlspecialchars($nombreTienda) . '</p>
                </div>
            </div>
        </body>
        </html>';

        // Generar PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper(array(0, 0, 226.77, 623.62), 'portrait'); // Tamaño personalizado estilo ticket
        $dompdf->render();
        $dompdf->stream("Factura_Electronica_$numeroFactura.pdf", array("Attachment" => false));
        exit;
    } else {
        echo "No se encontró la compra o los datos de la tienda.";
    }
} else {
    echo "ID de compra no válido.";
}
?>