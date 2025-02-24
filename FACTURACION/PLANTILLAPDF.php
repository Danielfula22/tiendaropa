<?php
require_once("../fpdf/fpdf.php");
include('../CONEXION/CONEXION_BASE_DE_DATOS.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'FACTURA DE COMPRA', 0, 1, 'C');
        $this->Ln(5);

        // Información de la tienda
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(120, 5, utf8_decode('Dirección: CARRERA 12 N# 23-57'), 0, 1, 'L');
        $this->Cell(120, 5, utf8_decode('Teléfono: 3108180754'), 0, 1, 'L');
        $this->Cell(120, 5, utf8_decode('Nit: 12345'), 0, 1, 'L');
        $this->Cell(120, 5, 'Correo: TiendaRopa@gmail.com', 0, 1, 'L');
        $this->Ln(10);
    }

    function Body($factura, $cliente, $vendedor, $productos, $total)
    {
        $this->SetFont('Arial', '', 12);

        // Información de la factura
        $this->Cell(50, 10, 'Factura Nro:', 1);
        $this->Cell(0, 10, $factura['ID_Factura'], 1, 1);
        $this->Cell(50, 10, 'Fecha:', 1);
        $this->Cell(0, 10, $factura['Fecha'], 1, 1);
        $this->Cell(50, 10, 'Hora:', 1);
        $this->Cell(0, 10, $factura['Hora'], 1, 1);

        // Información del cliente
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Datos del Cliente', 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 10, 'Nombre:', 1);
        $this->Cell(0, 10, utf8_decode($cliente['Nombre_Cliente'] . ' ' . $cliente['Apellido_Cliente']), 1, 1);
        $this->Cell(50, 10, 'Correo:', 1);
        $this->Cell(0, 10, utf8_decode($cliente['Correo_Cliente']), 1, 1);

        // Información del vendedor
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Vendedor', 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 10, 'Nombre:', 1);
        $this->Cell(0, 10, utf8_decode($vendedor), 1, 1);

        // Detalle de productos
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Detalle de Productos', 0, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(80, 10, 'Producto', 1);
        $this->Cell(30, 10, 'Cantidad', 1);
        $this->Cell(40, 10, 'Precio Unitario', 1);
        $this->Cell(40, 10, 'Total', 1, 1);

        foreach ($productos as $producto) {
            $this->Cell(80, 10, utf8_decode($producto['Nombre']), 1);
            $this->Cell(30, 10, $producto['Cantidad'], 1, 0, 'C');
            $this->Cell(40, 10, number_format($producto['Valor'], 2), 1, 0, 'R');
            $this->Cell(40, 10, number_format($producto['ValorTotal'], 2), 1, 1, 'R');
        }

        // Total
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(150, 10, 'Total:', 1, 0, 'R');
        $this->Cell(40, 10, number_format($total, 2), 1, 1, 'R');
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(5, 10, utf8_decode('© Tienda de Ropa | Todos los derechos reservados'), 0, 0, 'L');
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
}

// Obtener datos de la factura
$facturaID = intval($_GET['factura']);
$queryFactura = "SELECT * FROM Factura WHERE ID_Factura = $facturaID";
$resultFactura = mysqli_query($conexion, $queryFactura);
$factura = mysqli_fetch_assoc($resultFactura);

// Obtener datos del cliente desde la tabla Usuario y Factura
$queryCliente = "SELECT Nombre_Cliente, Apellido_Cliente, Correo_Cliente 
                 FROM Factura
                 WHERE ID_Factura = $facturaID";
$resultCliente = mysqli_query($conexion, $queryCliente);
$cliente = mysqli_fetch_assoc($resultCliente);

// Obtener datos del vendedor
$vendedorID = $factura['ID_Vendedor'];
$queryVendedor = "SELECT Nombre FROM Usuario WHERE ID_Usuario = $vendedorID";
$resultVendedor = mysqli_query($conexion, $queryVendedor);
$vendedor = mysqli_fetch_assoc($resultVendedor)['Nombre'] ?? 'No disponible';

// Obtener detalle de productos con el precio desde DetalleFactura
$queryProductos = "SELECT p.Nombre, df.Cantidad, df.Valor, df.ValorTotal 
                   FROM DetalleFactura df
                   INNER JOIN Prenda p ON df.ID_Prenda = p.ID_Prenda
                   WHERE df.ID_Factura = $facturaID";
$resultProductos = mysqli_query($conexion, $queryProductos);

$productos = [];
while ($producto = mysqli_fetch_assoc($resultProductos)) {
    $productos[] = $producto;
}

// Calcular el total
$total = array_reduce($productos, function ($sum, $producto) {
    return $sum + $producto['ValorTotal']; // Utilizamos ValorTotal para calcular el total de la factura
}, 0);

// Generar PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Body($factura, $cliente, $vendedor, $productos, $total);
$pdf->Output();
