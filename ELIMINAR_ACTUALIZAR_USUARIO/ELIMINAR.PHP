<?php
// Incluir el archivo de conexión a la base de datos
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar si se ha enviado una solicitud de eliminación
if (isset($_GET['ID'])) {
    $idUsuario = intval($_GET['ID']); // Asegurar que el ID sea un número entero

    // Eliminar los registros de detalle_factura asociados con la factura
    $queryEliminarDetalleFactura = "DELETE FROM detalle_factura WHERE ID_Factura IN (SELECT ID_Factura FROM factura WHERE ID_Cliente = $idUsuario)";
    $resultadoEliminarDetalleFactura = mysqli_query($conexion, $queryEliminarDetalleFactura);

    // Eliminar las facturas asociadas con el usuario
    $queryEliminarFacturas = "DELETE FROM factura WHERE ID_Cliente = $idUsuario";
    $resultadoEliminarFacturas = mysqli_query($conexion, $queryEliminarFacturas);

    // Verificar si la eliminación de facturas fue exitosa
    if ($resultadoEliminarFacturas && $resultadoEliminarDetalleFactura) {
        // Ahora eliminar el usuario
        $queryEliminarUsuario = "DELETE FROM usuario WHERE ID_Usuario = $idUsuario";
        $resultadoEliminarUsuario = mysqli_query($conexion, $queryEliminarUsuario);

        // Verificar si la eliminación del usuario fue exitosa
        if ($resultadoEliminarUsuario) {
            echo "<script>alert('Usuario, facturas y detalles eliminados exitosamente');</script>";
            echo "<script>window.location.href = '../ROLES/INTERFAZ_ADMINISTRADOR.PHP';</script>"; // Redirigir tras la eliminación
        } else {
            echo "<script>alert('Error al eliminar el usuario');</script>";
        }
    } else {
        echo "<script>alert('Error al eliminar las facturas o los detalles de la factura');</script>";
    }
}
?>
