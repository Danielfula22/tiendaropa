<?php
// Incluir el archivo de conexión a la base de datos
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar que la conexión sea exitosa
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar si se ha pasado el parámetro ID
if (isset($_GET['id'])) {
    $idProveedor = intval($_GET['id']); // Asegurarse de que sea un entero

    // Preparar la consulta de eliminación
    $queryEliminar = "DELETE FROM proveedor WHERE ID_Proveedor = $idProveedor";
    $resultadoEliminar = mysqli_query($conexion, $queryEliminar);

    // Verificar si la eliminación fue exitosa
    if ($resultadoEliminar) {
        echo "<script>alert('Proveedor eliminado exitosamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar el proveedor');</script>";
    }

    // Redirigir de vuelta a la página de listado de proveedores
    echo "<script>window.location.href = '../PROVEEDORES/PROVEEDORES.PHP';</script>";
} else {
    echo "<script>alert('No se ha proporcionado un ID válido');</script>";
    echo "<script>window.location.href = '../PROVEEDORES/LISTADO_PROVEEDORES.PHP';</script>";
}
?>
