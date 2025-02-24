<?php
// Conexión a la base de datos
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $productos = $_POST['productos'];
    $total = $_POST['total'];
    $id_tipo_pago = $_POST['id_tipo_pago'];

    $conn->begin_transaction();

    try {
        // Insertar datos de la compra en la tabla `compras`
        $sqlCompra = "INSERT INTO compras (id_usuario, total, id_tipo_pago) VALUES (?, ?, ?)";
        $stmtCompra = $conn->prepare($sqlCompra);
        $stmtCompra->bind_param("idi", $id_usuario, $total, $id_tipo_pago);
        $stmtCompra->execute();
        $id_compra = $stmtCompra->insert_id;

        // Procesar cada producto
        foreach ($productos as $producto) {
            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];
            $subtotal = $producto['total'];

            // Insertar detalles de la compra
            $sqlDetalle = "INSERT INTO detalle_compras (id_compra, id_producto, cantidad, subtotal) VALUES (?, ?, ?, ?)";
            $stmtDetalle = $conn->prepare($sqlDetalle);
            $stmtDetalle->bind_param("iiid", $id_compra, $id_producto, $cantidad, $subtotal);
            $stmtDetalle->execute();

            // Actualizar el stock del producto
            $sqlStock = "UPDATE productos SET stock = stock - ? WHERE id_producto = ?";
            $stmtStock = $conn->prepare($sqlStock);
            $stmtStock->bind_param("ii", $cantidad, $id_producto);
            $stmtStock->execute();

            if ($stmtStock->affected_rows === 0) {
                throw new Exception("Stock insuficiente para el producto ID: $id_producto");
            }
        }

        $conn->commit();
        echo "Compra realizada con éxito";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error al procesar la compra: " . $e->getMessage();
    }

    $stmtCompra->close();
    $stmtDetalle->close();
    $stmtStock->close();
    $conn->close();
}
?>
