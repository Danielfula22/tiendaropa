<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar que la conexión sea exitosa
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar si se ha pasado el parámetro ID
if (isset($_GET['ID'])) {
    $idprenda = intval($_GET['ID']); // Asegurarse de que sea un entero

    // Iniciar una transacción
    mysqli_begin_transaction($conexion);

    try {
        // Eliminar dependencias en detalle_factura
        $queryEliminarDetalle = "DELETE FROM detalle_factura WHERE ID_Prenda = $idprenda";
        $resultadoEliminarDetalle = mysqli_query($conexion, $queryEliminarDetalle);

        if (!$resultadoEliminarDetalle) {
            throw new Exception("Error al eliminar registros relacionados en detalle_factura: " . mysqli_error($conexion));
        }

        // Eliminar la prenda
        $queryEliminarPrenda = "DELETE FROM prenda WHERE ID_Prenda = $idprenda";
        $resultadoEliminarPrenda = mysqli_query($conexion, $queryEliminarPrenda);

        if (!$resultadoEliminarPrenda) {
            throw new Exception("Error al eliminar la prenda: " . mysqli_error($conexion));
        }

        // Confirmar la transacción
        mysqli_commit($conexion);
        echo "<script>alert('Prenda eliminada exitosamente');</script>";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        mysqli_rollback($conexion);
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }

    // Redirigir de vuelta a la página anterior
    echo "<script>window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
} else {
    echo "<script>alert('No se ha proporcionado un ID válido');</script>";
    echo "<script>window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
}
?>
