<?php
require_once '../dompdf/autoload.inc.php'; // Ruta a la biblioteca Dompdf
use Dompdf\Dompdf;

session_start();
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Consulta para obtener los datos de todas las compras
$sql = "SELECT 
            ID_Usuario,
            ID_Tipo_Pago,
            Nombre,
            Email,
            Cedula,
            Direccion_Entrega,
            Productos_Comprados,
            Total,
            Lugar_Envio,
            Estado,
            Numero_Telefono
        FROM compras";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Generar HTML para el PDF
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compras</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            font-size: 12px;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .table-container {
            width: 95%;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .estado-activo {
            color: green;
            font-weight: bold;
        }
        .estado-cancelado {
            color: red;
            font-weight: bold;
        }
        .productos-lista {
            padding: 8px;
            background-color: #f9f9f9;
            border: 1px dashed #ccc;
            margin-bottom: 10px;
        }
        .productos-lista span {
            display: block;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <h1>Reporte de Compras</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre Cliente</th>
                    <th>Email</th>
                    <th>Cédula</th>
                    <th>Teléfono</th>
                    <th>Dirección de Entrega</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>';

// Agregar los datos de las compras al HTML
while ($fila = mysqli_fetch_assoc($resultado)) {
    $nombre = $fila['Nombre'];
    $email = $fila['Email'];
    $cedula = $fila['Cedula'];
    $telefono = $fila['Numero_Telefono'];
    $direccionEntrega = $fila['Direccion_Entrega'];
    $productosComprados = json_decode($fila['Productos_Comprados'], true);
    $total = $fila['Total'];
    $estado = $fila['Estado'] == 1 ? '<span class="estado-activo">Activo</span>' : '<span class="estado-cancelado">Cancelado</span>';

    $productosHTML = '<div class="productos-lista">';
    if (is_array($productosComprados)) {
        foreach ($productosComprados as $producto) {
            $productosHTML .= '<span><strong>Producto:</strong> ' . htmlspecialchars($producto['nombre']) . ' | <strong>Precio:</strong> $' . number_format($producto['precio'], 2) . '</span>';
        }
    } else {
        $productosHTML .= '<span>Información de productos no disponible</span>';
    }
    $productosHTML .= '</div>';

    $html .= '
    <tr>
        <td>' . htmlspecialchars($nombre) . '</td>
        <td>' . htmlspecialchars($email) . '</td>
        <td>' . htmlspecialchars($cedula) . '</td>
        <td>' . htmlspecialchars($telefono) . '</td>
        <td>' . htmlspecialchars($direccionEntrega) . '</td>
        <td>' . $productosHTML . '</td>
        <td>$' . number_format($total, 2) . '</td>
        <td>' . $estado . '</td>
    </tr>';
}

$html .= '
            </tbody>
        </table>
    </div>
</body>
</html>';

// Generar el PDF con Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // Formato apaisado
$dompdf->render();
$dompdf->stream("Reporte_Compras.pdf", array("Attachment" => false));
exit;
?>
