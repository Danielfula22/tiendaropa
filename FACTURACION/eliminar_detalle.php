<?php 
    include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP'); 
?>

<?php
if (isset($_GET['eliminar'])) {
    // Capturar el ID del detalle de factura a eliminar
    $idDetalle = (int)$_GET['eliminar'];

    // Verificar si el ID es válido antes de proceder con la consulta
    if ($idDetalle > 0) {
        // Query para eliminar el registro de la tabla detalle_factura (asegúrate de que este nombre sea correcto)
        $eliminarDetalle = "DELETE FROM detalle_factura WHERE ID_Detalle_Factura = ?";
        
        // Preparar la consulta
        if ($stmt = mysqli_prepare($conexion, $eliminarDetalle)) {
            // Enlazar el parámetro
            mysqli_stmt_bind_param($stmt, "i", $idDetalle);
            
            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Producto eliminado correctamente.');</script>";
            } else {
                echo "<script>alert('Error al eliminar el producto: " . mysqli_error($conexion) . "');</script>";
            }

            // Cerrar la declaración
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Error al preparar la consulta.');</script>";
        }
    } else {
        echo "<script>alert('ID de producto no válido.');</script>";
    }

    // Redireccionar a la misma página para actualizar la tabla
    echo "<script>window.location.href='detalle_factura.php';</script>";
    exit();
}
?>
